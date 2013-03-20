<?php

/**
 * Class Collection
 *
 * Acts as an alternative to standard PHP arrays. The Collection class encapsulates many functions
 * that are useful in normal operations. The Collection class is especially useful when working with
 * specific types of objects. In specialized operations, this class may be extended to create a TypeSafe
 * implementation. I generally create an function in the derived call called add and use type hinting to declare
 * which type of class the collection may use. From there, use the parent addItem function.
 *
 * @author danielgsims
 */
class Collection implements IteratorAggregate{
    /**
     * The collection's encapsulated array
     * @var array
     */
    protected $items;

    /**
     *
     */
    public function __construct(){
        $this->items = array();
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
     * @param $callback
     * @return int
     */
    public function indexOf($callback){

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
     * @param $callback
     * @return mixed|bool
     */
    public function find($callback){
       $found = FALSE;
       foreach($this->items as $item){
              if($callback($item)){
                 $found = $item;
                 break;
              }
       }

       return $found;
   }

    /**
     * Returns a collection of all items that satisfy the callback function. If nothing is found, returns an empty
     * Collection
     *
     * @param function $callback
     * @return Collection
     */
    public function findAll($callback){
         $col = new Collection();
         foreach($this->items as $item){
              if($callback($item)){
                  $col->addItem($item);
              }
         }

         return $col;
   }

    /**
     * Add an item to the collection
     *
     * @param mixed $item
     */
    public function addItem($item){
       $this->items[] = $item;
    }

    /**
     * An array of items to add to the collection
     *
     * @param array $items
     */
    public function addItems($items){
       $this->items = array_merge($this->items,$items);
    }

    /**
     * Insert the item at index
     *
     * @throws OutOfRangeException
     * @throws InvalidArgumentException
     * @param int $index
     * @param mixed $item
     */
    public function insert($index, $item){

      $this->validateIndex($index);

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
     * @throws OutOfBoundsException
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
            throw new InvalidArgumentException("Index must be an integer");
       }

       if(abs($index) > $this->count()){
           throw new OutOfRangeException("Index out of bounds of collection");
       }
   }
}
