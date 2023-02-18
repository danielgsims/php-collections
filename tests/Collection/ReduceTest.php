<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class ReduceTest extends TestCase
{
    private Collection $c;

    public function testReduce()
    {
        $t = new TestClassA(1);
        $t2 = new TestClassA(2);
        $t3 = new TestClassA(3);

        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);

        $result = $this->c->reduce(function ($total, $item) {
            return $total + $item->getValue();
        });

        $this->assertEquals(6, $result);

        $result = $this->c->reduce(function ($total, $item) {
            return $total + $item->getValue();
        }, 2);

        $this->assertEquals(8, $result);
    }
}