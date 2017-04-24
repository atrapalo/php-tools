<?php

namespace Atrapalo\PHPTools\Tests\Collection;

/**
 * Class BaseEntityStrictCollectionTest
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
abstract class BaseEntityStrictCollectionTest extends BaseEntityCollectionTest
{
    /**
     * @test
     * @expectedException \LengthException
     * @expectedExceptionMessage Collection can not be empty
     */
    public function emptyConstruct()
    {
        $this->buildCollection([]);
    }

    /**
     * @test
     * @dataProvider provideDifferentElements
     */
    public function slice($elements)
    {
        $collection = $this->buildCollection($elements);
        $elements = array_values($elements);

        $length = intval(ceil(count($elements)/2));
        $sliceCollection = $collection->slice(0, $length);

        $this->assertCount($length, $sliceCollection);
    }

    /**
     * @test
     * @dataProvider provideDifferentElements
     */
    public function sliceWithOffset($elements)
    {
        $collection = $this->buildCollection($elements);
        $elements = array_values($elements);

        $length = intval(ceil(count($elements)/2));
        $offset = intval(ceil(count($length)/2));
        $sliceCollection = $collection->slice($offset, $length);

        $this->assertCount($length, $sliceCollection);
    }

    /**
     * @test
     * @dataProvider provideDifferentElements
     * @expectedException \LengthException
     * @expectedExceptionMessage Collection can not be empty
     */
    public function sliceEmpty($elements)
    {
        $collection = $this->buildCollection($elements);

        $collection->slice(0, 0);
    }

    /**
     * @test
     * @dataProvider provideDifferentElements
     * @expectedException \LengthException
     * @expectedExceptionMessage Collection can not be empty
     */
    public function sliceEmptyByOffset($elements)
    {
        $collection = $this->buildCollection($elements);

        $collection->slice(count($elements), 0);
    }
}
