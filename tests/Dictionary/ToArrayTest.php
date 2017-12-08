<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use PHPUnit\Framework\TestCase;

class ToArrayTest extends TestCase
{
    public function test_to_array_returns_assoc_array()
    {
        $d = new Dictionary('string', 'int');
        $d = $d->add('a', 1);
        $d = $d->add('b', 2);
        $d = $d->add('c', 3);

        $arr = $d->toArray();

        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3], $arr);
    }
}
