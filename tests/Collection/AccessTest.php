<?php

use Collections\Collection;

class AccessTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_bad_index_throws_ex()
    {
        $col = new Collection('TestClassA', [ new TestClassA(1)]);
        $col->at("one");
    }

    /**
     * @expectedException Collections\Exceptions\OutOfRangeException
     */
    public function test_out_of_range_throws_ex()
    {
        $col = new Collection('TestClassA', [ new TestClassA(1)]);
        $col->at(1);
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_negative_index_throws_value()
    {
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