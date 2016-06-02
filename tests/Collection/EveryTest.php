<?php

use Collections\Collection;

class EveryTest extends PHPUnit_Framework_TestCase
{
    public function testEvery()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);

        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);

        $result = $this->c->every(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertTrue($result);

        $result = $this->c->every(function ($item) {
            return $item->getValue() % 2 != 0;
        });

        $this->assertFalse($result);
    }
}