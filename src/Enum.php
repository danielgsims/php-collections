<?php namespace Collections;

use Collections\Exceptions\ImmutableKeyException;

class Enum implements \ArrayAccess, \IteratorAggregate, \Countable
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
        throw new ImmutableKeyException("You cannot add keys to an Enum after construction.");
    }

    public function offsetUnset($offset)
    {
        throw new ImmutableKeyException("You cannot remove a key from an Enum.");
    }

    public function toArray()
    {
        return $this->array;
    }

    public function keyExists($key)
    {
        return array_key_exists($key,$this->array);
    }   

    public function getIterator()
    {
        $items = $this->array;

        return new \ArrayIterator($items);
    }

    public function count()
    {
        return count($this->array);
    }

    public function valueExists($value)
    {
        return in_array($value, $this->array);
    }
}
