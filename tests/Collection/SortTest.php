<?php

use Collections\Collection;

class SortTest extends PHPUnit_Framework_TestCase
{
    public function testSort()
    {
        $items = [
            new TestClassA(3),
            new TestClassA(1),
            new TestClassA(4),
            new TestClassA(2),
        ];

        $col = new Collection('TestClassA', $items);

        $comparator = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };

        $sorted = $col->sort($comparator);
        $this->assertEquals(1, $sorted->at(0)->getValue());
        $this->assertEquals(2, $sorted->at(1)->getValue());
        $this->assertEquals(3, $sorted->at(2)->getValue());
        $this->assertEquals(4, $sorted->at(3)->getValue());

        //collection is unchanged
        $this->assertEquals($items, $col->toArray());
    }
}