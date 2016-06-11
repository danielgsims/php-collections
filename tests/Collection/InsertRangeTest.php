<?php

use Collections\Collection;

class InsertRangeTest extends PHPUnit_Framework_TestCase
{
    public function testInsert()
    {
        $c = (new Collection('TestClassA'))
             ->add(new TestClassA(1))
             ->add(new TestClassA(2));

        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(4);

        $result = $c->insertRange(1, $items);

        $expected = (new Collection('TestClassA'))
                    ->add(new TestClassA(1))
                    ->add(new TestClassA(3))
                    ->add(new TestClassA(4))
                    ->add(new TestClassA(2));

        $this->assertEquals($expected, $result);

        $expected1 = (new Collection('TestClassA'))
                     ->add(new TestClassA(1))
                     ->add(new TestClassA(2));

        $this->assertEquals($expected1, $c);
    }
}
