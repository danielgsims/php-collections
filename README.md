phpcollection
=============

A PHP implementation of a templated list. The Collection class allows
one object type and its subtypes to be added to the collection. Many
standard PHP array functions are encapsulated in the collection.

##Requirements##

Requires PHP 5.4 or greater

## Examples ##

First, here are example classes used within the Collection examples

```php
  class Book{
    protected $title;
    protected $genre;
    protected $author;
 
    public function __construct($title, $author, $genre){
      $this->title = $title;
      $this->author = $author;
      $this->genre = $genre;
    }

    public funciton getTitle(){
      return $this->title; 
    }

    public function getAuthor(){
      return $this->author;
    }

    public function getGenre(){
      return $this->genre;
    }
  }

  class Novel extends Book{
  }

  class Novella extends Book{
  }


```
##Basic Usage##

There are various ways to add items to the collection, such as
appending to the end of the collection or inserting at a specific index

```php
use Collection\Collection;

$library = new Collection("Book");
$library->add(new Novel("1984","George Orwell","Dystopian"));

$items = array();
$items[] = new Novella("Animal Farm","Animal Farm","Satire");
$items[] = new Novel("A Brave New World","Aldous Huxley","Dystopian");
$library->addRange($items);

$library->insert(2,new Novel("I, Robot","Isaac Asimov","Science
Fiction");

```

Elements can be retrieved in various ways. The at method returns the
object at your specified index 

```php

$book = $library->at(0);

```

The collection can be fetched as an array

```php

$books = $library->toArray();

```

Items can be removed with various functions, whether removing at a
specified index or matching some callback criteria. The remove method
will remove the first item to satisfy the condition. The removeLast
method will remove the final match.

```php

$library->removeAt(2);

$library->remove(function($book){
  return $book->getGenre() == "Science Fiction";
});

$collection->removeLast(function($item){
  return $item->getGenre() == "Dystopian";
});

```

Similarly, callbacks can be used to find items or the index of items
that satisfy a conditional callback. The find method returns the first
result.

```php

$book = $library->find(function($book){
  return $book->getAuthor() == "George Orwell";
});


$book = $library->findAll(function($book){
  return $book->getGenre() ==  "Dystopian";
});

$book = $librar->findIndex(function($book){
  return $book->getTitle() = "A Brave New World";
});


```

The collection can be used in loops

```php

foreach($library as $book){
  echo $book->getTitle();
}


for($i = 0; $i<$library->count(); $i++){
  echo $library->at($i)->getAuthor();
}

```

##Inheritance##

In the examples above, we see the inheritance support for the
Collection. By designating the base class (Book), we can submit Books,
Novels and Novellas.

##Validation

Due to the lack of generics in PHP, we cannot type hint on the collection when it is used as an argument.
The simplest way for us to ensurce collection safety is to manually check the object type.

```php

class MyClass
{
   public function __construct(Collection $collection)
   {
       if ("Book" != $collection->getObjectName()) {
            throw new InvalidArgumentException("Collection must be a collection of Books");
       }
       
   }
}
```
