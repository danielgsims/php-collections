<?php

use Collections\Collection;

/**
 * A collection of {{foo}} objects with a specified class or interface
 */
class FooCollection extends Collections\Collection
{
    /**
     * Instantiates the collection by specifying what type of Object will be used.
     *
     * @param string $objectName Name of the class or interface used in the Collection
     */
    public function __construct()
    {
        parent::__construct("{{foo}}");
    }

    /**
     * Fetches the item at the specified index
     *
     * @param integer $index The index of an item to fetch
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     * @return {{foo}} The item at the specified index
     */
    public function at($index)
    {
        parent::at($index);
    }

   /**
     * Finds and returns the first item in the collection that satisfies the callback.
     *
     * @param callback $condition The condition critera to test each item, requires one argument that represents the Collection item during iteration.
     * @return {{foo}} The first item that satisfied the condition or false if no object was found
     */
    public function find(callable $condition)
    {
        parent::find($condition);
    }

    /**
     * Finds and returns the last item in the collection that satisfies the callback.
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
     * @return {{foo}} The last item that matched condition or -1 if no item was found matching the condition.
     */
    public function findLast(callable $condition)
    {
        parent::findLast($condition);
    }
}
