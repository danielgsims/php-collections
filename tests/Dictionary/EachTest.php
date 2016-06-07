<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;

class EachTest extends \PHPUnit_Framework_TestCase
{
    public function test_fn_applied_to_every_item()
    {
        $d = (new Dictionary('string', 'int'))
                ->add('a',1)
                ->add('b',2);

        $results = [];

        $d->each(function($k, $v) use (&$results) {
            $results[$k] = $v;
        });

        $this->assertEquals([ "a" => 1, "b" => 2], $results);
    }

    public function test_for_each_works_too()
    {
        $d = (new Dictionary('string', 'int'))
            ->add('a',1)
            ->add('b',2);

        $results = [];

        foreach ($d as $k => $v) {
            $results[$k] = $v;
        }

        $this->assertEquals([ "a" => 1, "b" => 2], $results);
    }
}