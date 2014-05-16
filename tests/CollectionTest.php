<?php

use Collections\Collection;

class ControllerTest extends PHPUnit_Framework_TestCase {

  public function setup(){
    $this->c = new Collection("TestClassA");
  }

  public function testGetObjectName(){
      $this->assertEquals("TestClassA",$this->c->getObjectName());
  }

  public function testValidateIndex(){
    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");  
    $this->c->at("one");
  }

  public function testAddAndRetrieveFunctions(){
    $a = new TestClassA(1);

    //count should be zero, add item and count should be 1
    $this->assertEquals("0",$this->c->count());
    $this->c->add($a);
    $this->assertEquals("1",$this->c->count());

    //we can only add items that are of type TestClassA
    //expect a InvalidArgumentExeption
    //count should stay 1
    $b = new TestClassB;

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->add($b);

    //we should be able to add subtypes of TestClassA
    $extendsA = new TestClassExtendsA(2);
    $this->c->add($extendsA);
    $this->assertEquals("2",$this->c->count());

    //test retrieval function
    $this->assertEquals($a,$this->c->at(0));
    $this->assertEquals($extendsA,$this->c->at(1));
  }

  public function testAddRange(){
    //add range should append, so start with 1 item
    $a = new TestClassA(0);
    $this->c->add($a);

    $items = array();
    for($i = 1; $i < 6; $i++){
      $items[] = new TestClassA($i);
    }

    $this->c->addRange($items);

    $this->assertEquals(6,$this->c->count());
    $this->assertEquals($a,$this->c->at(0));
    $this->assertEquals($items[2],$this->c->at(3));

    $this->assertEquals(6,$this->c->count());

    //we can add a range of items that extend our base class
    $moreItems = array();
    $moreItems[] = new TestClassExtendsA(6);
    $moreItems[] = new TestClassExtendsA(7);

    $this->c->addRange($moreItems);
    $this->assertEquals(8,$this->c->count());

    $badItems = array();
    $badItems[] = new TestClassB();
    $badItems[] = new TestClassB();


    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->addRange($badItems);
    $this->assertEquals(8,$this->c->count());

  }

  public function testClear(){
    $this->c->add(new TestClassA(1));
    $this->assertEquals(1,$this->c->count());
    $this->c->clear();
    $this->assertEquals(0,$this->c->count());
  }

  public function testContains(){
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(3));
    $this->c->add(new TestClassA(4));

    //this should exist
    $needle = new TestClassA(3);
    $this->assertEquals(true,$this->c->contains($needle));

    //this does not
    $needle = new TestClassA(5);
    $this->assertEquals(false,$this->c->contains($needle));

