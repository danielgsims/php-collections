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
     * Returns the type of the collection.
     *
     * @return string
     */
    public function getType();

    /**
     * Returns a collection with $item added.
     *
     * @param $item
     * @return CollectionInterface
     * @throws InvalidArgumentException
     */
    public function add($item);

    /**
     * Removes every item from the collection.
     *
     * @return CollectionInterface
     */
    public function clear();

    /**
     * Returns true if the collection contains any items that satisfy
     * $condition, returns false if it contains none.
     *
     * @param callable $condition
     * @return bool
     */
    public function contains(callable $condition);

    /**
     * Returns the first item in the collection that satisfies
     * $condition, returns false if no such item exists.
     *
     * @param callable $condition
     * @return mixed
     */
    public function find(callable $condition);

    /**
     * Returns the index of the first item in the collection that satisfies
     * $condition, returns -1 if no such item exists.
     *
     * @param callable $condition
     * @return int
     */
    public function findIndex(callable $condition);

    /**
     * Returns the item in the collection at $index.
     *
     * @param $index
     * @return mixed
     * @throws OutOfRangeException
     */
    public function at($index);

    /**
     * Returns true if $index is within the collection's range and returns false
     * if it is not.
     *
     * @param $index
     * @return bool
     * @throws InvalidArgumentException
     */
    public function indexExists($index);

    /**
     * Returns the number of items in the collection.
     *
     * @return int
     */
    public function count();

    /**
     * Returns a collection that only contains the items which satisfy
     * $condition.
     *
     * @param callable $condition
     * @return CollectionInterface
     */
    public function filter(callable $condition);

    /**
     * Returns the last item in the collection that satisfies $condition,
     * returns false if no such item exists.
     *
     * @param callable $condition
     * @return mixed
     */
    public function findLast(callable $condition);

    /**
     * Returns the index of the last item in the collection that satisfies
     * $condition, returns -1 if no such item exists.
     *
     * @param callable $condition
     * @return int
     */
    public function findLastIndex(callable $condition);

    /**
     * Returns an array iterator for the collection.
     *
     * @return ArrayIterator
     */
    public function getIterator();

    /**
     * Returns a collection that contains the subset of items ranging from the
     * index $start to $end.
     *
     * @param $start
     * @param $end
     * @return CollectionInterface
     * @throws InvalidArgumentException
     */
    public function slice($start, $end);

    /**
     * Inserts $item at $index.
     *
     * @param $index
     * @param $item
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function insert($index, $item);

    /**
     * Inserts the range $items at $index.
     *
     * @param $index
     * @param array $items
     * @throws OutOfRangeException
     */
    public function insertRange($index, array $items);

    /**
     * Removes all of the items that satisfy $condition.
     *
     * @param callable $condition
     * @return Collection
     */
    public function without(callable $condition);

    /**
     * Removes the item at $index.
     *
     * @param $index
     * @return CollectionInterface
     * @throws OutOfRangeException
     */
    public function removeAt($index);

    /**
     * Reverses the order of the items in the collection.
     *
     * @return CollectionInterface
     */
    public function reverse();

    /**
     * Sorts the items in the collection using the user supplied comparison
     * function $callback.
     *
     * @param callable $callback
     * @return CollectionInterface
     */
    public function sort(callable $callback);

    /**
     * Returns an array containing the items in the collection.
     *
     * @return array
     */
    public function toArray();

    /**
     * Iteratively reduces the collection to a single value using the callback
     * function $callable.
     *
     * @param callable $callable
     * @param null $initial
     * @return mixed
     */
    public function reduce(callable $callable, $initial = null);

    /**
     * Returns true if every item in the collection satisfies $condition,
     * returns false if not.
     *
     * @param callable $condition
     * @return bool
     */
    public function every(callable $condition);

    /**
     * Removes all of the items in the collection starting at index $num.
     *
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function drop($num);

    /**
     * Removes all of the items in the collectioin between index 0 and $num.
     *
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function dropRight($num);

    /**
     * Iteratively drops items in the collection that satisfy $condition until
     * an item is encountered that does not satisfy $condition.
     *
     * @param callable $condition
     * @return Collection
     */
    public function dropWhile(callable $condition);

    /**
     * Removes the first item in the collection.
     *
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function tail();

    /**
     * Removes all of the items in the collection starting at index $num.
     *
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function take($num);

    /**
     * Removes all of the items in the collection before index $num.
     *
     * @param $num
     * @return Collection
     * @throws InvalidArgumentException
     */
    public function takeRight($num);

    /**
     * Iterates through the collection until an item is encountered that does
     * not satisfy $condition, then drops all of the items starting at that
     * index.
     *
     * @param callable $condition
     * @return Collection
     */
    public function takeWhile(callable $condition);

    /**
     * Applies the callback function $callable to each item in the collection.
     *
     * @param callable $callable
     */
    public function each(callable $callable);

    /**
     * Returns a new instance of the collection with the callback function
     * $callable applied to each item.
     *
     * @param callable $callable
     * @return CollectionInterface
     */
    public function map(callable $callable);

    /**
     * Iteratively reduces the collection to a single value using the callback
     * function $callable starting at the rightmost index.
     *
     * @param callable $callable
     * @param null $initial
     * @return mixed
     */
    public function reduceRight(callable $callable, $initial = null);

    /**
     * Randomly reorders the items in the collection.
     *
     * @return CollectionInterface
     */
    public function shuffle();

    /**
     * Adds every member of $items to the collection.
     *
     * @param $items
     * @return CollectionInterface
     * @throws InvalidArgumentException
     */
    public function merge($items);

    /**
     * Get first item of the collection
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function first();

    /**
     * Get last item of the collection
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function last();
}
