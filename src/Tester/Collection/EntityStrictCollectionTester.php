<?php

namespace Atrapalo\PHPTools\Tester\Collection;

use Atrapalo\PHPTools\Collection\EntityStrictCollection;

/**
 * Class EntityCollectionTester
 * @package Atrapalo\PHPTools\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
trait EntityStrictCollectionTester
{
    /**
     * @return string
     */
    abstract protected function entityCollectionClass(): string;

    /**
     * @test
     */
    public function emptyConstructor()
    {
        /** @var EntityStrictCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();
        $exception = $entityCollectionClass::customEmptyException();

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new $entityCollectionClass([]);
    }

    /**
     * @test
     * @dataProvider invalidEntities
     * @param array $elements
     */
    public function invalidElementByConstructor(array $elements)
    {
        /** @var EntityStrictCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();
        $exception = $entityCollectionClass::customInvalidEntityException();

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new $entityCollectionClass($elements);
    }

    /**
     * @return array
     */
    public function invalidEntities()
    {
        return [
            [[1]],
            [['element']],
            [[new \stdClass()]],
            [[new \stdClass(), new \stdClass()]],
            [[null]],
            [[false]]
        ];
    }

    /**
     * @test
     */
    public function invalidAddElement()
    {
        /** @var EntityStrictCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();
        $exception = $entityCollectionClass::customInvalidEntityException();

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        /** @var EntityStrictCollection $collection */
        $collection = new $entityCollectionClass([$this->prophesize($entityCollectionClass::entityClass())->reveal()], true);
        $collection->add([]);
    }

    /**
     * @test
     */
    public function validElementByConstructor()
    {
        /** @var EntityStrictCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();

        /** @var EntityStrictCollection $collection */
        $collection = new $entityCollectionClass([$this->prophesize($entityCollectionClass::entityClass())->reveal()], true);

        $this->assertSame(1, $collection->count());
        $this->assertInstanceOf($entityCollectionClass::entityClass(), $collection->current());
    }

    /**
     * @test
     */
    public function addTwoValidElement()
    {
        /** @var EntityStrictCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();

        /** @var EntityStrictCollection $collection */
        $collection = new $entityCollectionClass([$this->prophesize($entityCollectionClass::entityClass())->reveal()], true);


        /** @var \Prophecy\Prophecy\ObjectProphecy $entity */
        $entity = $this->prophesize($entityCollectionClass::entityClass());
        $collection->add($entity->reveal());
        $collection->add($entity->reveal());

        $this->assertSame(3, $collection->count());
        foreach ($collection as $element) {
            $this->assertInstanceOf($entityCollectionClass::entityClass(), $element);
        }
    }
}
