<?php

namespace Atrapalo\PHPTools\Tests\Tester\Collection;

use Atrapalo\PHPTools\Tester\Collection\EntityStrictCollectionTester;
use PHPUnit\Framework\TestCase;

/**
 * Class LemonPieCollectionTest
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class LemonPieCollectionTest extends TestCase
{
    use EntityStrictCollectionTester;

    /**
     * @return string
     */
    protected function entityCollectionClass(): string
    {
        return LemonPieCollection::class;
    }
}
