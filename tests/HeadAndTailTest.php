<?php

use Collections\Collection;

class HeadAndTailTest extends PHPUnit_Framework_TestCase
{
    public function test_head_and_tail_returns_head_and_collection_for_tail()
    {
        $col = new Collection('int', [1,2,3]);
        [$h,$t] = $col->headAndTail();

        $this->assertEquals(1, $h);
        $this->assertInstanceOf(Collection::class, $t);
        $this->assertEquals([2,3], $t->toArray());
    }

    public function test_empty_collection_returns_null_for_both()
    {
        $col = new Collection('int');
        [$h,$t] = $col->headAndTail();

        $this->assertNull($h);
        $this->assertNull($t);
    }

    public function test_collection_with_one_item_returns_head_and_null_tail()
    {
        $col = new Collection('int', [1]);
        [$h, $t] = $col->headAndTail();

        $this->assertEquals(1, $h);
        $this->assertNull($t);
    }

    public function test_hat_works_the_same()
    {
        $col = new Collection('int', [1,2,3]);
        [ $h, $t ] = $col->hat();
        $this->assertEquals(1, $h);
        $this->assertEquals([2,3], $t->toArray());

        [$h, $t] = $t->hat();

        $this->assertEquals(2, $h);
        $this->assertEquals([3], $t->toArray());

        [$h, $t ] = $t->hat();

        $this->assertEquals(3, $h);
        $this->assertNull($t);

    }
}
