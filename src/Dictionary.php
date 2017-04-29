<?php

namespace Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Dictionary implements DictionaryInterface
{
    use TypeValidator;

    protected $storage = [];
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
     * {@inheritdoc}
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * {@inheritdoc}
     */
    public function getValueType()
    {
        return $this->valType;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return array_key_exists($key, $this->storage) ? $this->storage[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        $storage = $this->storage;
        if (array_key_exists($key, $this->storage)) {
            unset($storage[$key]);
        }

        return new static($this->keyType, $this->valType, $storage);
    }

    /**
     * {@inheritdoc}
     */
    public function valueExists($value)
    {
        return in_array($value, $this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return new static($this->keyType, $this->valType);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->storage;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function without(callable $condition)
    {
        $inverse = function ($k, $v) use ($condition) {
            return !$condition($k,$v);
        };

        return $this->filter($inverse);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value)
    {
        $storage = $this->storage;
        $storage[$key] = $value;

        return new static($this->keyType, $this->valType, $storage);
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callable)
    {
        foreach ($this->storage as $key => $value) {
            $callable($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrElse($key, $default)
    {
        return ($this->exists($key)) ? $this->get($key) : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return array_keys($this->storage);
    }

    /**
     * {@inheritdoc}
     */
    public function values()
    {
        return array_values($this->storage);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
