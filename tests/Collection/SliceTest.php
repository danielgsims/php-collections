<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class SliceTest extends TestCase
{
    /**
     * @var Collection
     */
    private Collection $c;

    /**
     * @var array
     */
    private $items;

    public function setup(): void
    {
        $this->items = [
            new TestClassA(0),
            new TestClassA(1),
            new TestClassA(2),
            new TestClassA(3),
            new TestClassA(4),
            new TestClassA(5),
            new TestClassA(6),
            new TestClassA(7),
            new TestClassA(8),
            new TestClassA(9),
        ];

        $this->c = new Collection('TestClassA', $this->items);
    }

    public function test_slice_negative_start_throws_ex()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $this->c->slice(-1, 3);
    }

    public function test_slice_negative_end_throws_ex()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $this->c->slice(1, -4);
    }

    public function test_start_gt_end_is_invalid()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $this->c->slice(3, 2);
    }

    public function test_start_out_of_range_is_invalid()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $this->c->slice(20, 22);
    }

    public function test_end_out_of_range_is_invalid()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $this->c->slice(2, 22);
    }

    public function test_subset_within_middle_of_collection_gives_correct_indices()
    {
        $subset = $this->c->slice(2, 4);
        $this->assertEquals(3, $subset->count());

        $this->assertEquals($this->items[2], $subset->at(0));
        $this->assertEquals($this->items[3], $subset->at(1));
        $this->assertEquals($this->items[4], $subset->at(2));
    }

    public function test_subset_from_start_gives_correct_indices()
    {
        $subset = $this->c->slice(0, 1);
        $this->assertEquals(2, $subset->count());

        $this->assertEquals($this->items[0], $subset->at(0));
        $this->assertEquals($this->items[1], $subset->at(1));
    }

    public function test_subset_to_end_gives_correct_indices()
    {
        $subset = $this->c->slice(8, 9);
        $this->assertEquals(2, $subset->count());

        $this->assertEquals($this->items[8], $subset->at(0));
        $this->assertEquals($this->items[9], $subset->at(1));
    }

    public function test_subset_from_start_with_one_item()
    {
        $subset = $this->c->slice(0, 0);
        $this->assertEquals(1, $subset->count());
        $this->assertEquals($this->items[0], $subset->at(0));
    }

    public function test_subset_with_only_end()
    {
        $subset = $this->c->slice(9, 9);
        $this->assertEquals(1, $subset->count());
        $this->assertEquals($this->items[9], $subset->at(0));
    }
}