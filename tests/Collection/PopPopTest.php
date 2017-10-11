<?php

use Collections\Collection;

class PopPopTest extends PHPUnit_Framework_TestCase
{
    public function test_pop_pop()
    {
        $col = new Collection('int', [1,2,3,4]);
        $this->assertEquals([4,3], $col->popPop());

        $col = new Collection('int', [1,2]);
        $this->assertEquals([2,1], $col->popPop());

        $col = new Collection('int', [1]);
        $this->assertEquals([1, null], $col->popPop());

        $col = new Collection('int', []);
        $this->assertEquals([null, null], $col->popPop());
    }
}
