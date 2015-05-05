<?php
/**
 * @author KonstantinKuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\DtoEntityConverter;

/**
 * Interface ReadInterface
 */
interface ReadInterface
{

    /**
     * @param mixed  $data
     *
     * @return mixed
     */
    public function read($data);
}