<?php

namespace Collections;

use Countable;
use IteratorAggregate;
use Collections\Exceptions\InvalidArgumentException;

interface CollectionInterface extends Countable, IteratorAggregate
{
    /**
     * Clones the collection by cloning each object in the underlying array
     */
    public function __clone();

    /**
     * Add an item to the collection
     *
     * @param mixed $item An item of your Collection's object type to be added
     */
    public function add($item);

    /**
     * An array of items to add to the collection
     *
     * @param array $items An array of items of your Collection's object type to be added
     */
    public function addRange(array $items);

    /**
     * Fetches the item at the specified index
     *
     * @param integer $index The index of an item to fetch
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     * @return mixed The item at the specified index
     */
    public function at($index);

    /**
     * Empties all of the items in the array
     */
    public function clear();

    /**
     * Check to see if an item in the collection exists that satisfies the provided callback
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
     * @return bool Whether an item exists that satisfied the condition
     */
    public function contains(callable $condition);

   /**
     * Finds and returns the first item in the collection that satisfies the callback.
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during iteration.
     * @return mixed|bool The first item that satisfied the condition or false if no object was found
     */
    public function find(callable $condition);

    /**
     * Returns a collection of all items that satisfy the callback function. If nothing is found, returns an empty
     * Collection
     *
     * @param callable $condition The condition criteria to test each item, requires one argument that represents the Collection item during iteration.
     * @return Collection A collection of all of the items that satisfied the condition
     */
    public function filter(callable $condition);

    /**
     * Finds the index of the first item that returns true from the callback,
     * returns -1 if no item is found
     *
     * @param callback $condition The condition criteria to test each item, requires one toargument that represents the Collection item during iteration.
     * @return integer The index of the first item satisfying the callback or -1 if no item was found
     */
    public function findIndex(callable $condition);

    /**
     * Finds and returns the last item in the collection that satisfies the callback.
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
     * @return mixed|bool The last item that matched condition or -1 if no item was found matching the condition.
     */
    public function findLast(callable $condition);

    /**
     * Finds the index of the last item that returns true from the callback,
     * returns -1 if no item is found
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
     * @return integer The index of the last item  to match that matches the condition, returns -1 if no item was found
     */
    public function findLastIndex(callable $condition);

    /**
     * Get a range of items in the collection
     *
     * @param integer $start The starting index of the range
     * @param integer $end The ending index of the range
     * @throws InvalidArgumentException
     * @return Collection A collection of items matching the range
     */
    public function slice($start, $end);

     /**
     * Insert the item at index
     *
     * @throws InvalidArgumentException
     * @param integer $index The index where to insert the item
     * @param mixed $item The item to insert
     */
    public function insert($index, $item);

    /**
     * Inset a range at the index
     *
     * @param integer $index Index where to insert the range
     * @param array items An array of items to insert
     */
    public function insertRange($index, array $items);

    /**
     * Removes the first item that satisfies the condition callback
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during iteration.
     * @return bool Whether the item was found
     */
    public function remove(callable $condition);

    /**
     * Removes all items that satisfy the condition callback
     *
     * @param callback @condition The condition criteria to test each item, requires on argument that represents the Collection item during interation.
     * @return int the number of items found
     */
    public function removeAll(callable $condition);

    /**
     * Removes the item at the specified index
     *
     * @param integer $index The index where the object should be removed
     */
    public function removeAt($index);

    /**
     * Removes the last item to satisfy the condition callback
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
     * @return bool Whether the item was removed or not
     */
    public function removeLast(callable $condition);

    /**
     * Reverses the Collection
     */
    public function reverse();

    /**
     * Sorts the collection with a usort
     * @param callable $callback
     * @return static
     */
    public function sort(callable $callback);

    /**
     * Return the collection as an array
     *
     * Returns the array that is encapsulated by the collection.
     *
     * @return array
     */
    public function toArray();

    /**
     * Return whether the given index exists
     *
     * @param integer $index The number to be validated as an index
     * @return bool
     * @throws InvalidArgumentException
     */
    public function indexExists($index);

    /**
     * Reduces a list down to a single value
     *
     * @param callable $callable
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $callable, $initial = null);

    /**
     * Whether every item in the collection passes the condition. This
     * condition is a callable that should return strictly true or false.
     *
     * @param callable $condition
     * @return bool
     */
    public function every(callable $condition);
}