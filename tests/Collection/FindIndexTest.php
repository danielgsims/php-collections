<?php

use Collections\Collection;

class FindIndexTest extends PHPUnit_Framework_TestCase
{
    public function testFindIndex()
    {
        $this->c = new Collection("TestClassA");
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(4));
        $this->c = $this->c->add(new TestClassA(6));
        $this->c = $this->c->add(new TestClassA(8));

        $findEven = function ($item) {
            return $item->getValue() % 2 == 0;
        };

        $findOdd = function ($item) {
            return $item->getValue() % 2 != 0;
        };

        $this->assertEquals(0, $this->c->findIndex($findEven));
        $this->assertEquals(-1, $this->c->findIndex($findOdd));
        $this->assertEquals(3, $this->c->findLastIndex($findEven));
    }

    public function test_find_last_index_when_not_found()
    {
        $col = new Collection('int',[1,2,3]);

        $index = $col->findLastIndex(function($x) {
           return $x === 4;
        });

        $this->assertEquals(-1, $index);
    }
}