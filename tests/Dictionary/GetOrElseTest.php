<?php

namespace Collections\Tests\Dictionary;

use Collections\Dictionary;

class GetOrElseTest extends \PHPUnit_Framework_TestCase
{
    public function test_get_or_else()
    {
        $d = (new Dictionary('string', 'int'))
                ->add('a', 1)
                ->add('b', 2)
                ->add('c', 3)
                ->add('d', 4);

        $result = $d->getOrElse('a', 'default');
        $result2 = $d->getOrElse('e', 'default');

        $this->assertEquals(1, $result);
        $this->assertEquals('default', $result2);
    }
}
