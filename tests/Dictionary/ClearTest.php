<?php

namespace Collections\Tests\Dictionary;


use Collections\Dictionary;
use PHPUnit\Framework\TestCase;

class ClearTest extends TestCase
{
    public function test_clear_creates_empty_dictionary_of_same_type()
    {
        $d = new Dictionary('string','int');
        $d = $d->add('a', 1);

        $empty = $d->clear();

        //original is unchanged
        $this->assertEquals(1, $d->count());
        $this->assertEquals(0, $empty->count());

        //key and value types should be the same
        $this->assertEquals($d->getKeyType(), $empty->getKeyType());
        $this->assertEquals($d->getValueType(), $empty->getValueType());
    }
}