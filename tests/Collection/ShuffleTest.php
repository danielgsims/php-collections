<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class ShuffleTest extends TestCase
{
    public function test_shuffle()
    {
        $col = new Collection('int');
        $col = $col->add(1);
        $col = $col->add(2);
        $col = $col->add(3);
        $col = $col->add(4);
        $col = $col->add(5);
        $col = $col->add(6);
        $col = $col->add(7);
        $col = $col->add(8);
        $col = $col->add(9);
        $col = $col->add(10);

        $shuffled = $col->shuffle();

        $this->assertTrue($shuffled->contains(function ($a) { return $a == 1; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 2; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 3; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 4; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 5; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 6; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 7; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 8; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 9; }));
        $this->assertTrue($shuffled->contains(function ($a) { return $a == 10; }));

        $this->assertNotEquals($col, $shuffled);
    }
}
