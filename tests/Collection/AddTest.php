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

    public function test_collection_supports_type_integer()
    {
        $col = new Collection('integer');
        $col = $col->add(1);

        $this->assertEquals(1, $col->count());
    }

    public function test_collection_supports_type_int()
    {
        $col = new Collection('int');
        $col = $col->add(1);

        $this->assertEquals(1, $col->count());
    }

    public function test_collection_supports_type_float()
    {
        $col = new Collection('float');
        $col = $col->add(1.0);

        $this->assertEquals(1, $col->count());
    }

    public function test_collection_supports_type_double()
    {
        $col = new Collection('double');
        $col = $col->add(1.0);

        $this->assertEquals(1, $col->count());
    }

    public function test_collection_supports_strings()
    {
         $col = new Collection('string');
        $col = $col->add("mystring");

        $this->assertEquals(1, $col->count());
    }

    public function test_collect_supports_bool()
    {
        $col = new Collection('bool');
        $col = $col->add(true);

        $this->assertEquals(1, $col->count());
    }

    public function test_collect_supports_boolean()
    {
        $col = new Collection('boolean');
        $col = $col->add(true);

        $this->assertEquals(1, $col->count());
    }

    public function test_collection_supports_arrays()
    {
         $col = new Collection('array');
        $col = $col->add([1,2,3]);

        $this->assertEquals(1, $col->count());
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_collection_throws_ex_for_non_existent_type()
    {
        $col = new Collection('this_type_is_invalid');
    }

    /**
     * @expectedException Collections\Exceptions\InvalidArgumentException
     */
    public function test_collection_throws_ex_for_different_types()
    {
        $col = new Collection('int');
        $col = $col->add('string');
    }
}
