<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use PHPUnit\Framework\TestCase;

class KeysTest extends TestCase
{
    public function test_keys()
    {
        $d = (new Dictionary('string', 'int'))
                ->add('a', 1)
                ->add('b', 2)
                ->add('c', 3)
                ->add('d', 4);

        $result = $d->keys();

        $expected = ['a', 'b', 'c', 'd'];
        $this->assertEquals($expected, $result);
    }
}
