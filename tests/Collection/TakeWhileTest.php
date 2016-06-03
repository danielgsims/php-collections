<?php

use Collections\Collection;

class TakeWhileTest extends PHPUnit_Framework_TestCase
{
    public function test_take_while()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(7);
        $t4 = new TestClassA(9);

        $this->c = new Collection('TestClassA');

        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);
        $this->c = $this->c->add($t4);

        $c1 = $this->c->takeWhile(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertEquals(2, $c1->count());

        $this->assertEquals($t, $c1->at(0));
        $this->assertEquals($t2, $c1->at(1));

        $c2 = $this->c->takeWhile(function ($item) {
            return true;
        });
        $this->assertEquals($this->c, $c2);

        $c3 = $this->c->takeWhile(function ($item) {
            return false;
        });
        $this->assertEquals(0, $c3->count());
    }
}