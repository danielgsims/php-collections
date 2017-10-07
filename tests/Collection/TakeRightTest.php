<?php

use Collections\Collection;

class TakeRightTest extends PHPUnit_Framework_TestCase
{
    public function testTakeRight()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);

        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);

        $c1 = $this->c->takeRight(1);
        $c2 = $this->c->takeRight(2);
        $c3 = $this->c->takeRight(3);

        $this->assertEquals(1, $c1->count());
        $this->assertEquals(2, $c2->count());
        $this->assertEquals(3, $c3->count());

        $this->assertEquals($t3, $c1->at(0));

        $this->assertEquals($t2, $c2->at(0));
        $this->assertEquals($t3, $c2->at(1));

        $this->assertEquals($t, $c3->at(0));
        $this->assertEquals($t2, $c3->at(1));
        $this->assertEquals($t3, $c3->at(2));
    }

    public function test_take_right_takes_remainder_if_count_too_large()
    {
        $c = new Collection('int',[0,1,2,3]);
        $c2 = $c->takeRight(10);

        $this->assertEquals(4, $c2->count());
    }
}