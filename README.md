phpcollections
=============

This library contains two collection classes: an array list, and a dictionary.
Both of these classes are immutable. If you add or remove items from these collections,
you will receive a new instance with the changes applied. 

##Requirements##

Requires PHP 5.4 or greater, dev reqiures PHP 5.5 or greater.

Collection
=============

A PHP implementation of an array list. This type of this class is specified
at construction. The class will perform runtime type checks to validate the
appropriate values are being added. Many of the standard PHP array 
functionality is encapsulated in this class.

The following types are supported

  * int or integer
  * bool or boolean
  * float or double
  * array
  * object
  * callable
  * A class name, abstract class name or interface

The collection will check inheritance, so if you require a base class, 
derived classes can be added safely.

Dictionary
============
The dictionary works like an immutable associative array where you map keys to values.
This implementation supports runtime type safety checks. Review the Collection
section for supported types. 
