<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityCollection;

/**
 * Class OreoCollection
 * @package Collection
 */
class OreoCollection extends EntityCollection
{
    /**
     * @return string
     */
    public static function entityClass(): string
    {
        return Oreo::class;
    }
}
