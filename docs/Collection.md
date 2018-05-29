# Collection

## Methods

  ### getType

  Returns the type of the collection.

  ```php
  $col = new Collection('int', [1,2,3]);
  $type = $col->getType(); //int
  ```

  ### add

  Returns a new collection with the item appended on the end.

  ```php
  $col = new Collection('int', [1,2]);
  $longer = $col->add(3); //Collection('int', [1,2,3]);
  ```

  ### clear

  Clear the specific collection.

  ```php
  $col = new Collection('int', [1,2,3]);
  $col = $col->clear(); //Collection('int', []);
  ```

  ### contains

  Check the specific item is existed.

  ```php
  $col = new Collection('int',[1, 2]);
  $col->contains(function($item) {
      return $item === 2;
  }); //true
  ```

  ### find

  Find the specific item with the condition.

  ```php
  $col = new Collection('int', [1, 2]);
  $isEven = function ($item) {
      return $item % 2 === 0;
  };
  $col->find($isEven); //2
  ```

  ### findIndex

  Find the item index with giving index.

  ```php
  $col = new Collection('int', [1, 2]);
  $findEven = function ($item) {
      return $item % 2 == 0;
  };
  $col->findIndex($findEven); //1
  ```

  ### at

  Find the current value in specific collection index.

  ```php
  $col = new Collection('int', [1]);
  $col->at(0); //1
  ```

  ### indexExists

  Check specific collection index is existed in collection.

  ```php
  $col = new Collection('int', [1]);
  $col->indexExists(0); //true
  $col->indexExists(1); //false
  ```

  ### count

  Get the collection count.

  ```php
  $col = new Collection('int', [1,2,3]);
  $count = $col->count(); //3
  ```

  ### filter

  Filter the collection with customized callback to get the collection result.

  ```php
  $d = (new Dictionary('string', 'int'))->add('a', 1)->add('b', 2);
  $subset = $d->filter(function($k,$v) {
      return $v % 2 == 0;
  });
  $subset->get('b'); //2
  $subset->exists('a'); //false
  $subset->exists('b'); //true
  $subset->exists('c'); //false
  ```

  ### findLast

  Find the last value in the collection result after doing the customized callback.

  ```php
  $col = new Collection('int');
  $col = $col->add(2);
  $col = $col->add(4);
  $col = $col->add(6);
  $item = $col->findLast(function ($item) {
      return $item % 2 == 0;
  });
  $item; //6
  ```

  ### findLastIndex

  Find the last index in the collection result after doing the customized callback.

  ```php
  $col = new Collection('int',[1,2,3]);
  $index = $col->findLastIndex(function($x) {
      return $x === 4;
  }); // -1
  ```

  ### getIterator

  Get iterator in specific collection.

  ```php
  $col = new Collection('int', [1,2]);
  $iterator = $col->getIterator();
  $class = get_class($iterator); //ArrayIterator
  ```

  ### slice

  Slice the specific collection.

  ```php
  $items = range(0, 9);
  $col = new Collection('int', $items);
  $subset = $col->slice(2, 4);
  $subset->count(); //3
  $subset->at(0); //$items[2]
  $subset->at(1); //$items[3]
  $subset->at(2); //$items[4]
  ```

  ### insert

  Insert specific value and index to the collection.

  ```php
  $col = new Collection('int');
  $col = $col->add(1);
  $col = $col->add(2);
  $result = $col->insert(1, 3);

  $result->at(1); //3
  ```

  ### insertRange

  Insert the values in indexes of range to the collection.

  ```php
  $col = new Collection('int');
  $col = $col->add(1);
  $col = $col->add(2);
  $items = array();
  $items[] = 3;
  $items[] = 4;

  $result = $col->insertRange(1, $items); //Collection('int', [1,3,4,2])
  ```

  ### without

  Get the collection result without the specifc values after doing cusomized callback.

  ```php
  $col = new Collection('int',[1,2,3,4,5]);
  $odds = $col->without(function($item) {
      return $item % 2 == 0;
  }); //Collection('int',[1,3,5]);
  ```

  ### removeAt

  Remove the collection index in specific collection.

  ```php
  $items = array();
  $items[] = 3;
  $items[] = 2;
  $items[] = 1;

  $col = new Collection('int');
  $col = $col->merge($items);

  $col->count(); //3
  $col = $col->removeAt(1);

  $col->count(); //2
  $col->at(1); //1
  ```

  ### reverse

  Reverse the collection sorting.

  ```php
  $col = new Collection('int', [1,2,3]);
  $col = $col->reverse(); //Collection('int', [3,2,1]);
  ```

  ### sort

  Sort the collection and return the new sorted collection.

  ```php
  $col = new Collection('int', [3,1,4,2]);
  $comparator = function ($a, $b) {
      if ($a == $b) {
          return 0;
      }

      return ($a < $b) ? -1 : 1;
  };
  $sorted = $col->sort($comparator);

  $sorted->at(0); //1
  $sorted->at(1); //2
  $sorted->at(2); //3
  $sorted->at(3); //4

  //collection is unchanged
  $col->toArray()); //[3,1,4,2]
  ```

  ### toArray

  Get the Array of collection.

  ```php
  $col = new Collection('int', [3,1,4,2]);
  $col->toArray(); //[3,1,4,2]
  ```

  ### reduce

  Reduce the collection value with customized callback.

  ```php
  $t = 1;
  $t2 = 2;
  $t3 = 3;

  $col = new Collection('int');
  $col = $col->add($t);
  $col = $col->add($t2);
  $col = $col->add($t3);

  $result = $col->reduce(function ($total, $item) {
      return $total + $item;
  }); //6
  ```

  ### every

  Check the values whether it's matched with customized callback in collection.

  ```php
  $t = 2;
  $t2 = 4;
  $t3 = 6;

  $col = new Collection('int');
  $col = $col->add($t);
  $col = $col->add($t2);
  $col = $col->add($t3);

  $result = $col->every(function ($item) {
      return $item % 2 == 0;
  }); //true
  ```

  ### drop

  Drop the specific value in collection.

  ```php
  $items = [2,4,6];
  $col = new Collection('int', $items);
  $col = $col->drop(1);
  $col->count()); //2
  $col->at(0)); //$items[1]
  $col->at(1)); //$items[2]
  ```

  ### dropRight

  Drop the value with one right index in collection.

  ```php
  $items = [2,4,6];
  $col = new Collection('int', $items);
  $col = $col->dropRight(1);
  $col->count(); //2
  $col->at(0); //$items[0]
  $col->at(1); //$items[1]
  ```

  ### dropWhile

  Drop the values while customized callback condition is not matched in collection.

  ```php
  $t = 2;
  $t2 = 4;
  $t3 = 6;
  $t4 = 7;
  $t5 = 8;

  $col = new Collection('int');
  $col = $col->add($t);
  $col = $col->add($t2);
  $col = $col->add($t3);
  $col = $col->add($t4);
  $col = $col->add($t5);

  $col1 = $col->dropWhile(function ($item) {
      return $item % 2 == 0;
  });

  $col1->count(); //2
  $col1->at(0); //$t4
  $col1->at(1); //$t5
  ```

  ### tail

  Remove the first value of index in new collection.
  And it cannot affect the original collection.

  ```php
  $col = new Collection('int', [1,2,3]);
  $tail = $col->tail();
  $tail->count(); //2

  //col shouldn't be changed and should have 3 items
  $col->count(); //3

  //check that tail has two and three
  $tail->at(0); //2
  $tail->at(1); //3
  ```

  ### take

  Take the specific value of indexes and assign the new collection result.

  ```php
  $col = new Collection('int', [2,4,6]);
  $result = $col->take(1);

  $result->count(); //1
  $result->at(0)); //2
  ```

  ### takeRight

  Take the number of indexes from right index to left index in collection.
  And assign the new collection result.

  ```php  
  $t = 2;
  $t2 = 4;
  $t3 = 6;

  $col = new Collection('int');
  $col = $col->add($t);
  $col = $col->add($t2);
  $col = $col->add($t3);

  $c1 = $col->takeRight(1);
  $c2 = $col->takeRight(2);
  $c3 = $col->takeRight(3);
  $c1->count(); //1
  $c2->count(); //2
  $c3->count(); //3
  ```

  ### takeWhile

  Take the number of indexes from the collection until customized callback condition is not matched in collection and it will be stopped.

  ```php
  $t = 2;
  $t2 = 4;
  $t3 = 7;
  $t4 = 9;

  $col = new Collection('int');

  $col = $col->add($t);
  $col = $col->add($t2);
  $col = $col->add($t3);
  $col = $col->add($t4);

  $c1 = $col->takeWhile(function ($item) {
      return $item % 2 == 0;
  });

  $c1 = $col->takeWhile(function ($item) {
      return $item == 2;
  });

  $c1->count(); //1
  $c1->at(0); //$t
  ```

  ### each

  Let the values in collection be added to the array one by one.

  ```php
  $col = (new Collection('int'))->add(1)->add(2)->add(3)->add(4);
  $results = [];

  $c->each(function($a) use (&$results) { $results[] = $a; });

  $results; //[1,2,3,4]
  ```

  ### map

  Let the values in collection be map the customized callback and assign result array.

  ```php
  $col = (new Collection('int'))->add(1)->add(2)->add(3)->add(4);
  $result = $col->map(function ($a) { return $a * 3; }); // (new Collection('int'))->add(3)->add(6)->add(9)->add(12);
  ```

  ### reduceRight

  Let the collection do customized callback from right to left then return the result value.

  ```php
  $col = new Collection('int');
  $col = $col->add(1);
  $col = $col->add(3);
  $col = $col->add(10);
  $col = $col->add(4);

  $c1 = $col->reduceRight(function ($carry, $inc) { return $carry + $inc; }); //18
  ```

  ### shuffle

  Make the collection sorting random sorting.

  ```php
  $col = new Collection('int');
  $col = $col->add(1);
  $col = $col->add(2);
  $col = $col->add(3);
  $col = $col->add(4);
  $col = $col->add(5);
  $col = $col->add(6);
  $col = $col->add(7);
  $col = $col->add(8);
  $col = $col->add(9);
  $col = $col->add(10);

  $shuffled = $col->shuffle(); //The $shuffled collection contains the 1 to 10 values.
  ```

  ### merge

  Merge the two collections.

  ```php
  $col = new Collection('int');
  $col = $col->add(1);
  $col = $col->add(2);

  $c1 = new Collection('int');
  $c1 = $c1->add(3);
  $c1 = $c1->add(4);

  $result = $c->merge($c1); // (new Collection('int'))->add(1)->add(2)->add(3)->add(4)
  ```

  ### first

  Get the first value in collection.

  ```php
  $col = new Collection('int', [1,2,3]);
  $first = $col->first(); //1
  ```

  ### last

  Get the last value in collection.

  ```php
  $col = new Collection('int', [1,2,3]);
  $last = $col->last(); //3
  ```

  ### headAndTail

  Get the first head value and the tailed collection that's without head value in collection.

  ```php
  $col = new Collection('int', [1,2,3]);
  list($h,$t) = $col->headAndTail();
  $h; //1
  $t; //new Collection('int', [2,3])
  $t->toArray(); //[2,3]
  ```

  ### hat

  see headAndTail
