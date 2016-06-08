<?php

namespace Collections;

use Countable;
use IteratorAggregate;
use Collections\Exceptions\InvalidArgumentException;

interface CollectionInterface extends Countable, IteratorAggregate
{

}