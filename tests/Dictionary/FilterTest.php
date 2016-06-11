<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function test_filter()
    {
        $d = (new Dictionary('string', 'int'))
                ->add('a', 1)
                ->add('b', 2)
                ->add('c', 3)
                ->add('d', 4);

        $subset = $d->filter(function($k,$v) {
           return $v % 2 == 0;
        });

        //original is unchanged
        $this->assertEquals(4, $d->count());

        //new has 2
        $this->assertEquals(2, $subset->count());

        //new contains b and d
        $this->assertEquals(2, $subset->get('b'));
        $this->assertEquals(4, $subset->get('d'));

        //new is missing a and c
        $this->assertFalse($subset->exists('a'));
        $this->assertFalse($subset->exists('c'));
    }
}