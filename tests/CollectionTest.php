<?php

use danielgsims\Collection;

class TestClassA{
  private $v;
  public function __construct($v){
    $this->setValue($v);
  }

  public function getValue(){
    return $this->v;
  }

  public function setValue($v){
    $this->v = $v;
  }
}

class TestClassB{

}

class TestClassExtendsA extends TestClassA{

}

class ControllerTest extends PHPUnit_Framework_TestCase {

  public function setup(){
    $this->c = new Collection("TestClassA");
  }

  public function testGetObjectName(){
      $this->assertEquals("TestClassA",$this->c->getObjectName());
  }

  public function testValidateIndex(){
    try{
      $this->c->at("one");
    } catch (\Exception $e){
      $classname = get_class($e);
    }

    $this->assertEquals("danielgsims\InvalidArgumentException",$classname);
    $this->assertEquals("Index must be an integer",$e->getMessage());
  
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
    $this->classname = "";

    try{
      $this->c->add($b);
    } catch (\Exception $e){
      $this->classname = get_class($e);
    }

    $this->assertEquals("danielgsims\InvalidArgumentException",$this->classname);
    $this->assertEquals("1",$this->c->count());

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

    $classname = "";

    try{
      $this->c->addRange($badItems);
    } catch (\Exception $e){
      $classname = get_class($e);
    }

    $this->assertEquals("danielgsims\InvalidArgumentException",$classname);
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

    //we cannot check for something out of the inheritence chain
    $classname = "";

    try{
      $needle = new TestClassB();
      $this->c->contains($needle);
    } catch (\Exception $e){
      $classname = get_class($e);
    }

    $this->assertEquals("danielgsims\InvalidArgumentException",$classname);

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

    //start must be natural number
    try{
      $this->c->getRange(-1,3);
    } catch (Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\InvalidArgumentException");
    $this->assertEquals($e->getMessage(),"Start must be a non-negative integer");

    //start must be natural number
    try{
      $this->c->getRange(1,-4);
    } catch (Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\InvalidArgumentException");
    $this->assertEquals($e->getMessage(),"End must be a positive integer");

    unset($e);
    try{
      $this->c->getRange(3,2);
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\InvalidArgumentException");
    $this->assertEquals($e->getMessage(),"End must be greater than start");

    unset($e);
    try{
      $this->c->getRange(20,22);
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\InvalidArgumentException");
    $this->assertEquals($e->getMessage(),"Start must be less than the count of the items in the Collection");

    unset($e);
    try{
      $this->c->getRange(2,22);
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\InvalidArgumentException");
    $this->assertEquals($e->getMessage(),"End must be less than the count of the items in the Collection");


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

    try{
      $this->c->insert(100, new TestClassA(5));
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\OutOfRangeException");
    $this->assertEquals($e->getMessage(),"Index out of bounds of collection");

    try{
      $this->c->insert(-1, new TestClassA(5));
    } catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"danielgsims\InvalidArgumentException");
    $this->assertEquals($e->getMessage(),"Index must be a non-negative integer");

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

  public function testRemoveAll(){
    $this->c->add(new TestClassA(1));
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(3));
    $this->c->add(new TestClassA(4));

    $removeOdd = function($item){
      return $item->getValue() % 2 != 0;
    };

    $this->assertEquals(2,$this->c->removeAll($removeOdd));
    $this->assertEquals(2,$this->c->count());
    $this->assertEquals(2,$this->c->at(0)->getValue());
    $this->assertEquals(4,$this->c->at(1)->getValue());

    $mustRemoveNone = function($item){
        return $item->getValue() == 42;
    };

    $this->assertEquals(0,$this->c->removeAll($mustRemoveNone));
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

  public function testIterator(){
    $iterator = $this->c->getIterator();
    $class = get_class($iterator);
    $this->assertEquals($class,"ArrayIterator");
  }
}
