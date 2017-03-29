<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityCollectionTester;
use PHPUnit\Framework\TestCase;

/**
 * Class LemonPieCollectionTest
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class LemonPieCollectionTest extends TestCase
{
    use EntityCollectionTester;

    /**
     * @return string
     */
    protected function entityCollectionClass(): string
    {
        return LemonPieCollection::class;
    }
}
