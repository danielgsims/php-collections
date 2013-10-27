<?php
/**
 * Class Collection
 *
 * A generic list implementation in PHP
 *
 * @author danielgsims
 *
 * @todo - Callbacks can cause a lot of unforseen errors
 */

class CollectionInteratorException extends Exception{}
class CollectionInvalidArgumentException extends Exception{}
class CollectionOutOfRangeException extends Exception{}

class Collection implements IteratorAggregate{
    /**
     * The collection's encapsulated array
     * @var array
     */
    protected $items;

    /**
     * The name of the object, either class or interface, that the list works with
     * @var string
     */
    protected $objectName;

    /**
     * Constructs the items as an array
     */
    public function __construct($objectName){
      $this->items = array();

      if(!class_exists($objectName) && !interface_exists($objectName)){
        throw new CollectionInvalidArgumentException("Class or Interface name is not declared");
      }

      $this->objectName = $objectName;
    }

    /**
     * Get Iterator to satisfy IteratorAggregate interface
     * @return ArrayIterator
     */
    public function getIterator(){
       return new ArrayIterator($this->items);
   }

    /**
     * The number of items in a collection
     * @return int
     */
    public function count(){
       return count($this->items);
   }

    /**
     * Returns the index of the first item that satisfies the callback function.
     * Returns -1 if no index is found.
     *
     *
     * @param callable $callback
     * @return int
     */
    public function indexOf(callable $callback){
      try{
        $found = false;

        for($i = 0; $i < $this->count(); $i++){
          if($callback($this->items[$i])){
            $found = true;
            break;
          }
        }

        return $found ? $i : -1;
      } catch (Exception $e){
        throw new CollectionInteratorException($e->getMessage());
      }
    }

    /**
     * Empties all of the items in the array
     */
    public function clear(){
       $this->items = array();
   }


    /**
     * Finds and returns the first item in the collection that satisfies the callback.
     *
     * @param callable $callback
     * @return mixed|bool
     */
    public function find(callable $callback){
      try{
       $found = false;
       foreach($this->items as $item){
              if($callback($item)){
                 $found = $item;
                 break;
              }
       }

       return $found;
      } catch (Exception $e){
        throw new CollectionInteratorException($e->getMessage());
      }
   }

    /**
     * Returns a collection of all items that satisfy the callback function. If nothing is found, returns an empty
     * Collection
     *
     * @param callable $callback
     * @return Collection
     */
    public function findAll(callable $callback){
         try{
           $col = new Collection();
           foreach($this->items as $item){
              if($callback($item)){
                  $col->add($item);
              }
           }

           return $col;

         } catch (Exception $e){
          throw new CollectionInteratorException($e->getMessage());
         }
   }

    /**
     * Add an item to the collection
     *
     * @param mixed $item
     */
    public function add($item){
      $this->validateItem($item);
      $this->items[] = $item;
    }

    /**
     * Validates that the item is an object and matches the object name
     *
     * @param mixed $item
     * @throws CollectionInvalidArgumentException
     */
    protected function validateItem($item){
      if(!is_object($item)) throw new CollectionInvalidArgumentException("Item must be an object");

      if(!is_a($item, $this->objectName)){
        throw new CollectionInvalidArgumentException("Item is not of subtype " . $this->objectName);
      }
    }

    /**
     * Validates an array of items
     *
     * @param array $items
     */
    protected function validateItems(array $items){
      foreach($items as $item){
        $this->validateItem($item);
      }
    }

    /**
     * An array of items to add to the collection
     *
     * @param array $items
     */
    public function addRange(array $items){
      $this->validateItems($items);
      $this->items = array_merge($this->items,$items);
    }

    /**
     * Insert the item at index
     *
     * @throws InvalidArgumentException
     * @param int $index
     * @param mixed $item
     */
    public function insert($index, $item){

      $this->validateIndex($index);
      $this->validateItem($item);

      //To work with negative index, get the positive relation to 0 index
      if($index < 0)
          $index = $this->count() + $index + 1;

      $partA = array_slice($this->items,0,$index);
      $partB = array_slice($this->items, $index, count($this->items));
      $partA[] = $item;
      $this->items = array_merge($partA,$partB);
   }

    /**
     * Removes the item at the specified index
     *
     * @throws InvalidArgumentException
     * @param int $index
     */
    public function removeAt($index){
       $this->validateIndex($index);

       if($index != -1){
           $partA = array_slice($this->items, 0, $index);
           $partB = array_slice($this->items, $index + 1, count($this->items));
           $this->items = array_merge($partA,$partB);
       } else {
           array_pop($this->items);
       }
   }

    /**
     * Return the collection as an array
     *
     * Returns the array that is encapsulated by the collection.
     *
     * @return array
     */
    public function toArray(){
       return $this->items;
   }

    /**
     * @param $index
     * @throws OutOfRangeException
     * @throws InvalidArgumentException
     */
    private function validateIndex($index){
       if(!is_int($index)){
            throw new CollectionInvalidArgumentException("Index must be an integer");
       }

       if(abs($index) > $this->count()){
           throw new CollectionOutOfRangeException("Index out of bounds of collection");
       }
    }

    /**
     * Check to see if an item in the collection exists that satisfies the provided callback
     *
     * @param callback
     * @returns bool
     */
    public function exists(callable $callback){
        return (bool) $this->find($callback);
    }

    /**
     * Get a range of items in the collection
     *
     * @param int $start The starting index of the range
     * @param int $end The ending index of the range
     * @returns Collection
     */
    public function getRange($start,$end){
        if(!is_integer($start) || $start < 0){
            throw new InvalidArgumentException("Start must be an integer");
        }

        if(!is_integer($end) || $end < 0){
            throw new InvalidArgumentException("End must be an integer");
        }

        if($start >= $end){
            throw new InvalidArgumentException("End must be greater than start");
        }

        /*
         * Todo, What is the expected result in this situation. Would this be an error, or return as many as possible?
         */
        if($start >= $this->count){
            throw new InvalidArgumentException("Start must be less than the count of the items in the Collection");
        }

        $subsetItems = array_slice($this->items,$start,$end);
        $subset = new Collection();
        $subset->addRange($subsetItems);
        return $subset;

    }

    public function at($index){
      if(!is_int($index)) throw new  CollectionInvalidArgumentException("Index must be an integer");
      if($index >= $this->count()) throw new CollectionOutOfRangeException("Out of range on Collection");

      return $this->items[$index];
    }
}
