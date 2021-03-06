<?php

namespace Atrapalo\PHPTools\Tests\Tester\Enum;

use Atrapalo\PHPTools\Tester\Enum\EnumTester;
use PHPUnit\Framework\TestCase;

/**
 * Class DeloreanEnumTest
 * @package Atrapalo\PHPTools\Tests\Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class DeloreanEnumTest extends TestCase
{
    use EnumTester;

    /**
     * @return string
     */
    protected function enumClass(): string
    {
        return DeloreanEnum::class;
    }
}
