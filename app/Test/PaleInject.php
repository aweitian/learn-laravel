<?php

namespace App\Test;


class PaleInject
{
    protected $arg;

    public function __construct(PaleArg $arg)
    {
        $this->arg = $arg;
        //$arg->setA('11');
    }

    public function getA()
    {
        return $this->arg->getA();
    }
}
