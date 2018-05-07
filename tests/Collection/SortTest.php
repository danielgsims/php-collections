<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    public function test_sorts_with_callback()
    {
        $col = new Collection('int', [3,1,4,2]);

        $comparator = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };

        $sorted = $col->sort($comparator);

        $this->assertEquals(1, $sorted->at(0));
        $this->assertEquals(2, $sorted->at(1));
        $this->assertEquals(3, $sorted->at(2));
        $this->assertEquals(4, $sorted->at(3));

        //collection is unchanged
        $this->assertEquals([3,1,4,2], $col->toArray());
    }
}