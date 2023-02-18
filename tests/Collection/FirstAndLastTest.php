<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class FirstAndLastTest extends TestCase
{
    public function test_can_get_first_item()
    {
        $col = new Collection('integer', [1, 2, 3, 4, 5]);
        $this->assertSame($col->first(), 1);
    }

    public function test_can_not_get_first_if_collection_is_empty()
    {
        $this->expectException(\RuntimeException::class);
        (new Collection('integer'))->first();
    }

    public function test_can_get_last_item()
    {
        $col = new Collection('integer', [1, 2, 3, 4, 5]);
        $this->assertSame($col->last(), 5);
    }

    public function test_can_not_get_last_if_collection_is_empty()
    {
        $this->expectException(\RuntimeException::class);
        (new Collection('integer'))->last();
    }
}
