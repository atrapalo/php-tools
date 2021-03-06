<?php

namespace Atrapalo\PHPTools\Tests\Enum;

use Atrapalo\PHPTools\Enum\Enum;

/**
 * Class CloneEnumMock
 *
 * @method static EnumFixtureCloned foo()
 * @method static EnumFixtureCloned bar()
 * @method static EnumFixtureCloned number()
 * @method static EnumFixtureCloned problematicNumber()
 * @method static EnumFixtureCloned problematicNull()
 * @method static EnumFixtureCloned problematicEmptyString()
 * @method static EnumFixtureCloned problematicBooleanFalse()
 *
 * @method bool isFoo()
 * @method bool isBar()
 * @method bool isNumber()
 * @method bool isProblematicNumber()
 * @method bool isProblematicNull()
 * @method bool isProblematicEmptyString()
 * @method bool isProblematicBooleanFalse()
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EnumFixtureCloned extends Enum
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

    /**
     * @param string $value
     * @return \Exception
     */
    public static function customInvalidValueException(string $value): \Exception
    {
        return new EnumFixtureClonedUnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
    }

    /**
     * @param string $method
     * @return \Exception
     */
    public static function customUnknownStaticMethodException(string $method): \Exception
    {
        throw new EnumFixtureClonedBadMethodCallException("No static method or enum constant '$method' in class " . get_called_class());
    }

    /**
     * @param string $method
     * @return \Exception
     */
    public static function customUnknownMethodException(string $method): \Exception
    {
        throw new EnumFixtureClonedBadMethodCallException(sprintf('The method "%s" is not defined.', $method));
    }
}

class EnumFixtureClonedUnexpectedValueException extends \UnexpectedValueException
{
}

class EnumFixtureClonedBadMethodCallException extends \BadMethodCallException
{
}
