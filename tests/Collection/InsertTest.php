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

    public function testInsertThrowsOutOfRangeException()
    {
        $this->expectExceptionMessage("Index out of bounds of collection");
        $this->expectException(\Collections\Exceptions\OutOfRangeException::class);
        $c = new Collection('TestClassA');
        $c->insert(100, new TestClassA(5));
    }

    public function testInsertThrowsInvalidArgumentException()
    {
        $this->expectExceptionMessage("Index must be a non-negative integer");
        $this->expectException(\Collections\Exceptions\InvalidArgumentException::class);
        $c = new Collection('TestClassA');
        $c->insert(-1, new TestClassA(5));
    }
}
