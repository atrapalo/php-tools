<?php

namespace Enum;

use Atrapalo\PHPTools\Enum\EnumDocHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class EnumDocHelperTest
 * @package Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EnumDocHelperTest extends TestCase
{
    protected function setUp()
    {
        $this->cleanBuffer();
        $_SERVER['argv'][0] = 'enum-doc';
    }

    /**
     * @test
     */
    public function createWithoutClassName()
    {
        unset($_SERVER['argv'][1]);
        EnumDocHelper::main();

        $this->assertSame("\e[31;1mERROR\e[0m: Class not exist".PHP_EOL, $this->bufferContend());
    }

    /**
     * @test
     */
    public function createWithNotEnumClass()
    {
        $_SERVER['argv'][1] = '\stdClass';
        EnumDocHelper::main();

        $this->assertSame("\e[31;1mERROR\e[0m: Class must be instance of Enum".PHP_EOL, $this->bufferContend());
    }

    /**
     * @test
     */
    public function createWithEmptyEnumClass()
    {
        $_SERVER['argv'][1] = 'Atrapalo\PHPTools\Tests\Enum\EmptyEnumMock';
        EnumDocHelper::main();

        $this->assertSame("\e[31;1mERROR\e[0m: Not exist constants in this Enum class".PHP_EOL, $this->bufferContend());
    }

    /**
     * @test
     */
    public function createWithEmptyChildEnumClass()
    {
        $_SERVER['argv'][1] = 'Atrapalo\PHPTools\Tests\Enum\ChildEmptyEnumMock';
        EnumDocHelper::main();

        $this->assertSame("\e[31;1mERROR\e[0m: Not exist constants in this Enum class".PHP_EOL, $this->bufferContend());
    }

    /**
     * @test
     */
    public function createValidEnumClass()
    {
        $_SERVER['argv'][1] = 'Atrapalo\PHPTools\Tests\Enum\DeloreanEnum';
        EnumDocHelper::main();

        $this->assertSame('/**
 * Class DeloreanEnum
 * @package Atrapalo\PHPTools\Tests\Enum
 * 
 * @method static DeloreanEnum foo()
 * @method static DeloreanEnum bar()
 * @method static DeloreanEnum number()
 * @method static DeloreanEnum problematicNumber()
 * @method static DeloreanEnum problematicNull()
 * @method static DeloreanEnum problematicEmptyString()
 * @method static DeloreanEnum problematicBooleanFalse()
 * 
 * @method bool isFoo()
 * @method bool isBar()
 * @method bool isNumber()
 * @method bool isProblematicNumber()
 * @method bool isProblematicNull()
 * @method bool isProblematicEmptyString()
 * @method bool isProblematicBooleanFalse()
 */'.PHP_EOL,
            $this->bufferContend()
        );
    }


    private function cleanBuffer()
    {
        ob_start();
        ob_clean();
    }

    /**
     * @return string
     */
    private function bufferContend()
    {
        return ob_get_clean();
    }
}
