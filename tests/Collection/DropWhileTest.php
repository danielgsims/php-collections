<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class DropWhileTest extends TestCase
{
    private \Collections\CollectionInterface $col;

    public function test_drop_while()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);
        $t4 = new TestClassA(7);
        $t5 = new TestClassA(8);

        $this->col = new Collection('TestClassA');
        $this->col = $this->col->add($t);
        $this->col = $this->col->add($t2);
        $this->col = $this->col->add($t3);
        $this->col = $this->col->add($t4);
        $this->col = $this->col->add($t5);

        $col1 = $this->col->dropWhile(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertEquals(2, $col1->count());

        $this->assertEquals($t4, $col1->at(0));
        $this->assertEquals($t5, $col1->at(1));

        $col2 = $this->col->dropWhile(function ($item) {
            return false;
        });

        $this->assertEquals($this->col, $col2);

        $col3 = $this->col->dropWhile(function ($item) {
            return true;
        });

        $this->assertEquals(0, $col3->count());
    }

    public function test_drop_while_twice_on_same_instance()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);
        $t4 = new TestClassA(7);
        $t5 = new TestClassA(8);

        $this->col = new Collection('TestClassA');
        $this->col = $this->col->add($t);
        $this->col = $this->col->add($t2);
        $this->col = $this->col->add($t3);
        $this->col = $this->col->add($t4);
        $this->col = $this->col->add($t5);

        $col1 = $this->col->dropWhile(function ($item) {
            return $item->getValue() % 2 == 0;
          });

        $col1 = $col1->dropWhile(function($item) {
            return $item->getValue() % 2 != 0;
        });

        $this->assertEquals(1, $col1->count());
        $this->assertEquals($t5, $col1->at(0));
    }
}
