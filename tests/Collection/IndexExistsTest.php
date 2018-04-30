<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class IndexExistsTest extends TestCase
{
    public function testIndexExits()
    {
        $col = new Collection('TestClassA', [
            new TestClassA(1),
            new TestClassA(2)
        ]);
        $this->assertTrue($col->indexExists(0));
        $this->assertTrue($col->indexExists(1));
        $this->assertFalse($col->indexExists(2));
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Index must be a non-negative integer
     */
    public function testIndexExitsRejectsNegatives()
    {
        $col = new Collection('TestClassA');
        $col->indexExists(-1);
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     * @expectedExceptionMessage Index must be an integer
     */
    public function testIndexExitsRejectsNonIntegers()
    {
        $col = new Collection('TestClassA');
        $col->indexExists("wat");
    }
}