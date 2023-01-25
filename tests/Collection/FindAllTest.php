<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class FindAllTest extends TestCase
{
    private Collection $c;

    public function testFindAll()
    {
        $this->c = new Collection('TestClassA');
        $this->c = $this->c->add(new TestClassA(54));
        $this->c = $this->c->add(new TestClassA(32));
        $this->c = $this->c->add(new TestClassA(32));
        $this->c = $this->c->add(new TestClassA(32));

        $condition = function ($item) {
            return $item->getValue() == 32;
        };

        $subset = $this->c->filter($condition);

        $c = (new Collection("TestClassA"))
            ->add(new TestClassA(32))
            ->add(new TestClassA(32))
            ->add(new TestClassA(32));

        $this->assertEquals(3, $subset->count());
        $this->assertEquals($c, $subset);
    }

}