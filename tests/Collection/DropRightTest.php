<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class DropRightTest extends TestCase
{
    /**
     * @var Collection
     */
    private $col;
    private $items;

    public function setup()
    {
        $this->items = [
            new TestClassA(2),
            new TestClassA(4),
            new TestClassA(6),
        ];

        $this->col = new Collection('TestClassA', $this->items);
    }

    public function test_dr_zero_returns_identical_col()
    {
        $col = $this->col->dropRight(0);
        $this->assertEquals($this->col, $col);
    }

    public function test_dr_one_drops_last_item()
    {
        $col = $this->col->dropRight(1);
        $this->assertEquals(2, $col->count());
        $this->assertEquals($this->items[0], $col->at(0));
        $this->assertEquals($this->items[1], $col->at(1));
    }

    public function test_dr_all_but_one_leaves_first_item()
    {
        $col = $this->col->dropRight(2);
        $this->assertEquals(1, $col->count());
        $this->assertEquals($this->items[0], $col->at(0));
    }
}