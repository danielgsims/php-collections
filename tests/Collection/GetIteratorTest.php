<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class GetIteratorTest extends TestCase
{
    public function testIterator()
    {
        $col = new Collection('TestClassA');
        $iterator = $col->getIterator();
        $class = get_class($iterator);
        $this->assertEquals($class, "ArrayIterator");
    }
}
