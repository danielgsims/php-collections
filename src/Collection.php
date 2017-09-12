<?php

namespace Collections;

use Collections\Exceptions\InvalidArgumentException;
use Collections\Exceptions\OutOfRangeException;
use ArrayIterator;

/**
 * A collection of objects with a specified class or interface
 */
class Collection implements CollectionInterface
{
    use TypeValidator;

    /**
     * The collection's encapsulated array
     *
     * @var array
     */
    protected $items;

    /**
     * The name of the object, either class or interface, that the list works with
     *
     * @var string
     */
    private $type;

    /**
     * Instantiates the collection by specifying what type of Object will be used.
     *
     * @param $type
     * @param array $items
     * @throws InvalidArgumentException
     */
    public function __construct($type, array $items = [])
    {
        $type = $this->determineType($type);
        $this->type = $type;

        if ($items) {
            $this->validateItems($items, $this->type);
        }

        $this->items = $items;
    }

    protected function setItemsFromTrustedSource(array $items)
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function add($item)
    {
        $this->validateItem($item, $this->type);

        $items = $this->items;
        $items[] = $item;

        $col = new static($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return new static($this->type);
    }

    /**
     * {@inheritdoc}
     */
    public function contains(callable $condition)
    {
        return (bool) $this->find($condition);
    }

    /**
     * {@inheritdoc}
     */
    public function find(callable $condition)
    {
        $index = $this->findIndex($condition);

        return $index === -1 ? false : $this->items[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function findIndex(callable $condition)
    {
        $index = -1;

        for ($i = 0, $collectionLength = count($this->items); $i < $collectionLength; $i++) {
            if ($condition($this->at($i))) {
                $index = $i;
                break;
            }
        }

        return $index;
    }

    /**
     * {@inheritdoc}
     */
    public function at($index)
    {
        $this->validateIndex($index);

        return $this->items[$index];
    }

    /**
     * Validates a number to be used as an index
     *
     * @param integer $index The number to be validated as an index
     * @throws OutOfRangeException
     * @throws InvalidArgumentException
     */
    private function validateIndex($index)
    {
        $exists = $this->indexExists($index);

        if (!$exists) {
            throw new OutOfRangeException('Index out of bounds of collection');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function indexExists($index)
    {
        if (!is_int($index)) {
            throw new InvalidArgumentException('Index must be an integer');
        }

        if ($index < 0) {
            throw new InvalidArgumentException('Index must be a non-negative integer');
        }

        return $index < $this->count();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(callable $condition)
    {
        $items = [];

        foreach ($this->items as $item) {
            if ($condition($item)) {
                $items[] = $item;
            }
        }

        $col = new static($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function findLast(callable $condition)
    {
        $index = $this->findLastIndex($condition);

        return $index === -1 ? false : $this->items[$index];
    }

    /**
     * {@inheritdoc}
     */
    public function findLastIndex(callable $condition)
    {
        $index = -1;

        for ($i = count($this->items) - 1; $i >= 0; $i--) {
            if ($condition($this->items[$i])) {
                $index = $i;
                break;
            }
        }

        return $index;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function slice($start, $end)
    {
        if ($start < 0 || !is_int($start)) {
            throw new InvalidArgumentException('Start must be a non-negative integer');
        }

        if ($end < 0 || !is_int($end)) {
            throw new InvalidArgumentException('End must be a positive integer');
        }

        if ($start > $end) {
            throw new InvalidArgumentException('End must be greater than start');
        }

        if ($end > $this->count() + 1) {
            throw new InvalidArgumentException('End must be less than the count of the items in the Collection');
        }

        $length = $end - $start + 1;

        $subsetItems = array_slice($this->items, $start, $length);

        $col = new static($this->type);
        $col->setItemsFromTrustedSource($subsetItems);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function insert($index, $item)
    {
        $this->validateIndex($index);
        $this->validateItem($item, $this->type);

        $partA = array_slice($this->items, 0, $index);
        $partB = array_slice($this->items, $index, count($this->items));
        $partA[] = $item;

        $items = array_merge($partA, $partB);
        $col = new static ($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function insertRange($index, array $items)
    {
        $this->validateIndex($index);
        $this->validateItems($items, $this->type);

        //To work with negative index, get the positive relation to 0 index
        $index < 0 && $index = $this->count() + $index + 1;

        $partA = array_slice($this->items, 0, $index);
        $partB = array_slice($this->items, $index, count($this->items));

        $items1 = array_merge($partA, $items);
        $items1 = array_merge($items1, $partB);

        $col = new static ($this->type);
        $col->setItemsFromTrustedSource($items1);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function without(callable $condition)
    {
        $inverse = function ($item) use ($condition) {
            return !$condition($item);
        };

        return $this->filter($inverse);
    }

    /**
     * {@inheritdoc}
     */
    public function removeAt($index)
    {
        $this->validateIndex($index);
        $items = $this->items;

        $partA = array_slice($items, 0, $index);
        $partB = array_slice($items, $index + 1, count($items));
        $items = array_merge($partA, $partB);

        $col = new static ($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException
     */
    public function reverse()
    {
        $items = array_reverse($this->items);

        $col = new static ($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;

    }

    /**
     * {@inheritdoc}
     */
    public function sort(callable $callback)
    {
        $items = $this->items;

        usort($items, $callback);

        $col = new static($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function reduce(callable $callable, $initial = null)
    {
        return array_reduce($this->items, $callable, $initial);
    }

    /**
     * {@inheritdoc}
     */
    public function every(callable $condition)
    {
        $response = true;

        foreach ($this->items as $item) {
            $result = $condition($item);
            if ($result === false) {
                $response = false;
                break;
            }
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function drop($num)
    {
        return $this->slice($num, $this->count());
    }

    /**
     * {@inheritdoc}
     */
    public function dropRight($num)
    {
        return $num !== $this->count()
            ? $this->slice(0, $this->count() - $num - 1)
            : $this->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function dropWhile(callable $condition)
    {
        $count = $this->countWhileTrue($condition);

        return $count ? $this->drop($count) : $this;
    }

    /**
     * {@inheritdoc}
     */
    public function tail()
    {
        return $this->slice(1, $this->count());
    }

    /**
     * {@inheritdoc}
     */
    public function take($num)
    {
        return $this->slice(0, $num - 1);
    }

    /**
     * {@inheritdoc}
     */
    public function takeRight($num)
    {
        return $this->slice($this->count() - $num, $this->count());
    }

    /**
     * @param callable $condition
     * @return int
     */
    protected function countWhileTrue(callable $condition)
    {
        $count = 0;

        foreach ($this->items as $item) {
            if (!$condition($item)) {
                break;
            }
            $count++;
        }

        return $count;
    }

    /**
     * {@inheritdoc}
     */
    public function takeWhile(callable $condition)
    {
        $count = $this->countWhileTrue($condition);

        return $count ? $this->take($count) : $this->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function each(callable $callable)
    {
        foreach ($this->items as $item) {
            $callable($item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function map(callable $callable)
    {
        $items = [];
        $type = null;

        foreach ($this->items as $item) {
             $result = $callable($item);

            if (null === $type) {
                $type =  gettype($result);

                if ($type === 'object') {
                    $type = get_class($result);
                }
            }

            $items[] = $result;
        }

        if (null === $type) {
            $type = $this->type;
        }

        $col = new static ($type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function reduceRight(callable $callable, $initial = null)
    {
        $reverse = array_reverse($this->items);

        return array_reduce($reverse, $callable, $initial);
    }

    /**
     * {@inheritdoc}
     */
    public function shuffle()
    {
        $items = $this->items;
        shuffle($items);

        $col = new static ($this->type);
        $col->setItemsFromTrustedSource($items);

        return $col;
    }

    /**
     * {@inheritdoc}
     */
    public function merge($items)
    {
        if ($items instanceof static) {
            $items = $items->toArray();
        }

        if (!is_array($items)) {
            throw new InvalidArgumentException('Merge must be given array or Collection');
        }

        $this->validateItems($items, $this->type);
        $newItems = array_merge($this->items, $items);

        $col = new static ($this->type);
        $col->setItemsFromTrustedSource($newItems);

        return $col;
    }

    public function first()
    {
        if (empty($this->items)) {
            throw new \OutOfBoundsException('Cannot get first element of empty Collection');
        }

        return reset($this->items);
    }

    public function last()
    {
        if (empty($this->items)) {
            throw new \OutOfBoundsException('Cannot get last element of empty Collection');
        }

        return end($this->items);
    }
}
