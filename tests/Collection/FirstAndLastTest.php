<?php

use Collections\Collection;

class FirstAndLastTest extends PHPUnit_Framework_TestCase
{
    public function test_can_get_first_item()
    {
        $col = new Collection('integer', [1, 2, 3, 4, 5]);
        $this->assertSame($col->first(), 1);
    }

    public function test_can_get_last_item()
    {
        $col = new Collection('integer', [1, 2, 3, 4, 5]);
        $this->assertSame($col->last(), 5);
    }
}
