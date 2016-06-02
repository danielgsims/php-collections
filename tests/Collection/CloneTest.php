<?php

use Collections\Collection;

class CloneTest extends PHPUnit_Framework_TestCase
{
    public function testClone()
    {
        $t = new TestClassA(1);
        $this->c = new Collection('TestClassA');

        $this->c = $this->c->add($t);
        $c = clone $this->c;

        // Original collection entries are unmodified
        $this->assertTrue($t === $this->c->at(0));
        // Entries are equivalent
        $this->assertTrue($t == $c->at(0));
        // Cloned collection entries have new references
        $this->assertFalse($t === $c->at(0));
        // Cloned collections are equivalent
        $this->assertTrue($this->c == $c);
        // Cloned collection has new reference
        $this->assertFalse($this->c === $c);
        // Cloned collection entries are equivalent to original collection entries
        $this->assertTrue($this->c->at(0) == $c->at(0));
        // Cloned collection entries have different references from original collection entries
        $this->assertFalse($this->c->at(0) === $c->at(0));
    }
}