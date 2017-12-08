<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class ClearTest extends TestCase
{
    public function test_clear_returns_an_empty_collection()
    {
        $col = new Collection('TestClassA', [ new TestClassA(1) ]);

        //col will have one
        $this->assertEquals(1, $col->count());

        //empty should have no items
        $empty = $col->clear();
        $this->assertEquals(0, $empty->count());

        //col should remain unchanged
        $this->assertEquals(1, $col->count());
    }
}
