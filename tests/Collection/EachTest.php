<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class EachTest extends TestCase
{
    public function test_each()
    {
        $c = (new Collection('int'))
              ->add(1)
              ->add(2)
              ->add(3)
              ->add(4);

        $results = [];

        $c->each(function($a) use (&$results) { $results[] = $a; });

        $expected = [1,2,3,4];
        $this->assertEquals($expected, $results);
    }
}