    //we can check a subtype, which shouldn't be found
    $needle = new TestClassExtendsA(3);
    $this->assertEquals(false,$this->c->contains($needle));

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $needle = new TestClassB();
    $this->c->contains($needle);
  }

  public function testExists(){
    $this->c->add(new TestClassA(54));
    $this->c->add(new TestClassA(32));

    $condition = function($item){
      return $item->getValue() == 32;
    };

    $this->assertEquals(true,$this->c->exists($condition));

    $condition = function($item){
      return $item->getValue() == 42;
    };

    $this->assertEquals(false,$this->c->exists($condition));
  }

  public function testFind(){
    $this->c->add(new TestClassA(54));
    $this->c->add(new TestClassA(32));

    $condition = function($item){
      return $item->getValue() == 32;
    };

    $this->assertEquals(new TestClassA(32),$this->c->find($condition));

    $condition = function($item){
      return $item->getValue() == 42;
    };

    $this->assertEquals(false,$this->c->find($condition));
  }

  public function testFindLast(){
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(4));
    $this->c->add(new TestClassA(6));
 
    $item = $this->c->findLast(function($item){
        return $item->getValue() % 2 == 0;
    });

    $this->assertEquals($item->getValue(),6);
  }

  public function testFindAll(){
    $this->c->add(new TestClassA(54));
    $this->c->add(new TestClassA(32));
    $this->c->add(new TestClassA(32));
    $this->c->add(new TestClassA(32));

    $condition = function($item){
      return $item->getValue() == 32;
    };

    $subset = $this->c->findAll($condition);

    $c = new Collection("TestClassA");
    $c->add(new TestClassA(32));
    $c->add(new TestClassA(32));
    $c->add(new TestClassA(32));

    $this->assertEquals(3,$subset->count());
    $this->assertEquals($c,$subset);
  }

  public function testFindIndex(){
    $this->c = new Collection("TestClassA");
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(4));
    $this->c->add(new TestClassA(6));
    $this->c->add(new TestClassA(8));

    $findEven = function($item){
      return $item->getValue() % 2 == 0;
    };

    $findOdd = function($item){
      return $item->getValue() % 2 != 0;
    };

    $this->assertEquals(0,$this->c->findIndex($findEven));
    $this->assertEquals(-1,$this->c->findIndex($findOdd));
    $this->assertEquals(3,$this->c->findLastIndex($findEven));
  }

  public function testGetRange(){
    $items = array();
    for($i = 0; $i<10;$i++){
      $items[] = new TestClassA($i);
    }

    $this->c->addRange($items);

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->getRange(-1,3);


    //start must be natural number
    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->getRange(1,-4);

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->getRange(3,2);

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->getRange(20,22);

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->getRange(2,22);

    $subset = $this->c->getRange(2,4);

    $this->assertEquals(3,$subset->count());
    $this->assertEquals(new TestClassA(2),$subset->at(0));
    $this->assertEquals(new TestClassA(3),$subset->at(1));
    $this->assertEquals(new TestClassA(4),$subset->at(2));
  }

  public function testInsert(){
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));

    $this->c->insert(1,new TestClassA(3));

    $this->assertEquals(3,$this->c->at(1)->getValue());

    $this->setExpectedException("Collections\Exceptions\OutOfRangeException");
    $this->c->insert(100, new TestClassA(5));

    $this->setExpectedException("Collections\Exceptions\InvalidArgumentException");
    $this->c->insert(-1, new TestClassA(5));
  }

  public function testInsertRange(){
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));

    $items = array();
    $items[] = new TestClassA(3);
    $items[] = new TestClassA(4);

    $this->c->insertRange(1,$items);

    $this->assertEquals(4,$this->c->count());
    $this->assertEquals(1,$this->c->at(0)->getValue());
    $this->assertEquals(3,$this->c->at(1)->getValue());
    $this->assertEquals(4,$this->c->at(2)->getValue());
    $this->assertEquals(2,$this->c->at(3)->getValue());
  }

  public function testRemove(){
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(3));
    $this->c->add(new TestClassA(4));

    $removeOdd = function($item){
      return $item->getValue() % 2 != 0;
    };

    $this->assertEquals(true,$this->c->remove($removeOdd));
    $this->assertEquals(3,$this->c->count());
    $this->assertEquals(2,$this->c->at(0)->getValue());
    $this->assertEquals(3,$this->c->at(1)->getValue());
    $this->assertEquals(4,$this->c->at(2)->getValue());

    $mustFail = function($item){
        return $item->getValue() == 42;
    };

    $this->assertEquals(false,$this->c->remove($mustFail));
  }

  public function testRemoveAt(){
    $items = array();
    $items[] = new TestClassA(3);
    $items[] = new TestClassA(2);
    $items[] = new TestClassA(1);

    $this->c->addRange($items);

    $this->assertEquals(3,$this->c->count());

    $this->c->removeAt(1);

    $this->assertEquals(2,$this->c->count());
    $this->assertEquals(1,$this->c->at(1)->getValue());
   
  }

  public function testRemoveLast(){
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(3));
    $this->c->add(new TestClassA(4));

    $removeOdd = function($item){
      return $item->getValue() % 2 != 0;
    };

    $this->assertEquals(true,$this->c->removeLast($removeOdd));
    $this->assertEquals(3,$this->c->count());
    $this->assertEquals(1,$this->c->at(0)->getValue());
    $this->assertEquals(2,$this->c->at(1)->getValue());
    $this->assertEquals(4,$this->c->at(2)->getValue());

    $mustFail = function($item){
        return $item->getValue() == 100;
    };

    $this->assertEquals(false,$this->c->removeLast($mustFail));
  }

  public function testReverse(){
    $items = array();
    $items[] = new TestClassA(3);
    $items[] = new TestClassA(2);
    $items[] = new TestClassA(1);

    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(3));

    $this->c->reverse();
    $this->assertEquals($items,$this->c->toArray());
  }

  public function testSort(){

    $this->c->add(new TestClassA(3));
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(4));
    $this->c->add(new TestClassA(2));

    $comparitor = function($a,$b){
        if ($a == $b) {
            return 0;
        }

        return ($a < $b) ? -1 : 1;
    };
 
    $this->c->sort($comparitor);
    $this->assertEquals(1,$this->c->at(0)->getValue());
    $this->assertEquals(2,$this->c->at(1)->getValue());
    $this->assertEquals(3,$this->c->at(2)->getValue());
    $this->assertEquals(4,$this->c->at(3)->getValue());
  }

  public function testToArray(){
    $items = array();
    $items[] = new TestClassA(1);
    $items[] = new TestClassA(2);
    $items[] = new TestClassA(3);

    $this->c->addRange($items);
    $this->assertEquals($items,$this->c->toArray());
  }

  public function testMap(){
      $items = array();
      $items[] = new TestClassA(1);
      $items[] = new TestClassA(2);
      $items[] = new TestClassA(3);
      $this->c->addRange($items);

      /* map should return new collection without modifying the existing collection */
      $newCollection = $this->c->map(
          function($n){
              $n->setValue($n->getValue() * 3);
              return $n;
          });
      $this->assertEquals(($this->c->at(0)->getValue() * 3), $newCollection->at(0)->getValue());
      $this->assertEquals(($this->c->at(1)->getValue() * 3), $newCollection->at(1)->getValue());
      $this->assertEquals(($this->c->at(2)->getValue() * 3), $newCollection->at(2)->getValue());

      /* map should allow mapping collection of class A to collection of class B */
      $stdCollection = $this->c->map(
          function($n){
              $o = new stdClass();
              $o->value = $n->getValue();
              return $o;
          }, 'stdClass');

      $this->assertEquals($stdCollection->getObjectName(), 'stdClass');
      $this->assertEquals($this->c->at(0)->getValue(), $stdCollection->at(0)->value);
      $this->assertEquals($this->c->at(1)->getValue(), $stdCollection->at(1)->value);
      $this->assertEquals($this->c->at(2)->getValue(), $stdCollection->at(2)->value);
  }

  public function testWalk(){
      $items = array();
      $items[] = new TestClassA(1);
      $items[] = new TestClassA(2);
      $items[] = new TestClassA(3);
      $this->c->addRange($items);
 
      $this->arr = array();
      $this->assertEquals(TRUE,
          $this->c->walk(function($n){
              $this->arr[] = $n->getValue();
          }));
      $this->assertEquals(1, $this->arr[0]);
      $this->assertEquals(2, $this->arr[1]);
      $this->assertEquals(3, $this->arr[2]);

      /**
       * Walk should allow for $userdata to be passed to $callback,
       * as well as modifying the original collection.
       */
      $this->assertEquals(TRUE,
          $this->c->walk(function($n, $index, $userdata){
              $n->setValue($n->getValue() * $userdata);
          }, 5));

      $this->assertEquals(5, $this->c->at(0)->getValue());
      $this->assertEquals(10, $this->c->at(1)->getValue());
      $this->assertEquals(15, $this->c->at(2)->getValue());

      /**
       * Walk should not allow members of the collection to be changed
       * to a type that is incompatible with the current collection.
       */
      $this->assertEquals(FALSE,
          $this->c->walk(function(&$n){
              $n = new TestClassB;
          }));
  }

  public function testIterator(){
    $iterator = $this->c->getIterator();
    $class = get_class($iterator);
    $this->assertEquals($class,"ArrayIterator");
  }
}
