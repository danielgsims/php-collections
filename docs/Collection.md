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

  ```php
  $col = new Collection('int', [1,2,3]);
  $col = $col->clear(); //Collection('int', []);
  ```

  ### contains

  ```php

  ```

  ### find

  ```php

  ```

  ### findIndex

  ```php

  ```

  ### at

  ```php

  ```

  ### indexExists

  ```php

  ```

  ### count

  ```php
  $col = new Collection('int', [1,2,3]);
  $count = $col->count(); //3
  ```

  ### filter

  ```php

  ```

  ### findLast

  ```php

  ```

  ### findLastIndex

  ```php

  ```

  ### getIterator

  ```php

  ```

  ### slice

  ```php

  ```

  ### insert

  ```php

  ```

  ### insertRange

  ```php

  ```

  ### without

  ```php

  ```

  ### removeAt

  ```php

  ```

  ### reverse

  ```php
  $col = new Collection('int', [1,2,3]);
  $col = $col->reverse(); //Collection('int', [3,2,1]);
  ```

  ### sort

  ```php

  ```

  ### toArray

  ```php

  ```

  ### reduce

  ```php

  ```

  ### every

  ```php

  ```

  ### drop

  ```php

  ```

  ### dropRight

  ```php

  ```

  ### dropWhile

  ```php

  ```

  ### tail

  ```php

  ```

  ### take

  ```php

  ```

  ### takeRight

  ```php

  ```

  ### takeWhile

  ```php

  ```

  ### each

  ```php

  ```

  ### map

  ```php

  ```

  ### reduceRight

  ```php

  ```

  ### shuffle

  ```php

  ```

  ### merge

  ```php

  ```

  ### first

  ```php
  $col = new Collection('int', [1,2,3]);
  $first = $col->first(); //1
  ```

  ### last

  ```php
  $col = new Collection('int', [1,2,3]);
  $last = $col->last(); //3
  ```

  ### headAndTail

  ```php

  ```

  ### hat

  see headAndTail
