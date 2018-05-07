<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    public function testInsert()
    {
        $c = new Collection('TestClassA');
        $c = $c->add(new TestClassA(1));
        $c = $c->add(new TestClassA(2));

        $result = $c->insert(1, new TestClassA(3));

        $this->assertEquals(3, $result->at(1)->getValue());
    }

    /**
     * @expectedException Collections\Exceptions\OutOfRangeException
     * @expectedExceptionMessage Index out of bounds of collection
     */
    public function testInsertThrowsOutOfRangeException()
    {
        $c = new Collection('TestClassA');
        $c->insert(100, new TestClassA(5));
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Index must be a non-negative integer
     */
    public function testInsertThrowsInvalidArgumentException()
    {
        $c = new Collection('TestClassA');
        $c->insert(-1, new TestClassA(5));
    }
}
