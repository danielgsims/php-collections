<?php

use Collections\Collection;

/**
 * A collection of TestClassA objects with a specified class or interface
 */
class SpecificCollection extends Collections\Collection
{
    /**
     * Instantiates the collection by specifying what type of Object will be used.
     *
     * @param string $objectName Name of the class or interface used in the Collection
     */
    public function __construct($objectName = "TestClassA")
    {
        parent::__construct($objectName);
    }

    /**
     * Fetches the item at the specified index
     *
     * @param integer $index The index of an item to fetch
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     * @return TestClassA The item at the specified index
     */
    public function at($index)
    {
        return parent::at($index);
    }

   /**
     * Finds and returns the first item in the collection that satisfies the callback.
     *
     * @param callback $condition The condition critera to test each item, requires one argument that represents the Collection item during iteration.
     * @return TestClassA The first item that satisfied the condition or false if no object was found
     */
    public function find(callable $condition)
    {
        return parent::find($condition);
    }

    /**
     * Finds and returns the last item in the collection that satisfies the callback.
     *
     * @param callback $condition The condition criteria to test each item, requires one argument that represents the Collection item during an iteration.
     * @return TestClassA The last item that matched condition or -1 if no item was found matching the condition.
     */
    public function findLast(callable $condition)
    {
        return parent::findLast($condition);
    }

    /**
     * Returns a collection of all items that satisfy the callback function. If nothing is found, returns an empty
     * Collection
     *
     * @param calback $condition The condition critera to test each item, requires one argument that represents the Collection item during iteration.
     * @return SpecificCollection A collection of all of the items that satisfied the condition
     */
    public function findAll(callable $condition)
    {
        return parent::findAll($condition);
    }

    /**
     * Get a range of items in the collection
     *
     * @param integer $start The starting index of the range
     * @param integer $end The ending index of the range
     * @return SpecificCollection A collection of items matching the range
     */
    public function getRange($start, $end)
    {
        return parent::getRange($start,$end);
    }
}
