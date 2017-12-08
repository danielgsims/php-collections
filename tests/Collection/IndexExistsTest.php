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

    public function testIndexExitsRejectsNegatives()
    {
        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $col = new Collection('TestClassA');
        $col->indexExists(-1);
    }

    public function testIndexExitsRejectsNonIntegers()
    {
        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $col = new Collection('TestClassA');
        $col->indexExists("wat");
    }
}
