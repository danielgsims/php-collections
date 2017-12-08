<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class TailTest extends TestCase
{
    public function test_that_tail_gives_you_everything_but_head()
    {
        $col = new Collection('int', [1,2,3,]);

        $tail = $col->tail();

        $this->assertEquals(2, $tail->count());

        //col shouldn't be changed and should have 3 items
        $this->assertEquals(3, $col->count());

        //check that tail has two and three
        $this->assertEquals(2, $tail->at(0));
        $this->assertEquals(3, $tail->at(1));
    }
}
