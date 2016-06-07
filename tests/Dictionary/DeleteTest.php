<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use PHPUnit_Framework_TestCase;

class BlankTest extends PHPUnit_Framework_TestCase
{
    public function test_delete_key_creates_second_dic_without_key()
    {
        $d = (new Dictionary('string', 'int'))->add('a', 1)->add('b', 2);
        $this->assertEquals(2, $d->count());

        $d2 = $d->delete('a');
        $this->assertEquals(2, $d->count());
        $this->assertEquals(1, $d2->count());
    }
}