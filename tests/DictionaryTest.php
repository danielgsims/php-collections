<?php

use Collections\Dictionary;

class DictionaryTest extends PHPUnit_Framework_TestCase
{
    public function testIndexedConstruct()
    {
        $fruits = new Dictionary([
            "apple",
            "banana"    
        ]);

        $this->assertEquals("apple",$fruits[0]);
        $this->assertEquals("banana",$fruits[1]);
    }

    public function testAssociativeConstruct()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "OH" => "Ohio"
        ]);

        $this->assertEquals("Michigan",$states["MI"]);
        $this->assertEquals("Ohio",$states["OH"]);
    }

    public function testInsert()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "OH" => "Ohio"
        ]);

        $states["WI"] = "Wisconsin";

        $this->assertEquals("Wisconsin", $states["WI"]);
    }

    public function testBadOffset()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "OH" => "Ohio"
        ]);

        $this->assertEquals(null, $states["WI"]);
    }

    public function testOffsetExists()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "OH" => "Ohio"
        ]);

        $this->assertEquals(true,isset($states["MI"]));
        $this->assertEquals(false,isset($states["WI"]));
        $this->assertEquals(true,$states->keyExists("MI"));
        $this->assertEquals(false,$states->keyExists("WI"));

    }

    public function testValueExists()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "OH" => "Ohio"
        ]);

        $this->assertEquals(true,$states->valueExists("Michigan"));
        $this->assertEquals(false,$states->valueExists("Wisconson"));
    }

    public function testToArray()
    {
        $statesArray = [
            "MI" => "Michigan",
            "OH" => "Ohio"
        ];

        $states = new Dictionary($statesArray);
        $this->assertEquals($statesArray,$states->toArray()); 

        $numbers = [1,2,3];
        $nums = new Dictionary($numbers);
        $this->assertEquals($numbers,$nums->toArray());
    }

    public function testUnset()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "OH" => "Ohio"
        ]);

        unset($states["OH"]);
        $this->assertEquals(false,isset($states["OH"]));
    }

    public function testClear()
    {
        $d = new Dictionary([1]);
        $d->clear();
        $this->assertEquals([],$d->toArray());
    }

    public function testCount()
    {
        $d = new Dictionary([1]);
        $this->assertEquals(1,count($d));
        $d[2] = 2;

        $this->assertEquals(2,count($d));
        $this->assertEquals(2,$d->count());
    }

    public function testIncorrectOffset()
    {
        $d = new Dictionary;
        $this->setExpectedException("Collections\Exceptions\NullKeyException");
        $d[] = "thing";
    }

    public function testFindAll()
    {
        $states = new Dictionary([
            "MI" => "Michigan",
            "MO" => "Missouri",
            "MS" => "Mississippi",
            "OH" => "Ohio"
        ]);

        $mstates = $states->findAll(function($key, $value){
            return $value[0] === "M";
        });
        
        $expected = ["MI" => "Michigan", "MO" => "Missouri", "MS" => "Mississippi"];
        $this->assertEquals($expected, $mstates->toArray());
    }

}
