<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Writer;

use InvalidArgumentException;
use KonstantinKuklin\DtoEntityConverter\WriteInterface;
use Zend\Code\Reflection\DocBlock\Tag\GenericTag;
use Zend\Code\Reflection\PropertyReflection;


class DtoWriter implements WriteInterface
{
    private $classListMetaData = [];
    //

    private $output = array();
    private $config = array();
    private $cursorList = array();

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
        return $this->output;
    }

    /**
     * {@inheritdoc}
     */
    public function init($object, $config)
    {
        $this->config = $config;

        $this->addClassMetaData($object);
    }

    /**
     * @param string $classPath
     */
    private function addClassMetaData($classPath)
    {
        if (is_object($classPath)) {
            $classPath = get_class($classPath);
        } elseif (!class_exists($classPath)) {
            throw new InvalidArgumentException(sprintf('Unknown class: [%s].', $classPath));
        }

        if (isset($this->classListMetaData[$classPath])) {
            return;
        }

        $propertyList = get_class_vars($classPath);
        foreach ($propertyList as $property => $defaultValue) {

            $propertyReflection = new PropertyReflection($classPath, $property);
            $docBlock = $propertyReflection->getDocBlock();
            if (!$docBlock) {
                throw new InvalidArgumentException(
                    sprintf('Unknown property type for [%s] in class: [%s].', $property, $classPath)
                );
            }
            /** @var GenericTag $tag */
            $tag = $docBlock->getTag('var');
            if (!$tag) {
                throw new InvalidArgumentException(
                    sprintf('The property "@var" not found for [%s] in class: [%s].', $property, $classPath)
                );
            }
            $content = $tag->getContent();
            $matches = [];
            preg_match('/^([a-zA-Z0-9\\\[\]]+)|/', $content, $matches);
            $type = ltrim($matches[1], '\\');
            $isCollection = false;
            if (substr($type, -2) === '[]') {
                $type = substr($type, 0, -2);
                $isCollection = true;
            }

            $this->addInfo($classPath, $property, $isCollection, $type);
            if (class_exists($classPath)) {
                $this->addClassMetaData($classPath);
            }
        }
    }

    private function addInfo($classPath, $property, $isCollection, $type)
    {
        if (!isset($this->classListMetaData[$classPath])) {
            $this->classListMetaData[$classPath] = [];
        }
        if (!isset($this->classListMetaData[$classPath][$property])) {
            $this->classListMetaData[$classPath][$property] = [];
        }

        $this->classListMetaData[$classPath][$property]['is_collection'] = $isCollection;
        $this->classListMetaData[$classPath][$property]['$type'] = $type;
    }
}