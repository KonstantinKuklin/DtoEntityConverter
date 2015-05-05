<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Writer;

use KonstantinKuklin\DtoEntityConverter\WriteInterface;

class ArrayWriter implements WriteInterface
{
    private $output = array();
    private $config = array();
    private $cursorList = array();

    /**
     * {@inheritdoc}
     */
    public function setCursor($key)
    {
        /** @var Callable $cursor */
        $cursor = end($this->cursorList);
        $output = &$cursor();
        if (!isset($output[$key])) {
            $output[$key] = array();
        }
        $newOutput = &$output[$key];

        $this->cursorList[] = function & () use (&$newOutput) {
            return $newOutput;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function backCursor()
    {
        end($this->cursorList);
        $currentCursor = key($this->cursorList);

        unset($this->cursorList[$currentCursor]);
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        return $this->output;
    }

    /**
     * {@inheritdoc}
     */
    public function init($object, $config)
    {
        $this->config = $config;
        $output = &$this->output;

        $this->cursorList[] = function & () use (&$output) {
            return $output;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function write($field, $value)
    {
        /** @var Callable $cursor */
        $cursor = end($this->cursorList);
        $output = &$cursor();
        $output[$field] = $value;
    }
}