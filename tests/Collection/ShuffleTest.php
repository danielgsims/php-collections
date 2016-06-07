<?php

use Collections\Collection;

class ShuffleTest extends PHPUnit_Framework_TestCase
{
    public function test_shuffle()
    {
        $this->c = new Collection('int');
        $this->c = $this->c->add(1);
        $this->c = $this->c->add(2);
        $this->c = $this->c->add(3);
        $this->c = $this->c->add(4);
        $this->c = $this->c->add(5);
        $this->c = $this->c->add(6);
        $this->c = $this->c->add(7);
        $this->c = $this->c->add(8);
        $this->c = $this->c->add(9);
        $this->c = $this->c->add(10);

        $shuffled = $this->c->shuffle();

        $this->assertTrue($shuffled);
    }
}
