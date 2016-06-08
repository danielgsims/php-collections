<?php
namespace Collections;
use ArrayIterator;
use Collections\Exceptions\InvalidArgumentException;
use Collections\Exceptions\OutOfRangeException;


/**
 * A collection of objects with a specified class or interface
 */
interface CollectionInterface extends \IteratorAggregate, \Countable
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param $item
     * @return CollectionInterface
     * @throws InvalidArgumentException
     */
    public function add($item);

    /**
     * @return CollectionInterface
     */
    public function clear();

    /**
     * @param callable $condition
     * @return bool
     */
    public function contains(callable $condition);

    /**
     * @param callable $condition
     * @return bool
     */
    public function find(callable $condition);

    /**
     * @param callable $condition
     * @return int
     */
    public function findIndex(callable $condition);

    /**
     * @param $index
     * @return mixed
     * @throws OutOfRangeException
     */
    public function at($index);

    /**
     * @param $index
     * @return bool
     * @throws InvalidArgumentException
     */
    public function indexExists($index);

    /**
     * @return int
     */
    public function count();

    /**
     * @param callable $condition
     * @return CollectionInterface
     */
    public function filter(callable $condition);

    /**
     * @param callable $condition
     * @return bool
     */
    public function findLast(callable $condition);

    /**
     * @param callable $condition
     * @return int
     */
    public function findLastIndex(callable $condition);

    /**
     * @return ArrayIterator
     */
    public function getIterator();

    /**
     * @param $start
     * @param $end
     * @return CollectionInterface
     * @throws InvalidArgumentException
     */
    public function slice($start, $end);

    /**
     * @param $index
     * @param $item
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function insert($index, $item);

    /**
     * @param $index
     * @param array $items
     * @throws OutOfRangeException
     */
    public function insertRange($index, array $items);

    /**
     * @param callable $condition
     * @return Collection
     */
    public function without(callable $condition);

    /**
     * @param $index
     * @return CollectionInterface
     * @throws OutOfRangeException
     */
    public function removeAt($index);

    /**
     * @return CollectionInterface
     */
    public function reverse();

    /**
     * @param callable $callback
     * @return CollectionInterface
     */
    public function sort(callable $callback);

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param callable $callable
     * @param null $initial
     * @return mixed
     */
    public function reduce(callable $callable, $initial = null);

    /**
     * @param callable $condition
     * @return bool
     */
    public function every(callable $condition);

    /**
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function drop($num);

    /**
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function dropRight($num);

    /**
     * @param callable $condition
     * @return Collection
     */
    public function dropWhile(callable $condition);

    /**
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function tail();

    /**
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function take($num);

    /**
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function takeRight($num);

    /**
     * @param callable $condition
     * @return Collection
     */
    public function takeWhile(callable $condition);

    /**
     * @param callable $callable
     */
    public function each(callable $callable);

    /**
     * @param callable $callable
     * @return CollectionInterface
     */
    public function map(callable $callable);

    /**
     * @param callable $callable
     * @param null $initial
     * @return mixed
     */
    public function reduceRight(callable $callable, $initial = null);

    /**
     * @return CollectionInterface
     */
    public function shuffle();

    /**
     * @param $items
     * @return CollectionInterface
     * @throws InvalidArgumentException
     */
    public function merge($items);
}