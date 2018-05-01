<?php

use Collections\Collection;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    public function test_map_ints()
    {
        $c = (new Collection('int'))
              ->add(1)
              ->add(2)
              ->add(3)
              ->add(4);

        $result = $c->map(function ($a) { return $a * 3; });

        $expected = (new Collection('int'))
                    ->add(3)
                    ->add(6)
                    ->add(9)
                    ->add(12);

        $this->assertEquals($expected, $result);
    }

    public function test_map_strings()
    {
        $c = (new Collection('string'))
              ->add('a')
              ->add('b')
              ->add('c')
              ->add('d');

        $result = $c->map(function ($a) { return strtoupper($a); });

        $expected = (new Collection('string'))
                    ->add('A')
                    ->add('B')
                    ->add('C')
                    ->add('D');

        $this->assertEquals($expected, $result);
    }

    public function test_map_object()
    {
        $c = (new Collection('string'))
              ->add('05/01/2016')
              ->add('05/02/2016')
              ->add('05/03/2016')
              ->add('05/04/2016');

        $result = $c->map(function ($a) { return new \DateTime($a); });

        $expected = (new Collection('DateTime'))
                        ->add(new \DateTime('05/01/2016'))
                        ->add(new \DateTime('05/02/2016'))
                        ->add(new \DateTime('05/03/2016'))
                        ->add(new \DateTime('05/04/2016'));

        $this->assertEquals($expected, $result);

        $count = 0;
        $result = $c->map(function ($a) use (&$count) { return $count++; });
       
        $expected = (new Collection('integer'))
                        ->add(0)
                        ->add(1)
                        ->add(2)
                        ->add(3);

        $this->assertEquals($expected, $result);

    }

    public function test_map_empty_collection()
    {
        $c = new Collection('string');
        $result = $c->map(function ($a) {
            return $a;
        });
        $expected = new Collection('string');
        $this->assertEquals($expected, $result);
    }
}
