<?php

interface TestClassAInterface
{
    public function getValue();
    public function setValue($v);
}
class TestClassA implements TestClassAInterface{
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

class Invoker
{
    public function __invoke()
    {}
}


