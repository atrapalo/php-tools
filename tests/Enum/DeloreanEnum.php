<?php

namespace Atrapalo\PHPTools\Tests\Enum;

use Atrapalo\PHPTools\Enum\Enum;

/**
 * Class DeloreanEnum
 * @package Atrapalo\PHPTools\Tests\Enum
 *
 * @method static DeloreanEnum foo()
 * @method static DeloreanEnum bar()
 * @method static DeloreanEnum number()
 * @method static DeloreanEnum problematicNumber()
 * @method static DeloreanEnum problematicNull()
 * @method static DeloreanEnum problematicEmptyString()
 * @method static problematicBooleanFalse()
 *
 * @method bool isFoo()
 * @method bool isBar()
 * @method bool isNumber()
 * @method bool isProblematicNumber()
 * @method bool isProblematicNull()
 * @method bool isProblematicEmptyString()
 * @method isProblematicBooleanFalse()
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class DeloreanEnum extends Enum
{
    const FOO = "foo";
    const BAR = "bar";
    const NUMBER = 42;

    /**
     * Values that are known to cause problems when used with soft typing
     */
    const PROBLEMATIC_NUMBER = 0;
    const PROBLEMATIC_NULL = null;
    const PROBLEMATIC_EMPTY_STRING = '';
    const PROBLEMATIC_BOOLEAN_FALSE = false;
}