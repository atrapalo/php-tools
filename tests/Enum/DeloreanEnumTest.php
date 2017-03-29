<?php

namespace Atrapalo\PHPTools\Tests\Enum;

use Atrapalo\PHPTools\Enum\EnumPHPDocTester;
use PHPUnit\Framework\TestCase;

/**
 * Class DeloreanEnumTest
 * @package Atrapalo\PHPTools\Tests\Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class DeloreanEnumTest extends TestCase
{
    use EnumPHPDocTester;

    /**
     * @return string
     */
    protected function enumClass(): string
    {
        return DeloreanEnum::class;
    }
}
