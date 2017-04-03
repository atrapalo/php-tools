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

        $this->set($this->uniqueId($entity), $entity);
    }

    /**
     * @param $entity
     * @return bool
     */
    public function exist($entity): bool
    {
        if (in_array($this->uniqueId($entity), $this->keys())) {
            return true;
        }

        return false;
    }

    /**
     * @param $entity
     * @return string
     * @throws \Exception
     */
    private function uniqueId($entity): string
    {
        $uniqueId = $this->entityUniqueId($entity);
        if (empty($uniqueId)) {
            throw static::customInvalidEntityIdException();
        }

        return $uniqueId;
    }

    /**
     * @return \Exception
     */
    public static function customDuplicateEntityException(): \Exception
    {
        return new \InvalidArgumentException("Entity already exists in collection");
    }


    /**
     * @return \Exception
     */
    public static function customInvalidEntityIdException(): \Exception
    {
        return new \InvalidArgumentException('Entity unique id can not be empty');
    }
}
