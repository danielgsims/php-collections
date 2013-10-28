<?php
/**
 * Class Collection
 *
 * A generic list implementation in PHP
 *
 * @author danielgsims
 */

class CollectionIteratorException extends Exception{}
class CollectionInvalidArgumentException extends Exception{}
class CollectionOutOfRangeException extends Exception{}

class Collection implements IteratorAggregate, Countable{
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
     *
     * @param string $objectName Name of the object used in the Collection
     */
    public function __construct($objectName){
      $this->items = array();

      if(!class_exists($objectName) && !interface_exists($objectName)){
        throw new CollectionInvalidArgumentException("Class or Interface name is not declared");
      }

      $this->objectName = $objectName;
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
     * An array of items to add to the collection
     *
     * @param array $items
     */
    public function addRange(array $items){
      $this->validateItems($items);
      $this->items = array_merge($this->items,$items);
    }

    /**
     * Fetches the item at the specified index
     *
     * @param int $index The index to fetch
     * @throws CollectionInvalidArgumentException
     * @throws CollectionOutOfRangeException
     */
    public function at($index){
      if(!is_int($index)) throw new  CollectionInvalidArgumentException("Index must be an integer");
      if($index >= $this->count()) throw new CollectionOutOfRangeException("Out of range on Collection");

      return $this->items[$index];
    }

    /**
     * Empties all of the items in the array
     */
    public function clear(){
       $this->items = array();
    }

    /**
     * Determines whether the item is in the Collection
     *
     * @param mixed $needle The item to search for in the collection
     *
     */
    public function contains($needle){
      $this->validateItem($needle);
      return in_array($needle, $this->items);
    }

    /**
     * The number of items in a collection
     * @return int
     */
    public function count(){
       return count($this->items);
   }

    /**
     * Check to see if an item in the collection exists that satisfies the provided callback
     *
     * @param callback $condition The condition criteria to test each item
     * @returns bool
     */
    public function exists(callable $condition){
        return (bool) $this->find($condition);
    }

   /**
     * Finds and returns the first item in the collection that satisfies the callback.
     *
     * @param callable $condition
     * @return mixed|bool
     */
    public function find(callable $condition){
      $index = $this->findIndex($condition);
      return $index == -1 ? false : $this->items[$index];
    }

    /**
     * Returns a collection of all items that satisfy the callback function. If nothing is found, returns an empty
     * Collection
     *
     * @param callable $condition
     * @return Collection
     */
    public function findAll(callable $condition){
         try{
           $col = new Collection($this->objectName);
           foreach($this->items as $item){
              if($condition($item)){
                  $col->add($item);
              }
           }

           return $col;

         } catch (Exception $e){
          throw new CollectionIteratorException($e->getMessage());
         }
   }



    /**
     * Finds the index of the first item that returns true from the callback,
     * returns -1 if no item is found
     *
     * @param callable $condition The callback function to test whether the item matches a condition
     */
    public function findIndex(callable $condition){
      try{
        $index = -1;

        for($i = 0; $i< count($this->items); $i++){
          if($condition($this->items[$i])){
            $index = $i;
            break;
          }
        }

        return $index;

      } catch (Exception $e){
        throw new CollectionIteratorException($e->getMessage());
      }
    }

    /**
     * Finds and returns the last item in the collection that satisfies the callback.
     *
     * @param callable $condition
     * @return mixed|bool
     */
    public function findLast(callable $condition){
      $index = $this->findLastIndex($condition);
      return $index == -1 ? false : $this->items[$index];
    }

    /**
     * Finds the index of the last item that returns true from the callback,
     * returns -1 if no item is found
     *
     * @param callable $condition The callback function to test whether the item matches a condition
     */
    public function findLastIndex(callable $condition){
      try{
        $index = -1;

        for($i = count($this->items) - 1; $i>= 0; $i--){
          if($condition($this->items[$i])){
            $index = $i;
            break;
          }
        }

        return $i;

      } catch (Exception $e){
        throw new CollectionIteratorException($e->getMessage());
      }
    }

    /**
     * Get Iterator to satisfy IteratorAggregate interface
     * @return ArrayIterator
     */
    public function getIterator(){
       return new ArrayIterator($this->items);
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
            throw new CollectionInvalidArgumentException("Start must be a non-negative integer");
        }

        if(!is_integer($end) || $end < 1){
            throw new CollectionInvalidArgumentException("End must be a positive integer");
        }

        if($start >= $end){
            throw new CollectionInvalidArgumentException("End must be greater than start");
        }

        if($start >= $this->count()){
            throw new CollectionInvalidArgumentException("Start must be less than the count of the items in the Collection");
        }

        if($end >= $this->count()){
            throw new CollectionInvalidArgumentException("End must be less than the count of the items in the Collection");
        }


        $subsetItems = array_slice($this->items,$start,$end - 1);
        $subset = new Collection($this->objectName);
        $subset->addRange($subsetItems);
        return $subset;

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

      $partA = array_slice($this->items,0,$index);
      $partB = array_slice($this->items, $index, count($this->items));
      $partA[] = $item;
      $this->items = array_merge($partA,$partB);
   }

    /**
     * Inset a range at the index
     * @param int $index
     * @param array items
     */
    public function insertRange($index,array $items){
      $this->validateIndex($index);
      $this->validateItems($items);

      //To work with negative index, get the positive relation to 0 index
      if($index < 0)
          $index = $this->count() + $index + 1;

      $partA = array_slice($this->items,0,$index);
      $partB = array_slice($this->items, $index, count($this->items));
      $this->items = array_merge($partA,$items);
      $this->items = array_merge($this->items,$partB);
    }

    /**
     * Removes the first item that satisfies the condition callback
     *
     * @param callable $condition
     * @returns bool Whether the item was found
     */
    public function remove(callable $condition){
      $index = $this->findIndex($condition);
      if($index == -1){
        return false;
      } else {
        $this->removeAt($index);
        return true;
      }
    }

    /**
     * Removes the item at the specified index
     *
     * @param int $index
     */
    public function removeAt($index){
       $this->validateIndex($index);

       $partA = array_slice($this->items, 0, $index);
       $partB = array_slice($this->items, $index + 1, count($this->items));
       $this->items = array_merge($partA,$partB);
       return true;
    }

    /**
     * Removes the last item to satisfy the condition callback
     *
     * @param callable $condition Callable that has some search criteria
     * @returns bool Whether the item was removed or not
     */
    public function removeLast(callable $condition){
      $index = $this->findLastIndex($condition);

      if($index == -1){
        return false;
      } else {
        $this->removeAt($index);
        return true;
      }
    }

    /**
     * Reverses the Collection
     */
    public function reverse(){
      $this->items = array_reverse($this->items);
    }

    /**
     * Sorts the collection with a usort
     */
     public function sort(callable $callback){
       return usort($this->items,$callback);
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

       if($index > $this->count()){
           throw new CollectionOutOfRangeException("Index out of bounds of collection");
       }

       if($index < 0){
        throw new CollectionOutOfRangeException("Index cannot be negative");
       }
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
}
