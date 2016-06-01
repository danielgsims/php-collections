<?php

use Collections\Collection;

class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Collection
     */
    private $c;

    public function setup()
    {
        $this->c = new Collection("TestClassA");
    }

    private function collectionOne()
    {
        return new Collection('TestClassA', [
            new TestClassA(1),
            new TestClassA(2),
            new TestClassA(3),
            new TestClassA(4),
        ]);
    }

    private function collectionTwo()
    {
        return new Collection(
            'TestClassA', [
                new TestClassA(54),
                new TestClassA(32),
            ]
        );
    }

    private function collectionEvens()
    {
        return new Collection('TestClassA', [
            new TestClassA(2),
            new TestClassA(4),
            new TestClassA(6)
        ]);
    }

    public function testGetObjectName()
    {
        $this->assertEquals("TestClassA", $this->c->getObjectName());
    }
    public function testAddRange()
    {
        //add range should append, so start with 1 item
        $a = new TestClassA(0);
        $this->c = $this->c->add($a);

        $items = array();
        for ($i = 1; $i < 6; $i++) {
            $items[] = new TestClassA($i);
        }

        $this->c = $this->c->addRange($items);

        $this->assertEquals(6, $this->c->count());
        $this->assertEquals($a, $this->c->at(0));
        $this->assertEquals($items[2], $this->c->at(3));

        $this->assertEquals(6, $this->c->count());

        //we can add a range of items that extend our base class
        $moreItems = array();
        $moreItems[] = new TestClassExtendsA(6);
        $moreItems[] = new TestClassExtendsA(7);

        $this->c = $this->c->addRange($moreItems);
        $this->assertEquals(8, $this->c->count());

        $badItems = array();
        $badItems[] = new TestClassB();
        $badItems[] = new TestClassB();


        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $this->c = $this->c->addRange($badItems);
        $this->assertEquals(8, $this->c->count());

    }

    public function testContains()
    {
        $col = $this->collectionOne();

        //this should exist
        $needle = new TestClassA(3);
        $this->assertEquals(true, $col->contains($needle));

        //this does not
        $needle = new TestClassA(5);
        $this->assertEquals(false, $col->contains($needle));

        //we can check a subtype, which shouldn't be found
        $needle = new TestClassExtendsA(3);
        $this->assertEquals(false, $col->contains($needle));

        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $needle = new TestClassB();
        $col->contains($needle);
    }

    public function testExists()
    {
        $col = $this->collectionTwo();

        $condition = function ($item) {
            return $item->getValue() == 32;
        };

        $this->assertEquals(true, $col->exists($condition));

        $condition = function ($item) {
            return $item->getValue() == 42;
        };

        $this->assertEquals(false, $col->exists($condition));
    }

    public function testFind()
    {
        $col = $this->collectionTwo();

        $condition = function ($item) {
            return $item->getValue() == 32;
        };

        $this->assertEquals(new TestClassA(32), $col->find($condition));

        $condition = function ($item) {
            return $item->getValue() == 42;
        };

        $this->assertEquals(false, $col->find($condition));
    }

    public function testFindLast()
    {
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(4));
        $this->c = $this->c->add(new TestClassA(6));

        $item = $this->c->findLast(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertEquals($item->getValue(), 6);
    }

    public function testFindAll()
    {
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

    public function testFindIndex()
    {
        $this->c = new Collection("TestClassA");
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(4));
        $this->c = $this->c->add(new TestClassA(6));
        $this->c = $this->c->add(new TestClassA(8));

        $findEven = function ($item) {
            return $item->getValue() % 2 == 0;
        };

        $findOdd = function ($item) {
            return $item->getValue() % 2 != 0;
        };

        $this->assertEquals(0, $this->c->findIndex($findEven));
        $this->assertEquals(-1, $this->c->findIndex($findOdd));
        $this->assertEquals(3, $this->c->findLastIndex($findEven));
    }

    public function testInsert()
    {
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));

        $this->c->insert(1, new TestClassA(3));

        $this->assertEquals(3, $this->c->at(1)->getValue());

        $this->setExpectedException("Collections\Exceptions\OutOfRangeException");
        $this->c->insert(100, new TestClassA(5));

        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $this->c->insert(-1, new TestClassA(5));
    }

    public function testInsertRange()
    {
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));

        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(4);

        $this->c->insertRange(1, $items);

        $this->assertEquals(4, $this->c->count());
        $this->assertEquals(1, $this->c->at(0)->getValue());
        $this->assertEquals(3, $this->c->at(1)->getValue());
        $this->assertEquals(4, $this->c->at(2)->getValue());
        $this->assertEquals(2, $this->c->at(3)->getValue());
    }

    public function testRemove()
    {
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(3));
        $this->c = $this->c->add(new TestClassA(4));

        $removeOdd = function ($item) {
            return $item->getValue() % 2 != 0;
        };

        $this->assertEquals(true, $this->c->remove($removeOdd));
        $this->assertEquals(3, $this->c->count());
        $this->assertEquals(2, $this->c->at(0)->getValue());
        $this->assertEquals(3, $this->c->at(1)->getValue());
        $this->assertEquals(4, $this->c->at(2)->getValue());

        $mustFail = function ($item) {
            return $item->getValue() == 42;
        };

        $this->assertEquals(false, $this->c->remove($mustFail));
    }

    public function testRemoveAll()
    {
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(3));
        $this->c = $this->c->add(new TestClassA(4));

        $removeOdd = function ($item) {
            return $item->getValue() % 2 != 0;
        };

        $this->assertEquals(2, $this->c->removeAll($removeOdd));
        $this->assertEquals(2, $this->c->count());
        $this->assertEquals(2, $this->c->at(0)->getValue());
        $this->assertEquals(4, $this->c->at(1)->getValue());

        $mustRemoveNone = function ($item) {
            return $item->getValue() == 42;
        };

        $this->assertEquals(0, $this->c->removeAll($mustRemoveNone));
    }

    public function testRemoveAt()
    {
        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(2);
        $items[] = new TestClassA(1);

        $this->c = $this->c->addRange($items);

        $this->assertEquals(3, $this->c->count());

        $this->c->removeAt(1);

        $this->assertEquals(2, $this->c->count());
        $this->assertEquals(1, $this->c->at(1)->getValue());

    }

    public function testRemoveLast()
    {
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(3));
        $this->c = $this->c->add(new TestClassA(4));

        $removeOdd = function ($item) {
            return $item->getValue() % 2 != 0;
        };

        $this->assertEquals(true, $this->c->removeLast($removeOdd));
        $this->assertEquals(3, $this->c->count());
        $this->assertEquals(1, $this->c->at(0)->getValue());
        $this->assertEquals(2, $this->c->at(1)->getValue());
        $this->assertEquals(4, $this->c->at(2)->getValue());

        $mustFail = function ($item) {
            return $item->getValue() == 100;
        };

        $this->assertEquals(false, $this->c->removeLast($mustFail));
    }

    public function testReverse()
    {
        $items = array();
        $items[] = new TestClassA(3);
        $items[] = new TestClassA(2);
        $items[] = new TestClassA(1);

        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(2));
        $this->c = $this->c->add(new TestClassA(3));

        $this->c->reverse();
        $this->assertEquals($items, $this->c->toArray());
    }

    public function testSort()
    {

        $this->c = $this->c->add(new TestClassA(3));
        $this->c = $this->c->add(new TestClassA(1));
        $this->c = $this->c->add(new TestClassA(4));
        $this->c = $this->c->add(new TestClassA(2));

        $comparitor = function ($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? -1 : 1;
        };

        $this->c->sort($comparitor);
        $this->assertEquals(1, $this->c->at(0)->getValue());
        $this->assertEquals(2, $this->c->at(1)->getValue());
        $this->assertEquals(3, $this->c->at(2)->getValue());
        $this->assertEquals(4, $this->c->at(3)->getValue());
    }

    public function testToArray()
    {
        $items = array();
        $items[] = new TestClassA(1);
        $items[] = new TestClassA(2);
        $items[] = new TestClassA(3);

        $this->c = $this->c->addRange($items);
        $this->assertEquals($items, $this->c->toArray());
    }

    public function testIterator()
    {
        $iterator = $this->c->getIterator();
        $class = get_class($iterator);
        $this->assertEquals($class, "ArrayIterator");
    }

    public function testClone()
    {
        $t = new TestClassA(1);
        $this->c = $this->c->add($t);
        $c = clone $this->c;

        // Original collection entries are unmodified
        $this->assertTrue($t === $this->c->at(0));
        // Entries are equivalent
        $this->assertTrue($t == $c->at(0));
        // Cloned collection entries have new references
        $this->assertFalse($t === $c->at(0));
        // Cloned collections are equivalent
        $this->assertTrue($this->c == $c);
        // Cloned collection has new reference
        $this->assertFalse($this->c === $c);
        // Cloned collection entries are equivalent to original collection entries
        $this->assertTrue($this->c->at(0) == $c->at(0));
        // Cloned collection entries have different references from original collection entries
        $this->assertFalse($this->c->at(0) === $c->at(0));
    }

    public function testIndexExits()
    {
        $t = new TestClassA(1);
        $t2 = new TestClassA(2);
        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);

        $this->assertTrue($this->c->indexExists(0));
        $this->assertTrue($this->c->indexExists(1));
        $this->assertFalse($this->c->indexExists(2));
    }

    public function testIndexExitsRejectsNegatives()
    {
        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $this->c->indexExists(-1);
    }

    public function testIndexExitsRejectsNonIntegers()
    {
        $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
        $this->c->indexExists("wat");
    }

    public function testReduce()
    {
        $t = new TestClassA(1);
        $t2 = new TestClassA(2);
        $t3 = new TestClassA(3);

        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);

        $result = $this->c->reduce(function ($total, $item) {
            return $total + $item->getValue();
        });

        $this->assertEquals(6, $result);

        $result = $this->c->reduce(function ($total, $item) {
            return $total + $item->getValue();
        }, 2);

        $this->assertEquals(8, $result);
    }

    public function testEvery()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);

        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);

        $result = $this->c->every(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertTrue($result);

        $result = $this->c->every(function ($item) {
            return $item->getValue() % 2 != 0;
        });

        $this->assertFalse($result);
    }

    public function testTake()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);

        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);
        $c1 = $this->c->take(1);
        $c2 = $this->c->take(2);
        $c3 = $this->c->take(3);

        $this->assertEquals(1, $c1->count());
        $this->assertEquals(2, $c2->count());
        $this->assertEquals(3, $c3->count());

        $this->assertEquals($t, $c1->at(0));

        $this->assertEquals($t, $c2->at(0));
        $this->assertEquals($t2, $c2->at(1));

        $this->assertEquals($t, $c3->at(0));
        $this->assertEquals($t2, $c3->at(1));
        $this->assertEquals($t3, $c3->at(2));
    }

    public function testTakeRight()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(6);

        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);

        $c1 = $this->c->takeRight(1);
        $c2 = $this->c->takeRight(2);
        $c3 = $this->c->takeRight(3);

        $this->assertEquals(1, $c1->count());
        $this->assertEquals(2, $c2->count());
        $this->assertEquals(3, $c3->count());

        $this->assertEquals($t3, $c1->at(0));

        $this->assertEquals($t2, $c2->at(0));
        $this->assertEquals($t3, $c2->at(1));

        $this->assertEquals($t, $c3->at(0));
        $this->assertEquals($t2, $c3->at(1));
        $this->assertEquals($t3, $c3->at(2));
    }

    public function test_take_while()
    {
        $t = new TestClassA(2);
        $t2 = new TestClassA(4);
        $t3 = new TestClassA(7);
        $t4 = new TestClassA(9);

        $this->c = $this->c->add($t);
        $this->c = $this->c->add($t2);
        $this->c = $this->c->add($t3);
        $this->c = $this->c->add($t4);

        $c1 = $this->c->takeWhile(function ($item) {
            return $item->getValue() % 2 == 0;
        });

        $this->assertEquals(2, $c1->count());

        $this->assertEquals($t, $c1->at(0));
        $this->assertEquals($t2, $c1->at(1));

        $c2 = $this->c->takeWhile(function ($item) {
            return true;
        });
        $this->assertEquals($this->c, $c2);

        $c3 = $this->c->takeWhile(function ($item) {
            return false;
        });
        $this->assertEquals(0, $c3->count());
    }
}
