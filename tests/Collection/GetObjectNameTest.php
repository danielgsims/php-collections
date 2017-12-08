<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class GetObjectNameTest extends TestCase
{
    public function testGetObjectName()
    {
        $col = new Collection('TestClassA');
        $this->assertEquals("TestClassA", $col->getType());
    }
}
