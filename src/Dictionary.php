<?php

namespace Collections;

use Collections\Exceptions\NullKeyException;
use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Dictionary implements DictionaryInterface
{
    use TypeValidator;

    protected $storage;
    protected $keyType;
    protected $valType;

    /**
     * @param $keyType
     * @param $valType
     * @param array $storage
     * @throws Exceptions\InvalidArgumentException
     */
    public function __construct($keyType, $valType, array $storage = [])
    {
        $this->keyType = $this->determineType($keyType, true);

        $this->valType = $this->determineType($valType);

        foreach ($storage as $key => $val) {
            $this->validateItem($key, $this->keyType);
            $this->validateItem($val, $this->valType);

            $this->storage[$key] = $val;
        }
    }

    /**
     * @return string
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * @return string
     */
    public function getValueType()
    {
        return $this->valType;
    }

    /**
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return array_key_exists($key,$this->storage);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return array_key_exists($key,$this->storage) ? $this->storage[$key] : null;
    }

    /**
     * @param $key
     * @return static
     */
    public function delete($key)
    {
        $storage = $this->storage;
        if (array_key_exists($key,$this->storage)) {
            unset($storage[$key]);
        }

        return new static($this->keyType, $this->valType, $storage);
    }

    /**
     * @param $value
     * @return bool
     */
    public function valueExists($value)
    {
        return in_array($value, $this->storage);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->storage);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * @return static
     */
    public function clear()
    {
        return new static($this->keyType, $this->valType);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->storage;
    }

    /**
     * @param callable $condition
     * @return static
     */
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
     * @param callable $condition
     * @return static
     */
    public function without(callable $condition)
    {
        $inverse = function($k,$v) use ($condition) {
            return !$condition($k,$v);
        };

        return $this->filter($inverse);
    }
    /**
     * @param $key
     * @param $value
     * @return static
     * @throws Exceptions\InvalidArgumentException
     */
    public function add($key, $value)
    {
        $storage = $this->storage;
        $storage[$key] = $value;

        return new static($this->keyType, $this->valType, $storage);
    }

    /**
     * @param callable $callable
     */
    public function each(callable $callable)
    {
        foreach ($this->storage as $key => $value) {
            $callable($key, $value);
        }
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function getOrElse($key, $default)
    {
        return ($this->exists($key)) ? $this->get($key) : $default;
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->storage);
    }

    /**
     * @return array
     */
    public function values()
    {
        return array_values($this->storage);
    }

    /**
     * @param callable $callable
     * @return static
     */
    public function map(callable $callable)
    {
        $items = [];

        $keyType = null;
        $valType = null;

        foreach ($this->storage as $key => $val) {
            list($k,$v) = $callable($key, $val);

            if (!isset($keyType) && !isset($valType)) {
                $keyType = gettype($k);
                $valType = gettype($v);
            }

            $items[$k] = $v;
        }

        return new static($keyType, $valType, $items);
    }

    /**
     * @param $newItems
     * @return static
     */
    public function merge($newItems)
    {
        if ($newItems instanceof self) {
            $newItems = $newItems->toArray();
        }

        if (!is_array($newItems)) {
            throw new \InvalidArgumentException('Combine must be a Dictionary or an array');
        }

        $items = array_merge($this->storage, $newItems);

        return new static($this->keyType, $this->valType, $items);
    }
}
