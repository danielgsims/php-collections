<?php namespace Collection;

class Tuple implements Countable, IteratorAggregate
{
    private $array;

    public function __construct()
    {
        $args = func_get_args();
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
}
