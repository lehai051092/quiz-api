<?php

namespace App\Helper;

abstract class BaseOption
{
    /**
     * @param $request
     * @return array
     */
    abstract public function optionArray($request): array;
}
