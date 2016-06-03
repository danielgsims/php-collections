<?php

use Collections\Collection;

class ReverseTest extends PHPUnit_Framework_TestCase
{

    public function testReverse()
    {
        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(2);
        $items[] = new TestClassA(1);

        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(3));

        $this->c->reverse();
        $this->assertEquals($items, $this->c->toArray());
    }

}