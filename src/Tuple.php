<?php namespace Collections;

use Collections\Exceptions\ImmutableKeyException;
use Collections\Exceptions\InvalidArgumentException;

class Tuple implements \Countable, \IteratorAggregate, \ArrayAccess
{
    private $array;

    public function __construct()
    {
        $args = func_get_args();
        if(empty($args)){
            throw new InvalidArgumentException("Tuple constructor may not be empty");
        }
        $this->array = $args;
    }

    public function count()
    {
        return count($this->array);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->array);
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
        throw new ImmutableKeyException("A tuple is immutable");
    }

    public function offsetUnset($offset)
    {
        throw new ImmutableKeyException("A tuple is immutable");
    }

    public function toArray()
    {
        return $this->array;
    }
}
