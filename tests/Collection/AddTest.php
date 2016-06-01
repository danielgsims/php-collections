<?php

use Collections\Collection;

class AddTest extends PHPUnit_Framework_TestCase
{
    public function test_add_item_creates_new_col_with_item()
    {
        $col = new Collection('TestClassA');

        //count should be zero
        $this->assertEquals(0, $col->count());
        $a = new TestClassA(1);
        //add the item
        $col2 = $col->add($a);

        //col should be unchanged
        $this->assertEquals(0, $col->count());
        $this->assertEquals(1, $col2->count());
        $this->assertEquals($a, $col2->at(0));
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_adding_wrong_class_triggers_error()
    {
        $col = new Collection('TestClassA');
        $col->add(new TestClassB());
    }

    public function test_can_add_subtypes()
    {
        $col = new Collection('TestClassA');
        $col = $col->add(new TestClassExtendsA(1));
        $this->assertEquals(1, $col->count());
    }
}