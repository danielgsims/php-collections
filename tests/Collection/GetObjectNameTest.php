<?php

use Collections\Collection;

class GetObjectNameTest extends PHPUnit_Framework_TestCase
{
    public function testGetObjectName()
    {
        $col = new Collection('TestClassA');
        $this->assertEquals("TestClassA", $col->getType());
    }
}