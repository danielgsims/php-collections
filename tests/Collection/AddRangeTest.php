<?php

use Collections\Collection;

class AddRangeTest extends PHPUnit_Framework_TestCase
{
    public function test_add_range_adds_new_collection_with_items()
    {
        $col = new Collection('TestClassA');
        $range = [ new TestClassA(0), new TestClassA(1) ];

        $withRange = $col->addRange($range);

        $this->assertEquals(0, $col->count());
        $this->assertEquals(2, $withRange->count());
        $this->assertEquals($range, $withRange->toArray());
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_range_with_incorrect_types_throws_ex()
    {
        $badItems = array();
        $badItems[] = new TestClassB();
        $badItems[] = new TestClassB();

        $col = new Collection('TestClassA');
        $col->addRange($badItems);
    }
}