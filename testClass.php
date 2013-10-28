<?php

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
