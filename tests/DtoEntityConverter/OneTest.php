<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter\Tests;


use KonstantinKuklin\DtoEntityConverter\Chunk;
use KonstantinKuklin\DtoEntityConverter\Converter;
use KonstantinKuklin\DtoEntityConverter\Reader\ArrayReader;
use KonstantinKuklin\DtoEntityConverter\Writer\ArrayWriter;
use KonstantinKuklin\DtoEntityConverter\Writer\DtoWriter;
use PHPUnit_Framework_TestCase;

class OneTest extends PHPUnit_Framework_TestCase
{

//    public function testOne()
//    {
//        $convertFrom = array(
//            array(
//                'field1' => array(1, 2, 3),
//                'field2' => array(2, 3, 4),
//                'field3' => array(8, 9, 10),
//            )
//        );
//        $converter = new Converter(new ArrayReader(), new ArrayWriter());
//        $return = $converter->convert($convertFrom, null);
//
//        $this->assertEquals($convertFrom, $return);
//    }

    public function testSecond()
    {
        $convertFrom = array(
            array(
                'chunk' => null,
                'chunkList' => array(
                    array(
                        array(
                            'chunk' => array(
                                'chunk' => null,
                                'chunkList' => array(),
                                'boolean' => false,
                                'booleanList' => array(
                                    true,
                                    false,
                                    true
                                )
                            ),
                            'chunkList' => array(),
                            'boolean' => false,
                            'booleanList' => array(
                                true,
                                false,
                                true
                            )
                        )
                    )
                ),
                'boolean' => false,
                'booleanList' => array(
                    true,
                    false,
                    true
                )
            )
        );
        $converter = new Converter(new ArrayReader(), new DtoWriter());
        $return = $converter->convert($convertFrom, new Chunk());

        $this->assertEquals($convertFrom, $return);
    }
}