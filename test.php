<?php

require_once("Collection.php");
require_once("testClass.php");
class ControllerTest extends PHPUnit_Framework_TestCase {

  public function setup(){
    $this->c = new Collection("TestClassA");
  }

  public function testAddAndRetrieveFunctions(){
    $a = new TestClassA(1);

    //count should be zero, add item and count should be 1
    $this->assertEquals("0",$this->c->count());
    $this->c->add($a);
    $this->assertEquals("1",$this->c->count());

    //we can only add items that are of type TestClassA
    //expect a CollectionInvalidArgumentExeption
    //count should stay 1
    $b = new TestClassB;
    $this->classname = "";

    try{
      $this->c->add($b);
    } catch (Exception $e){
      $this->classname = get_class($e);
    }

    $this->assertEquals("CollectionInvalidArgumentException",$this->classname);
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
    } catch (Exception $e){
      $classname = get_class($e);
    }

    $this->assertEquals("CollectionInvalidArgumentException",$classname);
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
    } catch (Exception $e){
      $classname = get_class($e);
    }

    $this->assertEquals("CollectionInvalidArgumentException",$classname);

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
    $this->c->add(new TestClassA(2));
    $this->c->add(new TestClassA(4));
    $this->c->add(new TestClassA(6));
    $this->c->add(new TestClassA(8));

    $findEven = function($item){
      return $item->getValue() % 2 == 0;
    };

    $this->assertEquals(0,$this->c->findIndex($findEven));

    $findOdd = function($item){
      return $item->getValue() % 2 != 0;
    };

    $this->assertEquals(-1,$this->c->findIndex($findOdd));

    $findDivByFour = function($item){
      return $item->getValue() % 4 == 0;
    };

    $this->assertEquals(1,$this->c->findIndex($findDivByFour));

    $this->assertEquals(3,$this->c->findLastIndex($findDivByFour));
    $this->assertEquals(-1,$this->c->findLastIndex($findOdd));
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

    $this->assertEquals(get_class($e),"CollectionInvalidArgumentException");
    $this->assertEquals($e->getMessage(),"Start must be a non-negative integer");

    //start must be natural number
    try{
      $this->c->getRange(1,-4);
    } catch (Exception $e){
    }
    
    $this->assertEquals(get_class($e),"CollectionInvalidArgumentException");
    $this->assertEquals($e->getMessage(),"End must be a positive integer");

    unset($e);
    try{
      $this->c->getRange(3,2);
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"CollectionInvalidArgumentException");
    $this->assertEquals($e->getMessage(),"End must be greater than start");

    unset($e);
    try{
      $this->c->getRange(20,22);
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"CollectionInvalidArgumentException");
    $this->assertEquals($e->getMessage(),"Start must be less than the count of the items in the Collection");

    unset($e);
    try{
      $this->c->getRange(2,22);
    }catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"CollectionInvalidArgumentException");
    $this->assertEquals($e->getMessage(),"End must be less than the count of the items in the Collection");


    $subset = $this->c->getRange(2,5);

    $this->assertEquals(4,$subset->count());
    $this->assertEquals(new TestClassA(2),$subset->at(0));
    $this->assertEquals(new TestClassA(3),$subset->at(1));
    $this->assertEquals(new TestClassA(4),$subset->at(2));
    $this->assertEquals(new TestClassA(5),$subset->at(3));
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

    $this->assertEquals(get_class($e),"CollectionOutOfRangeException");
    $this->assertEquals($e->getMessage(),"Index out of bounds of collection");

    unset($e);
    try{
      $this->c->insert(-1, new TestClassA(5));
    } catch(Exception $e){
    }

    $this->assertEquals(get_class($e),"CollectionOutOfRangeException");
    $this->assertEquals($e->getMessage(),"Index cannot be negative");

  }

  public function testInsertRange(){

  }

  public function testRemove(){

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

  }

  public function toArray(){
    $items = array();
    $items[] = new TestClassA(1);
    $items[] = new TestClassA(2);
    $items[] = new TestClassA(3);

    $this->c->addRange($items);
    $this->assertEquals($items,$this->c->toArray());
  }
}
