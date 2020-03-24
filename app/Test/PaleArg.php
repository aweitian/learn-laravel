<?php

namespace App\Test;


class PaleArg
{
    public $a = 10;

    public function __construct($c, $b)
    {
        $this->a = $this->a * $c + $b;
    }

    public function getA()
    {
        return $this->a;
    }

    public function setA($a)
    {
        $this->a = $a;
    }
}
