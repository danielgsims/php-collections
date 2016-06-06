<?php

namespace Collections;

use Collections\Exceptions\NullKeyException;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Dictionary implements ArrayAccess, Countable, IteratorAggregate
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
        return array_key_exists($offest,$this->storage);
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
        $this->validateOffset($offest);
        $this->storage[$offest] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->storage[$offset]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function keyExists($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritDoc}
     */
    public function valueExists($value)
    {
        return in_array($value, $this->storage);
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

    public function clear()
    {
        $this->storage = array();
    }

    public function toArray()
    {
        return $this->storage;
    }

    public function filter(callable $condition)
    {
        $storage = [];
        foreach ($this->storage as $key => $value) {
            if ($condition($key, $value)) {
                $storage[$key] = $value;
            }
        }

        return new Dictionary($storage);
    }

    private function validateOffset($offest)
    {
        if (empty($offest)) {
            throw new NullKeyException("A key may not be null");
        }
    }

    public function getOrElse($key, $default)
    {
        //Add type validation
        if ($this->keyExists($key)) {
            return $this[$key];
        } else {
            $this[$key] = $default;
            return $this[$key];
        }
    }

    public function keys()
    {
        foreach ($this->storage as $key => $value) {
            $newArray[] = $key;
        }

        return $newArray;
    }

    public function values()
    {
        foreach ($this->storage as $key => $value) {
            $newArray[] = $value;
        }

        return $newArray;
    }

    public function addRange(Dictionary $range)
    {
        foreach ($range as $key => $value) {
          $this->getOrElse($key, $value);
        }
    }
}
