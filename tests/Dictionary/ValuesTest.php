<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;

class ValuesTest extends \PHPUnit_Framework_TestCase
{
    public function test_values()
    {
        $d = (new Dictionary('string', 'int'))
                ->add('a', 1)
                ->add('b', 2)
                ->add('c', 3)
                ->add('d', 4);

        $result = $d->values();

        $expected = [1,2,3,4];
        $this->assertEquals($expected, $result);
    }
}
