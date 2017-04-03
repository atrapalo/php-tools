<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use PHPUnit\Framework\TestCase;

class UniqueEntityCollectionTest extends TestCase
{
    /**
     * @return string
     */
    protected function entityCollectionClass(): string
    {
        return MinionCollections::class;
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     */
    public function invalidEntity()
    {
        new MinionCollections([new \stdClass()]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function invalidId()
    {
        new MinionCollections([new Minion('')]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function duplicateElementsByConstruct()
    {
        new MinionCollections([
            new Minion('Dave'),
            new Minion('Stuart'),
            new Minion('Dave')
        ]);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function addDuplicateElements()
    {
        $collection = new MinionCollections([
            new Minion('Dave'),
            new Minion('Stuart')
        ]);

        $collection->add(new Minion('Dave'));
    }

    /**
     * @test
     */
    public function existElements()
    {
        $collection = new MinionCollections([
            new Minion('Dave'),
            new Minion('Stuart')
        ]);

        $this->assertTrue($collection->exist(new Minion('Dave')));
        $this->assertFalse($collection->exist(new Minion('Tim')));
    }

    /**
     * @test
     */
    public function validElements()
    {
        $collection = new MinionCollections([
            new Minion('Dave'),
            new Minion('Stuart')
        ]);

        $collection->add(new Minion('Tim'));

        $this->assertCount(3, $collection);
    }
}