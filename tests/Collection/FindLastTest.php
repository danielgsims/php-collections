<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class FindLastTest extends TestCase
{
    public function testFindLast()
    {
        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(4));
        $this->c = $this->c->add(new TestClassA(6));

        $item = $this->c->findLast(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertEquals($item->getValue(), 6);
    }
}