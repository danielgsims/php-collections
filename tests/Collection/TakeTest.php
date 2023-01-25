<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class TakeTest extends TestCase
{
    /**
     * @var Collection
     */
    private $col;

    public function setup(): void
    {
        $this->col = new Collection('TestClassA', [
            new TestClassA(2),
            new TestClassA(4),
            new TestClassA(6),
        ]);
    }

    public function test_take_one_gives_col_with_first()
    {
        $result = $this->col->take(1);

        $this->assertEquals(1, $result->count());
        $this->assertEquals(new TestClassA(2), $result->at(0));
    }

    public function test_take_two_gives_two_from_left()
    {
        $result = $this->col->take(2);

        $this->assertEquals(2, $result->count());
        $this->assertEquals(new TestClassA(2), $result->at(0));
        $this->assertEquals(new TestClassA(4), $result->at(1));
    }

    public function test_take_all_gives_whole_collection()
    {
        $result = $this->col->take(3);

        $this->assertEquals($this->col, $result);
    }

    public function test_take_negative_throws_ex()
    {
        $this->expectException(Collections\Exceptions\InvalidArgumentException::class);
        $result = $this->col->take(-1);
    }

    public function test_take_returns_remainder()
    {
        $result = $this->col->take(100);

        $this->assertEquals(3, $result->count());
    }
}