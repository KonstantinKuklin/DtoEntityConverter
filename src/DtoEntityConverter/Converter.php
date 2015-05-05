<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter;

class Converter
{
    /**
     * @var ReadInterface
     */
    private $from;

    /**
     * @var WriteInterface
     */
    private $toTemplate;

    /**
     * @var array
     */
    private $config;

    public function __construct(ReadInterface $from, WriteInterface $toTemplate, array $config = array())
    {
        $this->from = $from;
        $this->toTemplate = $toTemplate;
        $this->config = $config;
    }

    /**
     * @param mixed $data
     * @param mixed $object
     * @param array $config
     *
     * @return mixed
     */
    public function convert($data, $object, array $config = array())
    {
        $to = clone $this->toTemplate;
        $to->init($object, $config);

        if ($this->isCollection($data)) {
            $this->convertCollection($data, $to);
        } else {
            $this->convertElement($data, $to);
        }

        return $to->dump();
    }

    /**
     * @param mixed          $data
     * @param WriteInterface $to
     *
     * @return void
     */
    public function convertElement($data, WriteInterface $to)
    {
        foreach ($this->from->read($data) as $key => $value) {

            if ($this->isCollection($data)) {
                $to->setCursor($key);
                $this->convertCollection($value, $to);
                $to->backCursor();
            }

            if (is_array($value)) {
                $to->setCursor($key);
                $this->convertElement($value, $to);
                $to->backCursor();
            }

            $to->write($key, $value);
        }
    }

    /**
     * @param array          $dataList
     * @param WriteInterface $to
     *
     * @return void
     */
    public function convertCollection(array $dataList, WriteInterface $to)
    {
        foreach ($dataList as $key => $value) {
            $to->setCursor($key);

            $this->convertElement($value, $to);
        }
    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    private function isCollection($data)
    {
        $isCollection = (is_array($data) && isset($data[0]) && is_array($data[0]));

        return $isCollection;
    }
}