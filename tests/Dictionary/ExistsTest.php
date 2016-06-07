<?php

namespace Collections\Tests\Dictionary;


use Collections\Dictionary;

class ExistsTest extends \PHPUnit_Framework_TestCase
{
    public function test_key_exists_returns_true()
    {
        $d = (new Dictionary('string','int'))->add('a',1);

        $this->assertTrue($d->exists('a'));
    }

    public function test_key_exists_returns_false()
    {
        $d = (new Dictionary('string','int'))->add('a',1);

        $this->assertFalse($d->exists('b'));
    }

    public function test_value_exists_returns_true()
    {
        $d = (new Dictionary('string','int'))->add('a',1);

        $this->assertTrue($d->valueExists(1));
    }

    public function test_value_exists_returns_false()
    {
        $d = (new Dictionary('string','int'))->add('a',1);

        $this->assertFalse($d->valueExists(2));
    }
}