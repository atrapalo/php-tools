<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityCollection;

/**
 * Class LemonPieCollection
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class LemonPieCollection extends EntityCollection
{
    /**
     * @return string
     */
    public static function entityClass(): string
    {
        return LemonPie::class;
    }

    /**
     * @return \Exception
     */
    public static function customEmptyException(): \Exception
    {
        return new LemonPieEmptyCollectionException('Collection can not be empty');
    }

    /**
     * @return \Exception
     */
    public static function customInvalidEntityException(): \Exception
    {
        return new LemonPieInvalidElementCollectionException('Element is not valid instance of LemonPie');
    }
}

/**
 * Class LemonPie
 * @package Atrapalo\PHPTools\Tests\Collection
 */
class LemonPie
{
}

/**
 * Class LemonPieEmptyCollectionException
 * @package Atrapalo\PHPTools\Tests\Collection
 */
class LemonPieEmptyCollectionException extends \LengthException
{
}

/**
 * Class LemonPieEmptyCollectionException
 * @package Atrapalo\PHPTools\Tests\Collection
 */
class LemonPieInvalidElementCollectionException extends \UnexpectedValueException
{
}
