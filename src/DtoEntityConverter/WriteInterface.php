<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter;

/**
 * Interface WriteInterface
 */
interface WriteInterface
{
    /**
     * @param string $field
     * @param mixed  $value
     */
    public function write($field, $value);

    /**
     * @param string $key
     */
    public function setCursor($key);

    /**
     * @return void
     */
    public function backCursor();

    /**
     * @return mixed
     */
    public function dump();

    /**
     * @param mixed $object
     * @param array $config
     *
     * @return void
     */
    public function init($object, $config);
}