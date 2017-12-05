<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;
use Collections\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MergeTest extends TestCase
{
    public function test_can_merge_dict()
    {
        $l = (new Dictionary('string','int'))->add('a',1);
        $r = (new Dictionary('string','int'))->add('b',2);

        $m = $l->merge($r);

        $this->assertEquals(2, $m->count());
        $this->assertEquals(1, $m->get('a'));
        $this->assertEquals(2, $m->get('b'));
    }

    public function test_can_merge_array()
    {
        $l = (new Dictionary('string','int'))->add('a',1);
        $r = [ "b" => 2 ];

        $m = $l->merge($r);

        $this->assertEquals(2, $m->count());
        $this->assertEquals(1, $m->get('a'));
        $this->assertEquals(2, $m->get('b'));
    }

    public function test_new_keys_overwrite_old_ones()
    {
        $l = (new dictionary('string','int'))->add('a',1);
        $r = (new dictionary('string','int'))->add('a',2);

        $m = $l->merge($r);

        $this->assertEquals(1, $m->count());
        $this->assertEquals(2, $m->get('a'));
    }

    public function test_merge_of_bad_types_fails()
    {
        $this->expectException(InvalidArgumentException::class);
        $l = (new Dictionary('string','int'))->add('a',1);
        $r = (new Dictionary('string','string'))->add('b','2');

        $m = $l->merge($r);
    }

    public function test_merge_of_non_array()
    {
        $this->expectException(\InvalidArgumentException::class);
        $d = (new Dictionary('string', 'int'))->add('a',1);

        $result = $d->merge(3);
    }
}
