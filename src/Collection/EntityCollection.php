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
    private $entities = array();

    /**
     * @return string
     */
    abstract public static function entityClass(): string;

    /**
     * Collection constructor.
     * @param array $entities
     * @param bool  $allowEntitiesChildren
     */
    public function __construct(array $entities = array())
    {
        foreach ($entities as $entity) {
            $this->add($entity);
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
    protected function set($key, $entity)
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

        return is_a($entity, static::entityClass());
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
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
     * @param int  $offset
     * @param null $length
     * @return static
     */
    public function slice(int $offset, $length = null)
    {
        $entities = array_slice($this->entities, $offset, $length, true);

        return new static($entities);
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
    public static function customInvalidEntityException(): \Exception
    {
        return new \UnexpectedValueException('Element is not valid instance of '.static::entityClass());
    }
}
