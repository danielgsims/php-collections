<?php

use Collections\Collection;

class EachTest extends PHPUnit_Framework_TestCase
{
    public function test_each()
    {
        $c = (new Collection('int'))
                  ->add(1)
                  ->add(2)
                  ->add(3);

        $result = [];

        $c->each(function($a) use (&$result) { $result[] = $a; });

        $expected = [1,2,3];
        $this->assertEquals($expected, $result);
    }
}
