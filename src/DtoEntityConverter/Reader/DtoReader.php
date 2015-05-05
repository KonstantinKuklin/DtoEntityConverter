<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Reader;

use KonstantinKuklin\DtoEntityConverter\ReadInterface;
use UnexpectedValueException;

class DtoReader implements ReadInterface
{
    private static $attributeList = array();

    /**
     * {@inheritdoc}
     */
    public function read($data)
    {
        if (isset(self::$attributeList[get_class($data)])) {
            $attributeList = self::$attributeList[get_class($data)];
        } else {
            $attributeList = self::$attributeList[get_class($data)] = get_object_vars($data);
        }

        foreach ($attributeList as $key) {
            yield $key => $data->$key;
        }
    }
}