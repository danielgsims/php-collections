<?php

use Collections\Collection;

class InsertRangeTest extends PHPUnit_Framework_TestCase
{
    public function testInsert()
    {
        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));

        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(4);

        $this->c->insertRange(1, $items);

        $this->assertEquals(4, $this->c->count());
        $this->assertEquals(1, $this->c->at(0)->getValue());
        $this->assertEquals(3, $this->c->at(1)->getValue());
        $this->assertEquals(4, $this->c->at(2)->getValue());
        $this->assertEquals(2, $this->c->at(3)->getValue());
    }
}
