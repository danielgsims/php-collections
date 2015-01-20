<?php

namespace Collections;

use Collections\Exceptions\ImmutableKeyException;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Enum implements ArrayAccess, Countable, IteratorAggregate
{
    protected $storage;

    /**
     * Constructor
     *
     * @param array $storage
     */
    public function __construct(array $storage = array())
    {
        $this->storage = $storage;
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
        throw new ImmutableKeyException("You cannot add keys to an Enum after construction.");
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        throw new ImmutableKeyException("You cannot remove a key from an Enum.");
    }

    /**
     * {@inheritDoc}
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->storage);
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
    public function count()
    {
        return count($this->storage);
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

    public function valueExists($value)
    {
        return in_array($value, $this->storage);
    }
}
