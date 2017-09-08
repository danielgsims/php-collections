<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;

class MapTest extends \PHPUnit_Framework_TestCase
{
    public function test_map_infers_type_for_dict()
    {
        $d = new Dictionary('string', 'int');
        $d = $d->add('a', 1);

        //change key to 42
        $m = $d->map(function($k, $v) {
            return [42, $v];
        });

        $this->assertEquals('integer', $m->getValueType());
        $this->assertEquals('integer', $m->getKeyType());
        $this->assertTrue($m->exists(42));
        $this->assertEquals(1, $m->get(42));
    }

    public function test_map_example()
    {
        $d = new Dictionary('int', 'string');
        $d = $d->add(1, 'a');
        $d = $d->add(2, 'b');

        $m = $d->map(function($k, $v) {
           return [$k, ord($v)];
        });

        $this->assertEquals('integer', $m->getValueType());
        $this->assertEquals('integer', $m->getKeyType());
        $this->assertEquals(97, $m->get(1));
        $this->assertEquals(98, $m->get(2));
    }

    public function test_map_empty_dictionary()
    {
        $d = new Dictionary('string', 'int');
        $result = $d->map(function ($a) {
            return $a;
        });
        $expected = new Dictionary('string', 'int');
        $this->assertEquals($expected, $result);
    }
}
