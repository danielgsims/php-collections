<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class RemoveAtTest extends TestCase
{
   public function testRemoveAt()
    {
        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(2);
        $items[] = new TestClassA(1);

        $this->c = new Collection('TestClassA');
        $this->c = $this->c->merge($items);

        $this->assertEquals(3, $this->c->count());

        $this->c = $this->c->removeAt(1);

        $this->assertEquals(2, $this->c->count());
        $this->assertEquals(1, $this->c->at(1)->getValue());
    }

}
