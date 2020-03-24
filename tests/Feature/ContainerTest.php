<?php

namespace Tests\Feature;

use App\Test\Pale;
use App\Test\PaleArg;
use App\Test\PaleInject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContainerTest extends TestCase
{
    /**
     * 把东西放到容器后马上取出
     *
     * @return void
     */
    public function testInstance()
    {
        $app = app();
        $app->instance('pale', new Pale());
        $this->assertTrue($app->has('pale'));
        $a = $app->make('pale');
        $this->assertTrue($a instanceof Pale);
        $this->assertTrue($a->getA() === 123);

        $app->instance('lol', 345);
        $this->assertTrue($app->make('lol') === 345);
    }

    public function testMake()
    {
        $app = app();
        $app->bind('pale', Pale::class);
        $a = $app->make('pale');
        $this->assertTrue($a instanceof Pale);
        $this->assertTrue($a->getA() === 123);
    }

    public function testMakeArg()
    {
        $app = app();
        $app->bind('pale_arg', PaleArg::class);
        $b = $app->make('pale_arg', [
            'b' => 1,
            'c' => 2
        ]);
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 21);

        $b = $app->make('pale_arg', [
            'c' => 3,
            'b' => 2,
        ]);
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 32);
    }


    public function testMakeArgSingle()
    {
        $app = app();
        $app->bind('pale_arg', PaleArg::class, true);
        $b = $app->make('pale_arg', [
            'b' => 1,
            'c' => 2
        ]);
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 21);

        $b = $app->make('pale_arg', [
            'c' => 3,
            'b' => 2,
        ]);
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 32);

        $app->bind('pale_arg_1', function () {
            return new PaleArg(2,1);
        }, true);
        $b = $app->make('pale_arg_1');
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 21);

        $b = $app->make('pale_arg_1', [
            'c' => 3,
            'b' => 2,
        ]);
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 21);
    }

    public function testResolving()
    {
        $app = app();
        $app->bind('pale_arg', PaleArg::class, true);

        $app->resolving('pale_arg',function ($i) {
//            var_dump($i);
            $this->assertTrue($i instanceof PaleArg);
            $i->setA(55);
        });
        $b = $app->make('pale_arg', [
            'b' => 1,
            'c' => 2
        ]);
        $this->assertTrue($b instanceof PaleArg);
        $this->assertTrue($b->getA() === 55);

    }

    /**
     * 带参数的MAKE
     */
    public function testWhen()
    {
        $app = app();
        $app->when(PaleArg::class)
            ->needs('$b')
            ->give(5);
        $app->when(PaleArg::class)
            ->needs('$c')
            ->give(6);

        $app->bind('pale_inject', PaleInject::class, true);

        $i = $app->make('pale_inject');
        $this->assertTrue($i instanceof PaleInject);
//        var_dump($i->getA());
        $this->assertTrue($i->getA() === 65);
    }


}
