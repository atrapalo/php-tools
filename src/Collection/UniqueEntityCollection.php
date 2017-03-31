<?php

namespace Atrapalo\PHPTools\Collection;

/**
 * Class UniqueEntityCollection
 * @package Collection
 */
abstract class UniqueEntityCollection extends EntityCollection
{
    /**
     * @param $entity
     * @return string
     */
    abstract public function entityUniqueId($entity): string;

    /**
     * @param $entity
     * @throws \Exception
     */
    public function add($entity)
    {
        if (!$this->isValid($entity)) {
            throw self::customInvalidEntityException();
        } elseif ($this->exist($entity)) {
            throw self::customDuplicateEntityException();
        }

        $this->set($this->entityUniqueId($entity), $entity);
    }

    /**
     * @param $entity
     * @return bool
     */
    public function exist($entity): bool
    {
        if (in_array($this->entityUniqueId($entity), $this->keys())) {
            return true;
        }

        return false;
    }

    /**
     * @return \Exception
     */
    public static function customDuplicateEntityException(): \Exception
    {
        return new \InvalidArgumentException("Entity already exists in collection");
    }
}
