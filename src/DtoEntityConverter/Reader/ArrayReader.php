<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Reader;

use KonstantinKuklin\DtoEntityConverter\ReadInterface;

class ArrayReader implements ReadInterface
{
    /**
     * {@inheritdoc}
     */
    public function read($data)
    {
        foreach ($data as $key => $value) {
            yield $key => $value;
        }
    }
}