<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class WithoutTest extends TestCase
{
    public function test_without_returns_items_that_do_not_match_criteria()
    {
        $col = new Collection('int',[1,2,3,4,5]);

        $odds = $col->without(function($item) {
            return $item % 2 == 0;
        });

        $this->assertEquals(new Collection('int',[1,3,5]), $odds);
    }
}
