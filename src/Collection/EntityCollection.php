<?php

namespace Atrapalo\PHPTools\Collection;

/**
 * Class EntityCollection
 * @package Atrapalo\PHPTools\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
abstract class EntityCollection implements \Countable, \Iterator
{
    /** @var array */
    private $entities;
    /** @var bool */
    protected $allowEntitiesChildren;

    /**
     * @return string
     */
    abstract public static function entityClass(): string;

    /**
     * Collection constructor.
     * @param array $entities
     * @param bool  $allowEntitiesChildren
     * @throws \Exception
     */
    public function __construct(array $entities, bool $allowEntitiesChildren = false)
    {
        if (empty($entities)) {
            throw static::customEmptyException();
        }

        $this->allowEntitiesChildren = $allowEntitiesChildren;

        foreach ($entities as $key => $entity) {
            $this->set($key, $entity);
        }
    }

    /**
     * @param $entity
     * @throws \Exception
     */
    public function add($entity)
    {
        if (!$this->isValid($entity)) {
            throw static::customInvalidEntityException();
        }

        $this->entities[] = $entity;
    }

    /**
     * @param $key
     * @param $entity
     * @throws \Exception
     */
    public function set($key, $entity)
    {
        if (!$this->isValid($entity)) {
            throw static::customInvalidEntityException();
        }

        $this->entities[$key] = $entity;
    }

    /**
     * @param $entity
     * @return bool
     */
    public function isValid($entity): bool
    {
        if (!is_object($entity)) return false;

        $entityClass = $this->allowEntitiesChildren ? get_parent_class($entity) : get_class($entity);
        if ($entityClass === static::entityClass()){
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->entities);
    }

    /**
     * @return array
     */
    public function values(): array
    {
        return array_values($this->entities);
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->entities);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return end($this->entities);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->entities;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->entities);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->entities);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->entities);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->entities) !== null;
    }

    public function rewind()
    {
        reset($this->entities);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->entities);
    }

    /**
     * @return \Exception
     */
    public static function customEmptyException(): \Exception
    {
        return new \LengthException('Collection can not be empty');
    }

    /**
     * @return \Exception
     */
    public static function customInvalidEntityException(): \Exception
    {
        return new \UnexpectedValueException('Element is not valid instance of '.static::entityClass());
    }
}
