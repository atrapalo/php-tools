<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityCollection;

/**
 * Class EwokCollection
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EwokCollection extends EntityCollection
{
    /**
     * @return string
     */
    public static function entityClass(): string
    {
        return Ewok::class;
    }
}
