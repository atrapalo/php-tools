<?php

namespace Atrapalo\PHPTools\Collection;

/**
 * Class EntityCollectionTester
 * @package Atrapalo\PHPTools\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
trait EntityCollectionTester
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
        /** @var EntityCollection $entityCollectionClass */
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
        /** @var EntityCollection $entityCollectionClass */
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
        /** @var EntityCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();
        $exception = $entityCollectionClass::customInvalidEntityException();

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        /** @var EntityCollection $collection */
        $collection = new $entityCollectionClass([$this->prophesize($entityCollectionClass::entityClass())->reveal()], true);
        $collection->add([]);
    }

    /**
     * @test
     */
    public function validChildrenElementByConstructor()
    {
        /** @var EntityCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();
        $exception = $entityCollectionClass::customInvalidEntityException();

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new $entityCollectionClass([$this->prophesize($entityCollectionClass::entityClass())->reveal()]);
    }

    /**
     * @test
     */
    public function validElementByConstructor()
    {
        /** @var EntityCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();

        /** @var EntityCollection $collection */
        $collection = new $entityCollectionClass([$this->prophesize($entityCollectionClass::entityClass())->reveal()], true);

        $this->assertSame(1, $collection->count());
        $this->assertInstanceOf($entityCollectionClass::entityClass(), $collection->current());
    }

    /**
     * @test
     */
    public function addTwoValidElement()
    {
        /** @var EntityCollection $entityCollectionClass */
        $entityCollectionClass = $this->entityCollectionClass();

        /** @var EntityCollection $collection */
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
