<?php

use Collections\Collection;

class GetIteratorTest extends PHPUnit_Framework_TestCase
{
    public function testIterator()
    {
        $col = new Collection('TestClassA');
        $iterator = $col->getIterator();
        $class = get_class($iterator);
        $this->assertEquals($class, "ArrayIterator");
    }
}