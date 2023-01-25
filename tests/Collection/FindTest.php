<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class FindTest extends TestCase
{
    /**
     * @var Collection
     */
    private $col;

    public function setup(): void
    {
         $this->col = new Collection(
            'TestClassA', [
                new TestClassA(1),
                new TestClassA(2),
                 new TestClassA(3),
                 new TestClassA(4),
                 new TestClassA(5),
            ]
        );
    }

    public function test_find_returns_first_item_that_matches()
    {
        $isEven = function (TestClassA $item) {
            return $item->getValue() % 2 === 0;
        };

        $result = $this->col->find($isEven);

        $this->assertEquals(new TestClassA(2), $result);
    }

    public function test_find_returns_false_if_no_match()
    {
        $isOverTen = function(TestClassA $item) {
            return $item->getValue() > 10;
        };

        $result = $this->col->find($isOverTen);

        $this->assertFalse($result);
    }
}