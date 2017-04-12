<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\UniqueEntityCollection;

/**
 * Class MinionCollections
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class MinionCollections extends UniqueEntityCollection
{
    /**
     * @return string
     */
    public static function entityClass(): string
    {
        return Minion::class;
    }

    /**
     * @param Minion $entity
     * @return string
     */
    public function entityUniqueId($entity): string
    {
        return $entity->name();
    }

}

/**
 * Class Minion
 * @package Atrapalo\PHPTools\Tests\Collection
 */
class Minion
{
    /** @var string */
    private $name;

    /**
     * Minion constructor.
     * @param $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}
