<?php
namespace Collections;

interface DictionaryInterface extends \IteratorAggregate, \Countable
{
    /**
     * @return string
     */
    public function getKeyType();

    /**
     * @return string
     */
    public function getValueType();

    /**
     * @param $key
     * @return bool
     */
    public function exists($key);

    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @return static
     */
    public function delete($key);

    /**
     * @param $value
     * @return bool
     */
    public function valueExists($value);

    /**
     * @return int
     */
    public function count();

    /**
     * @return static
     */
    public function clear();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param callable $condition
     * @return static
     */
    public function filter(callable $condition);

    /**
     * @param callable $condition
     * @return static
     */
    public function without(callable $condition);

    /**
     * @param $key
     * @param $value
     * @return static
     * @throws Exceptions\InvalidArgumentException
     */
    public function add($key, $value);

    /**
     * @param callable $callable
     */
    public function each(callable $callable);

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function getOrElse($key, $default);

    /**
     * @return array
     */
    public function keys();

    /**
     * @return array
     */
    public function values();

    /**
     * @param callable $callable
     * @return static
     */
    public function map(callable $callable);

    /**
     * @param $newItems
     * @return static
     */
    public function merge($newItems);
}
