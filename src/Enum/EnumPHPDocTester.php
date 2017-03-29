<?php

namespace Atrapalo\PHPTools\Enum;

use Atrapalo\PHPTools\Parser\PHPDocClass;

/**
 * Class EnumPHPDocTester
 * @package Atrapalo\PHPTools\Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
trait EnumPHPDocTester
{
    /**
     * @return string
     */
    abstract protected function enumClass(): string;

    /**
     * @test
     */
    public function staticAccessByPhpDoc()
    {
        $className = $this->enumClass();

        $staticMethods = PHPDocClass::staticMethods($className);
        if (!empty($staticMethods)) {
            foreach ($staticMethods as $staticMethod) {
                $data = call_user_func([$className, $staticMethod->name()]);

                $this->assertInstanceOf($className, $data);
            }
        } else {
            $this->markTestSkipped('Skipped because no static methods were found');
        }
    }

    /**
     * @test
     */
    public function accessByPhpDoc()
    {
        $className = $this->enumClass();

        $methods = PHPDocClass::methods($className);
        if (!empty($methods)) {

            $enum = $this->createValidEnum($className);
            foreach ($methods as $method) {
                $methodName = $method->name();
                if (stristr($methodName, str_replace('_', '', $enum->key())) !== false) {
                    $this->assertTrue($enum->$methodName());
                } else {
                    $this->assertFalse($enum->$methodName());
                }
            }
        } else {
            $this->markTestSkipped('Skipped because no methods were found');
        }
    }

    /**
     * @param Enum|string $className
     * @return Enum
     */
    private function createValidEnum($className)
    {
        $values = $className::toArray();

        return new $className($values[array_rand($values)]);
    }

}