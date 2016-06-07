<?php

use Collections\Collection;

class MergeTest extends PHPUnit_Framework_TestCase
{
    public function test_merge()
    {
        $c = new Collection('int');
        $c = $c->add(1);
        $c = $c->add(2);
        $c = $c->add(3);
        $c = $c->add(4);

        $c1 = new Collection('int');
        $c1 = $c1->add(5);
        $c1 = $c1->add(6);
        $c1 = $c1->add(7);
        $c1 = $c1->add(8);

        $result = $c->merge($c1);

        $expected = new Collection('int');
        $expected = $expected->add(1);
        $expected = $expected->add(2);
        $expected = $expected->add(3);
        $expected = $expected->add(4);
        $expected = $expected->add(5);
        $expected = $expected->add(6);
        $expected = $expected->add(7);
        $expected = $expected->add(8);

        $this->assertEquals($expected, $result);
    }
}
