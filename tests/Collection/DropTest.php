<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class DropTest extends TestCase
{
    /**
     * @var Collection
     */
    private $col;
    private $items;

    public function setup(): void
    {
        $this->items = [
            new TestClassA(2),
            new TestClassA(4),
            new TestClassA(6),
        ];

        $this->col = new Collection('TestClassA', $this->items);
    }

    public function test_drop_zero_returns_identical_col()
    {
        $col = $this->col->drop(0);

        $this->assertEquals($this->col, $col);
    }

    public function test_drop_one_returns_list_without_first_item()
    {
        $col = $this->col->drop(1);
        $this->assertEquals(2, $col->count());
        $this->assertEquals($this->items[1], $col->at(0));
        $this->assertEquals($this->items[2], $col->at(1));
    }

    public function test_drop_all_but_last_item_gives_list_with_one_item()
    {
        $col = $this->col->drop(2);
        $this->assertEquals(1, $col->count());
        $this->assertEquals($this->items[2], $col->at(0));
    }

    public function test_drop_all_gives_empty_collection()
    {
        $col = $this->col->drop(3);
        $this->assertEquals(0,$col->count());
    }

    //@todo what if you exceed count? Should you drop all?
}