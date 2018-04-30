<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class ReduceRightTest extends TestCase
{
    public function test_reduce_right_add()
    {
        $this->c = new Collection('int');
        $this->c = $this->c->add(1);
        $this->c = $this->c->add(3);
        $this->c = $this->c->add(10);
        $this->c = $this->c->add(4);

        $c1 = $this->c->reduceRight(function ($carry, $inc) { return $carry + $inc; });

        $this->assertEquals(18, $c1);
    }

    public function test_reduce_right_sub()
    {
        $this->c = new Collection('int');
        $this->c = $this->c->add(1);
        $this->c = $this->c->add(3);
        $this->c = $this->c->add(5);
        $this->c = $this->c->add(10);

        $c1 = $this->c->reduceRight(function ($carry, $inc) { return $carry - $inc; });

        $this->assertEquals(-19, $c1);
    }

    public function test_reduce_right_sub_non_zero_default()
    {
        $this->c = new Collection('int');
        $this->c = $this->c->add(1);
        $this->c = $this->c->add(3);
        $this->c = $this->c->add(10);
        $this->c = $this->c->add(4);

        $c1 = $this->c->reduceRight(function ($carry, $inc) { return $carry - $inc; }, 20);

        $this->assertEquals(2, $c1);
    }

    public function test_reduce_right_string()
    {
        $this->c = new Collection('string');
        $this->c = $this->c->add('a');
        $this->c = $this->c->add('b');
        $this->c = $this->c->add('c');
        $this->c = $this->c->add('d');

        $c1 = $this->c->reduceRight(function ($carry, $inc) { return $carry .= $inc; });

        $this->assertEquals('dcba', $c1);
    }

    public function test_reduce_right_string_with_default()
    {
        $this->c = new Collection('string');
        $this->c = $this->c->add('a');
        $this->c = $this->c->add('b');
        $this->c = $this->c->add('c');
        $this->c = $this->c->add('d');

        $c1 = $this->c->reduceRight(function ($carry, $inc) { return $carry .= $inc; }, 'z');

        $this->assertEquals('zdcba', $c1);
    }
}
