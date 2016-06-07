<?php

namespace Collections;

use Collections\Exceptions\NullKeyException;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Dictionary implements IteratorAggregate
{
    use TypeValidator;

    protected $storage;
    protected $keyType;
    protected $valType;

    /**
     * Constructor
     *
     * @param array $storage
     */
    public function __construct($keyType, $valType, array $storage = array())
    {
        $this->storage = $storage;
        $this->keyType = $this->determineType($keyType, true);
        $this->valType = $this->determineType($valType);
    }

    public function getKeyType()
    {
        return $this->keyType;
    }

    public function getValueType()
    {
        return $this->valType;
    }

    public function exists($key)
    {
        return array_key_exists($key,$this->storage);
    }

    public function get($key)
    {
        return array_key_exists($key,$this->storage) ? $this->storage[$key] : null;
    }

    public function delete($key)
    {
        $storage = $this->storage;
        if (array_key_exists($key,$this->storage)) {
            unset($storage[$key]);
        }

        return new static($this->keyType, $this->valType, $storage);
    }

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
        return new static($this->keyType, $this->valType);
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

        return new static($this->keyType, $this->valType, $storage);
    }

    /**
     * @param $key
     * @param $value
     * @return static
     * @throws Exceptions\InvalidArgumentException
     */
    public function add($key, $value)
    {
        $this->validateItem($key, $this->keyType);
        $this->validateItem($value, $this->valType);

        $storage = $this->storage;
        $storage[$key] = $value;

        return new static($this->keyType, $this->valType, $storage);
    }

    public function each(callable $callable)
    {
        foreach ($this->storage as $key => $value) {
            $callable($key, $value);
        }
    }
}
