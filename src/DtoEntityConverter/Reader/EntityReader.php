<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Reader;

use KonstantinKuklin\DtoEntityConverter\ReadInterface;
use UnexpectedValueException;

class EntityReader implements ReadInterface
{
    private static $methodCache = array();

    /**
     * {@inheritdoc}
     */
    public function read($data)
    {
        if (isset(self::$methodCache[get_class($data)])) {
            $methodReal = self::$methodCache[get_class($data)][$field];

            return $data->$methodReal();
        }

        foreach (array($field, 'is' . $field, 'get' . $field) as $fieldRow) {
            if (!method_exists($data, $fieldRow)) {
                continue;
            }

            self::$methodCache[get_class($data)][$field] = $fieldRow;

            return $data->$fieldRow();
        }

        throw new UnexpectedValueException(
            sprintf('Field with key: [%s] was not found in object: [%s].', $field, get_class($data))
        );
    }
}