<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use Collections\Exceptions\InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use TestClassA;
use TestClassAInterface;
use TestClassExtendsA;

class AddTest extends PHPUnit_Framework_TestCase
{
    public function test_adding_with_okay_types_adds_to_dictionary()
    {
        //string key and val
        $d = new Dictionary('string', 'string');
        $d = $d->add('testkey', 'testval');
        $this->assertEquals(1, $d->count());

        //int key and val
        $d = new Dictionary('int', 'int');
        $d = $d->add(1, 42);
        $this->assertEquals(1, $d->count());

        //integer synonymous with int
        $d = new Dictionary('integer', 'integer');
        $d = $d->add(1, 42);
        $this->assertEquals(1, $d->count());

        //float works as val
        $d = new Dictionary('string', 'float');
        $d = $d->add("a", 2.0);
        $this->assertEquals(1, $d->count());

        //double synonymous with float
        $d = new Dictionary('string', 'double');
        $d = $d->add('b', 2.0);
        $this->assertEquals(1, $d->count());

        //bool valid value
        $d = new Dictionary('int', 'bool');
        $d = $d->add(1, false);
        $this->assertEquals(1, $d->count());

        //boolean synonymous with bool
        $d = new Dictionary('int', 'boolean');
        $d = $d->add(1, false);
        $this->assertEquals(1, $d->count());

        //callable works as value type
        $d = new Dictionary('string', 'callable');
        $d = $d->add('test', function(){ });
        $this->assertEquals(1, $d->count());

        //class works as value type
        $d = new Dictionary('string', TestClassA::class);
        $d = $d->add('test', new TestClassA(42));
        $this->assertEquals(1, $d->count());

        //dervied classes, too work.
        $d = $d->add('test2', new TestClassExtendsA(42));
        $this->assertEquals(2, $d->count());

        //interface works as value type
        $d = new Dictionary('string', TestClassAInterface::class);
        $d = $d->add('test', new TestClassA(42));
        $this->assertEquals(1, $d->count());
    }

    public function test_adding_with_invalid_key_type_throws_ex()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new dictionary('string', 'int');
        $d = $d->add(4, 1977);
    }

    public function test_adding_with_invalid_value_type_throws_ex()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new dictionary('string', 'string');
        $d = $d->add("Episode IV", 1977);
    }

    public function test_array_is_invalid_key_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary('array', 'int');
    }

    public function test_object_is_invalid_key_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary('object', 'int');
    }

    public function test_callable_is_invalid_key_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary('callable', 'int');
    }

    public function test_class_is_invalid_key_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary(TestClassA::class, 'int');
    }

    public function test_interface_is_invalid_key_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary(TestClassAInterface::class, 'int');
    }

    public function test_madeup_string_is_invalid_key_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary('test2', 'int');
    }

    public function test_setting_key_will_overwrite_if_exists()
    {
        $d = new Dictionary('string', 'int');
        $d = $d->add('key',1);
        $d = $d->add('key', 2);

        $this->assertEquals(2, $d->get('key'));
    }

    public function test_ex_thrown_if_callable_is_not_passed()
    {
        $this->expectException(InvalidArgumentException::class);
        $d = new Dictionary('string', 'callable');
        $d = $d->add('test', 123);
    }

}
