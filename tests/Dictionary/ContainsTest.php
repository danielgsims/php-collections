<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use Collections\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TestClassA;
use TestClassAInterface;
use TestClassExtendsA;

class ContainsTest extends TestCase
{
    public function test_adding_with_okay_types_adds_to_dictionary()
    {
        $d = new Dictionary('string', 'int');
        $d = $d->add('a', 1);
        $d = $d->add('b', 2);
        $d = $d->add('c', 3);
        $d = $d->add('d', 4);

        $c3 = $d->contains(function($key, $value) {
            return $key === 'c' && $value === 3;
        });

        $this->assertTrue($c3);

        $c4 = $d->contains(function($key, $value) {
            return $key === 'c' && $value === 4;
        });

        $this->assertFalse($c4);
    }

}
