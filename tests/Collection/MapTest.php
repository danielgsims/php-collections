<?php

use Collections\Collection;

class MapTest extends PHPUnit_Framework_TestCase
{
    public function test_map_ints()
    {
        $c = (new Collection('int'))
                  ->add(1)
                  ->add(2)
                  ->add(3);

        $result = $c->map(function($a) { return $a * 3; });

        $expected = (new Collection('int'))
                  ->add(3)
                  ->add(6)
                  ->add(9);

        $this->assertEquals($expected, $result);
    }

    public function test_map_strings()
    {
        $c = (new Collection('string'))
                  ->add('a')
                  ->add('b')
                  ->add('c');

        $result = $c->map(function($a) { return strtoupper($a); });

        $expected = (new Collection('string'))
                  ->add('A')
                  ->add('B')
                  ->add('C');

        $this->assertEquals($expected, $result);
    }
}
