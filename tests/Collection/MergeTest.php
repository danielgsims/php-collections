<?php

use Collections\Collection;
use Collections\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MergeTest extends TestCase
{
    public function test_merge()
    {
        $c = new Collection('int');
        $c = $c->add(1);
        $c = $c->add(2);
        $c = $c->add(3);
        $c = $c->add(4);

        $c1 = new Collection('int');
        $c1 = $c1->add(5);
        $c1 = $c1->add(6);
        $c1 = $c1->add(7);
        $c1 = $c1->add(8);

        $result = $c->merge($c1);

        $expected = new Collection('int');
        $expected = $expected->add(1);
        $expected = $expected->add(2);
        $expected = $expected->add(3);
        $expected = $expected->add(4);
        $expected = $expected->add(5);
        $expected = $expected->add(6);
        $expected = $expected->add(7);
        $expected = $expected->add(8);

        $this->assertEquals($expected, $result);
    }

    public function test_add_range_adds_new_collection_with_items()
    {
        $col = new Collection('TestClassA');
        $range = [ new TestClassA(0), new TestClassA(1) ];

        $withRange = $col->merge($range);

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
        $col->merge($badItems);
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_non_array_or_col_throws_ex()
    {
        $col = new Collection('TestClassA');
        $col->merge(new TestClassA(1));
    }
}
