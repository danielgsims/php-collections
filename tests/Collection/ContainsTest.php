<?php

use Collections\Collection;

class ContainsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Collection
     */
    private $col;

    public function setup()
    {
        $this->col = new Collection('TestClassA',
            [
               new TestClassA(1),
               new TestClassA(2)
            ]);
    }

    public function test_contains_finds_target_and_returns_true()
    {
        $result = $this->col->contains(function(TestClassA $item) {
            return $item->getValue() == 2;
        });

        $this->assertTrue($result);
    }


    public function test_contains_finds_when_no_match_returns_false()
    {
        $result = $this->col->contains(function(TestClassA $item) {
            return $item->getValue() == 42;
        });

        $this->assertFalse($result);
    }
}