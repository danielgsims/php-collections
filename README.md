phpcollection
=============

A PHP implementation of a templated list. The Collection class allows
one object type and its subtypes to be added to the collection. Many
standard PHP array functions are encapsulated in the collection.

Requires PHP 5.4 or greater

*Basic Usage*

There are various ways to add items to the collection, such as
appending to the end of the collection or inserting at a specific index

```php

$collection = new Collection("Foo");
$collection->add(new Foo);

$items = array();
$items[] = new Foo;
$items[] = new Foo;
$collection->addRange(new Foo);

$collection->insert(2,new Foo);

```

Elements can be retrieved in various ways. The at method returns the
object at your specified index 

```php

$myFoo = $collection->at(0);

```

The collection can be fetched as an array

```php

$array = $collection->toArray();

```

Items can be removed with various functions, whether removing at a
specified index or matching some callback criteria.

```php

$collection->removeAt(2);

$collection->remove(function($item){
  return $item->getValue() == 2;
});

$collection->removeLast(function($item){
  return $item->getValue() == 2;
});

```

Similarly, callbacks can be used to find items or the index of items
that satisfy a conditional callback

```php

$target = $collection->find(function($person){
  return $person->name == "John";
});


$target = $collection->findAll(function($person){
  return $person->age > "21";
});

$target = $collection->findIndex(function($person){
  return $person->job = "Developer";
});


```

The collection can be used in loops

```php

foreach($collection as $c){
  $c->doSomething();
}


for($i = 0; $i<$collection->count(); $i++){
  $collection->at($i)->doSomething();
}

```
