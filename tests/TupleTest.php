<?php

class TupleTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleTuple()
    {
        $t = new Collections\Tuple(1,2,3);
        $this->assertEquals(3, $t->count());
        $this->assertEquals(1, $t[0]);
        $this->assertEquals(2, $t[1]);
        $this->assertEquals(3, $t[2]);
        $this->assertEquals(true, isset($t[2]));
        $this->assertEquals(false, isset($t[5]));
        $this->assertEquals(new \ArrayIterator(array(1,2,3)), $t->getIterator());
        $this->assertEquals(array(1,2,3), $t->toArray());
    }

    public function testImmutableOffset()
    {
        $t = new Collections\Tuple(1,2);
        $this->setExpectedException('Collections\Exceptions\ImmutableKeyException');
        $t[2] = 3;
    }

    public function testImmutableUnset()
    {
        $t = new Collections\Tuple(1,2);
        $this->setExpectedException('Collections\Exceptions\ImmutableKeyException');
        unset($t[2]);
    }

    public function testEmptyConstructor()
    {
        $this->setExpectedException('Collections\Exceptions\InvalidArgumentException');
        $t = new Collections\Tuple();
    }
}
