<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class HeadAndTailTest extends TestCase
{
    public function test_head_and_tail_returns_head_and_collection_for_tail()
    {
        $col = new Collection('int', [1,2,3]);
        list($h,$t) = $col->headAndTail();

        $this->assertEquals(1, $h);
        $this->assertInstanceOf('Collections\Collection', $t);
        $this->assertEquals([2,3], $t->toArray());
    }

    public function test_empty_collection_returns_null_for_both()
    {
        $col = new Collection('int');
        list($h,$t) = $col->headAndTail();

        $this->assertNull($h);
        $this->assertNull($t);
    }

    public function test_collection_with_one_item_returns_head_and_null_tail()
    {
        $col = new Collection('int', [1]);
        list($h, $t) = $col->headAndTail();

        $this->assertEquals(1, $h);
        $this->assertNull($t);
    }

    public function test_hat_works_the_same()
    {
        $col = new Collection('int', [1,2,3]);
        list( $h, $t) = $col->hat();
        $this->assertEquals(1, $h);
        $this->assertEquals([2,3], $t->toArray());

        list($h, $t) = $t->hat();

        $this->assertEquals(2, $h);
        $this->assertEquals([3], $t->toArray());

        list($h, $t) = $t->hat();

        $this->assertEquals(3, $h);
        $this->assertNull($t);

    }
}
