<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use PHPUnit\Framework\TestCase;
use TestClassA;
use TestClassAInterface;
use TestClassExtendsA;

class ReduceTest extends TestCase
{
    public function test_adding_with_okay_types_adds_to_dictionary()
    {
        $d = new Dictionary('string', 'int');
        $d = $d->add('a', 1);
        $d = $d->add('b', 2);
        $d = $d->add('c', 3);
        $d = $d->add('d', 4);

        $flat = $d->reduce(function($carry, $key, $value) {
            $carry[] = $key;
            $carry[] = $value;

            return $carry;
        }, []);

        $this->assertEquals(['a',1,'b',2,'c',3,'d',4], $flat);

        $lt10 = function($carry, $key, $value) {
           if (!$carry) return false;

           return $value < 10;

        };

        $valuesLessThanTen = $d->reduce($lt10, true);

        $this->assertTrue($valuesLessThanTen);

        $d = $d->add('e',99);

        $valuesLessThanTen = $d->reduce($lt10, true);

        $this->assertFalse($valuesLessThanTen);
    }

}
