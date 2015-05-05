<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Writer;

use KonstantinKuklin\DtoEntityConverter\WriteInterface;

class EntityWriter implements WriteInterface
{

    /**
     * {@inheritdoc}
     */
    public function write($field, $value)
    {
        // TODO: Implement write() method.
    }

    /**
     * {@inheritdoc}
     */
    public function setCursor($key)
    {
        // TODO: Implement setCursor() method.
    }

    /**
     * {@inheritdoc}
     */
    public function backCursor()
    {
        // TODO: Implement backCursor() method.
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        // TODO: Implement dump() method.
    }

    /**
     * {@inheritdoc}
     */
    public function init($object, $config)
    {
        // TODO: Implement init() method.
    }
}