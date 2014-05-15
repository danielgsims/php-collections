<?php namespace Collections;

use Collections\Exceptions\NullKeyException;

class Dictionary implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $array;

    public function __construct(array $array = array())
    {
        $this->array = $array;
    }

    public function offsetExists($offest)
    {
        return array_key_exists($offest,$this->array);
    }

    public function offsetGet($offest)
    {
        return $this->offsetExists($offest) ? $this->array[$offest] : null; 
    }

    public function offsetSet($offest, $value)
    {
        $this->validateOffset($offest);
        $this->array[$offest] = $value;
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->array[$offset]);
        }        
    }

    private function validateOffset($offest)
    {
        if (empty($offest)) {
            throw new NullKeyException("A key may not be null");
        }
    }

    public function clear()
    {
        $this->array = array();
    }

    public function toArray()
    {
        return $this->array;
    }

    public function keyExists($key)
    {
        return $this->offsetExists($key);
    }   

    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }

    public function count()
    {
        return count($this->array);
    }
}
