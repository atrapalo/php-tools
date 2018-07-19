<?php

namespace Atrapalo\PHPTools\Collection;

/**
 * Class EntityStrictCollection
 * @package Atrapalo\PHPTools\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
abstract class EntityStrictCollection extends EntityCollection
{
    /**
     * Collection constructor.
     * @param array $entities
     * @param bool  $allowEntitiesChildren
     * @throws \Exception
     */
    public function __construct(array $entities)
    {
        if (empty($entities)) {
            throw static::customEmptyException();
        }

        foreach ($entities as $entity) {
            $this->add($entity);
        }
    }

    /**
     * @param int  $offset
     * @param null $length
     * @return static
     * @throws \Exception
     */
    public function slice(int $offset, $length = null)
    {
        $entities = array_slice($this->toArray(), $offset, $length, true);
        if (empty($entities)) {
            throw static::customEmptyException();
        }

        return new static($entities);
    }

    /**
     * @return \Exception
     */
    public static function customEmptyException(): \Exception
    {
        return new \LengthException('Collection can not be empty');
    }
}
