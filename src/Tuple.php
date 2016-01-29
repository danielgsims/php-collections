<?php

namespace Collections;

use Collections\Exceptions\ImmutableKeyException;
use Collections\Exceptions\InvalidArgumentException;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Tuple implements ArrayAccess, Countable, IteratorAggregate
{
    protected $storage;

    /**
     * Constructor
     *
     * Parses function arguments
     */
    public function __construct()
    {
        $args = func_get_args();
        if (empty($args)) {
            throw new InvalidArgumentException("Tuple constructor may not be empty");
        }
        $this->storage = $args;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offest)
    {
        return array_key_exists($offest, $this->storage);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offest)
    {
        return $this->offsetExists($offest) ? $this->storage[$offest] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offest, $value)
    {
        throw new ImmutableKeyException('A tuple is immutable');
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        throw new ImmutableKeyException('A tuple is immutable');
    }

    /**
     * Return internal storage array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->storage;
    }
}
