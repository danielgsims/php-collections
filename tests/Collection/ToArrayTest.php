<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class ToArrayTest extends TestCase
{
    public function testToArray()
    {
        $items = array();
        $items[] = new TestClassA(1);
        $items[] = new TestClassA(2);
        $items[] = new TestClassA(3);

        $col = new Collection('TestClassA', $items);
        $this->assertEquals($items, $col->toArray());
    }
}