<?php

use Collections\Enum;

class EnumTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->colors = new Enum([
            'white' => '#FFFFFF',
            'blue' => '#0000FF',
            'black' => '#000000'
        ]);
        
        $this->array = [
            'white' => '#FFFFFF',
            'blue' => '#0000FF',
            'black' => '#000000'
            ];
    }

    public function testExpectedBehavior()
    {
        $this->assertEquals('#FFFFFF', $this->colors['white']);
    }

    public function testCount()
    {
        $this->assertEquals(3,$this->colors->count());
        $this->assertEquals(3,count($this->colors));
    }   

    public function testToArray()
    {
        $this->assertEquals($this->array, $this->colors->toArray());
    }

    public function testIterator()
    {
        $this->assertInstanceOf('ArrayIterator',$this->colors->getIterator());
    }

    public function testKeyExists()
    {
        $this->assertEquals(false,$this->colors->keyExists('pink')); 
        $this->assertEquals(true,$this->colors->keyExists('black')); 
        $this->assertEquals(true,isset($this->colors['black']));
    }

    public function testSet()
    {
        $this->setExpectedException("Collections\Exceptions\ImmutableKeyException");
        $this->colors['pink'] = "#F00FF";
    }

    public function testUnset()
    {
        $this->setExpectedException("Collections\Exceptions\ImmutableKeyException");
        unset($this->colors['black']);
    }
}
