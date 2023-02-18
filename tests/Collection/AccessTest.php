<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class AccessTest extends TestCase
{
    public function test_bad_index_throws_ex()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $col = new Collection('TestClassA', [ new TestClassA(1)]);
        $col->at("one");
    }

    public function test_out_of_range_throws_ex()
    {
        $this->expectException(\Collections\Exceptions\OutOfRangeException::class);
        $col = new Collection('TestClassA', [ new TestClassA(1)]);
        $col->at(1);
    }

    public function test_negative_index_throws_value()
    {
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $col = new Collection('TestClassA', [ new TestClassA(1)]);
        $col->at(-1);
    }

    public function test_index_returns_value()
    {
        $col = new Collection('TestClassA', [ new TestClassA(1)]);
        $res = $col->at(0);

        $this->assertEquals(new TestClassA(1), $res);
    }
}