<?php
namespace Collections;

interface DictionaryInterface extends \IteratorAggregate, \Countable
{
    /**
     * Returns the type of the dictionary's keys.
     *
     * @return string
     */
    public function getKeyType();

    /**
     * Returns the type of the dictionary's values.
     *
     * @return string
     */
    public function getValueType();

    /**
     * Returns true if $key is in the dictionary, returns false if it is not.
     *
     * @param $key
     * @return bool
     */
    public function exists($key);

    /**
     * Returns the value associated with $key.
     *
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * Removes the key-value pair represented by $key from the dictionary.
     *
     * @param $key
     * @return static
     */
    public function delete($key);

    /**
     * Returns true if $value is in the dictionary, returns false if not.
     *
     * @param $value
     * @return bool
     */
    public function valueExists($value);

    /**
     * Returns the number of key-value pairs in the dictionary.
     *
     * @return int
     */
    public function count();

    /**
     * Removes every key-value pair from the dictionary.
     *
     * @return static
     */
    public function clear();

    /**
     * Returns the key-value pairs in the dictionary as an associative array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Returns a dictionary that only contains the key-value pairs which satisfy
     * $condition.
     *
     * @param callable $condition
     * @return static
     */
    public function filter(callable $condition);

    /**
     * Removes all key-value pairs from the Dictionary that do not satisfy
     * $condition.
     *
     * @param callable $condition
     * @return static
     */
    public function without(callable $condition);

    /**
     * Adds the key-value pair containing $key and $value to the dictionary.
     *
     * @param $key
     * @param $value
     * @return static
     * @throws Exceptions\InvalidArgumentException
     */
    public function add($key, $value);

    /**
     * Applies the callback function $callable to each key-value pair in the
     * dictionary.
     *
     * @param callable $callable
     */
    public function each(callable $callable);

    /**
     * Returns the value associated with $key in the dictionary, returns
     * $default if it does not.
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    public function getOrElse($key, $default);

    /**
     * Returns an array of all keys in the dictionary.
     *
     * @return array
     */
    public function keys();

    /**
     * Returns an array of all values in the dictionary.
     *
     * @return array
     */
    public function values();

    /**
     * Returns a new dictionary with the callback function $callable applied to
     * every key-value pair in the dictionary.
     *
     * @param callable $callable
     * @return static
     */
    public function map(callable $callable);

    /**
     * Adds every key-value pair in $newItems to the dictionary.
     *
     * @param $newItems
     * @return static
     */
    public function merge($newItems);
}
