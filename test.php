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
  
}
