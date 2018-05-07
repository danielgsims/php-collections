<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use PHPUnit\Framework\TestCase;

class WithoutTest extends TestCase
{
    public function test_filter()
    {
        $d = (new Dictionary('string', 'int'))
                ->add('a', 1)
                ->add('b', 2)
                ->add('c', 3)
                ->add('d', 4);

        $subset = $d->without(function($k,$v) {
           return $v % 2 == 0;
        });

        //original is unchanged
        $this->assertEquals(4, $d->count());

        //new has 2
        $this->assertEquals(2, $subset->count());

        //new does not have b and d
        $this->assertFalse($subset->exists('b'));
        $this->assertFalse($subset->exists('d'));

        //new has a and c
        $this->assertTrue($subset->exists('a'));
        $this->assertTrue($subset->exists('c'));

        $this->assertEquals(1, $subset->get('a'));
        $this->assertEquals(3,$subset->get('c'));
    }
}