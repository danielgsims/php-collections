<?php

use Collections\Collection;

class SpecificCollectionTest extends PHPUnit_Framework_TestCase {

  public function setup(){
    $this->c = new SpecificCollection;
  }

  public function testGetObjectName(){
      $this->assertEquals("TestClassA",$this->c->getObjectName());
  }

  public function testMethodsReturnSpecificInstance()
  {
        $items = array();
        for($i = 0; $i<10;$i++){
            $items[] = new TestClassA($i);
        }

        $this->c->addRange($items);

        $subset = $this->c->getRange(0,2);

    $this->assertInstanceOf('SpecificCollection', $subset);
  }
}
