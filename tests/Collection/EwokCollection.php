<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityStrictCollection;

/**
 * Class EwokCollection
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EwokCollection extends EntityStrictCollection
{
    /**
     * @return string
     */
    public static function entityClass(): string
    {
        return Ewok::class;
    }

    /**
     * @param $key
     * @param $entity
     */
    public function setEntity($key, $entity)
    {
        parent::set($key, $entity);
    }
}
