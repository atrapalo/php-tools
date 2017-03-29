<?php

namespace Atrapalo\PHPTools\Tests\Enum;

use PHPUnit\Framework\TestCase;

/**
 * Class EnumTest
 * @package Atrapalo\PHPTools\Tests\Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function value()
    {
        $value = new DeloreanEnum(DeloreanEnum::FOO);
        $this->assertEquals(DeloreanEnum::FOO, $value->value());

        $value = new DeloreanEnum(DeloreanEnum::BAR);
        $this->assertEquals(DeloreanEnum::BAR, $value->value());

        $value = new DeloreanEnum(DeloreanEnum::NUMBER);
        $this->assertEquals(DeloreanEnum::NUMBER, $value->value());
    }

    /**
     * @test
     */
    public function key()
    {
        $value = new DeloreanEnum(DeloreanEnum::FOO);
        $this->assertEquals('FOO', $value->key());
        $this->assertNotEquals('BA', $value->key());
    }

    /**
     * @test
     * @dataProvider invalidValueProvider
     * @param $value
     */
    public function creatingEnumWithInvalidValue($value)
    {
        $this->expectException(
            \UnexpectedValueException::class
        );
        $this->expectExceptionMessage(
            'Value \'' . $value . '\' is not part of the enum Atrapalo\PHPTools\Tests\Enum\DeloreanEnum'
        );

        new DeloreanEnum($value);
    }

    /**
     * @test
     * @dataProvider invalidValueProvider
     * @param $value
     */
    public function creatingEnumWithInvalidValueAndCustomException($value)
    {
        $this->expectException(
            DeloreanClonedEnumUnexpectedValueException::class
        );
        $this->expectExceptionMessage(
            'Value \'' . $value . '\' is not part of the enum Atrapalo\PHPTools\Tests\Enum\DeloreanClonedEnum'
        );

        new DeloreanClonedEnum($value);
    }

    /**
     * @return array
     */
    public function invalidValueProvider() {
        return array(
            "string" => array('test'),
            "int" => array(1234),
        );
    }

    /**
     * @test
     * @dataProvider toStringProvider
     * @param $expected
     * @param $enumObject
     */
    public function toStringEnum($expected, $enumObject)
    {
        $this->assertSame($expected, (string) $enumObject);
    }

    /**
     * @return array
     */
    public function toStringProvider() {
        return array(
            array(DeloreanEnum::FOO, new DeloreanEnum(DeloreanEnum::FOO)),
            array(DeloreanEnum::BAR, new DeloreanEnum(DeloreanEnum::BAR)),
            array((string) DeloreanEnum::NUMBER, new DeloreanEnum(DeloreanEnum::NUMBER)),
        );
    }

    /**
     * @test
     */
    public function keys()
    {
        $values = DeloreanEnum::keys();
        $expectedValues = array(
            "FOO",
            "BAR",
            "NUMBER",
            "PROBLEMATIC_NUMBER",
            "PROBLEMATIC_NULL",
            "PROBLEMATIC_EMPTY_STRING",
            "PROBLEMATIC_BOOLEAN_FALSE",
        );

        $this->assertSame($expectedValues, $values);
    }

    /**
     * @test
     */
    public function values()
    {
        $values = DeloreanEnum::values();
        $expectedValues = array(
            "FOO"                       => new DeloreanEnum(DeloreanEnum::FOO),
            "BAR"                       => new DeloreanEnum(DeloreanEnum::BAR),
            "NUMBER"                    => new DeloreanEnum(DeloreanEnum::NUMBER),
            "PROBLEMATIC_NUMBER"        => new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NUMBER),
            "PROBLEMATIC_NULL"          => new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NULL),
            "PROBLEMATIC_EMPTY_STRING"  => new DeloreanEnum(DeloreanEnum::PROBLEMATIC_EMPTY_STRING),
            "PROBLEMATIC_BOOLEAN_FALSE" => new DeloreanEnum(DeloreanEnum::PROBLEMATIC_BOOLEAN_FALSE),
        );

        $this->assertEquals($expectedValues, $values);
    }

    /**
     * @test
     */
    public function toArray()
    {
        $values = DeloreanEnum::toArray();
        $expectedValues = array(
            "FOO"                   => DeloreanEnum::FOO,
            "BAR"                   => DeloreanEnum::BAR,
            "NUMBER"                => DeloreanEnum::NUMBER,
            "PROBLEMATIC_NUMBER"    => DeloreanEnum::PROBLEMATIC_NUMBER,
            "PROBLEMATIC_NULL"      => DeloreanEnum::PROBLEMATIC_NULL,
            "PROBLEMATIC_EMPTY_STRING"    => DeloreanEnum::PROBLEMATIC_EMPTY_STRING,
            "PROBLEMATIC_BOOLEAN_FALSE"    => DeloreanEnum::PROBLEMATIC_BOOLEAN_FALSE,
        );

        $this->assertSame($expectedValues, $values);
    }

    /**
     * @test
     */
    public function staticAccess()
    {
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::FOO), DeloreanEnum::foo());
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::BAR), DeloreanEnum::bar());
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::NUMBER), DeloreanEnum::number());
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NUMBER), DeloreanEnum::problematicNumber());
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NULL), DeloreanEnum::problematicNull());
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::PROBLEMATIC_EMPTY_STRING), DeloreanEnum::problematicEmptyString());
        $this->assertEquals(new DeloreanEnum(DeloreanEnum::PROBLEMATIC_BOOLEAN_FALSE), DeloreanEnum::problematicBooleanFalse());
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage No static method or enum constant 'UNKNOWN' in class
     *                           UnitTest\MyCLabs\Enum\Enum\DeloreanEnum
     */
    public function badStaticAccess()
    {
        DeloreanEnum::UNKNOWN();
    }

    /**
     * @test
     * @expectedException \Atrapalo\PHPTools\Tests\Enum\DeloreanClonedEnumBadMethodCallException
     * @expectedExceptionMessage No static method or enum constant 'UNKNOWN' in class
     *                           UnitTest\MyCLabs\Enum\Enum\DeloreanClonedEnum
     */
    public function badStaticAccessCustomException()
    {
        DeloreanClonedEnum::UNKNOWN();
    }

    /**
     * @test
     */
    public function isAccess()
    {
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::FOO))->isFoo());
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::BAR))->isBar());
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::NUMBER))->isNumber());
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NUMBER))->isProblematicNumber());
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NULL))->isProblematicNull());
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::PROBLEMATIC_EMPTY_STRING))->isProblematicEmptyString());
        $this->assertTrue((new DeloreanEnum(DeloreanEnum::PROBLEMATIC_BOOLEAN_FALSE))->isProblematicBooleanFalse());

        $this->assertFalse((new DeloreanEnum(DeloreanEnum::FOO))->isBar());
        $this->assertFalse((new DeloreanEnum(DeloreanEnum::FOO))->isNumber());
        $this->assertFalse((new DeloreanEnum(DeloreanEnum::FOO))->isProblematicNumber());
        $this->assertFalse((new DeloreanEnum(DeloreanEnum::FOO))->isProblematicNull());
        $this->assertFalse((new DeloreanEnum(DeloreanEnum::FOO))->isProblematicEmptyString());
        $this->assertFalse((new DeloreanEnum(DeloreanEnum::FOO))->isProblematicBooleanFalse());
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage The method "isUnknown" is not defined.
     */
    public function badIsAccess()
    {
        (new DeloreanEnum(DeloreanEnum::FOO))->isUnknown();
    }

    /**
     * @test
     * @expectedException \Atrapalo\PHPTools\Tests\Enum\DeloreanClonedEnumBadMethodCallException
     * @expectedExceptionMessage The method "isUnknown" is not defined.
     */
    public function badIsAccessCustomException()
    {
        (new DeloreanClonedEnum(DeloreanEnum::FOO))->isUnknown();
    }

    /**
     * @test
     * @dataProvider isValidProvider
     * @param string $value
     * @param bool $isValid
     */
    public function isValid($value, $isValid)
    {
        $this->assertSame($isValid, DeloreanEnum::isValid($value));
    }

    /**
     * @return array
     */
    public function isValidProvider() {
        return array(
            /**
             * Valid values
             */
            array('foo', true),
            array(42, true),
            array(null, true),
            array(0, true),
            array('', true),
            array(false, true),
            /**
             * Invalid values
             */
            array('baz', false)
        );
    }

    /**
     * @test
     */
    public function isValidKey()
    {
        $this->assertTrue(DeloreanEnum::isValidKey('FOO'));
        $this->assertFalse(DeloreanEnum::isValidKey('BAZ'));
    }

    /**
     * @test
     * @dataProvider searchProvider
     * @param string $value
     * @param bool $expected
     */
    public function search($value, $expected)
    {
        $this->assertSame($expected, DeloreanEnum::search($value));
    }

    /**
     * @return array
     */
    public function searchProvider() {
        return array(
            array('foo', 'FOO'),
            array(0, 'PROBLEMATIC_NUMBER'),
            array(null, 'PROBLEMATIC_NULL'),
            array('', 'PROBLEMATIC_EMPTY_STRING'),
            array(false, 'PROBLEMATIC_BOOLEAN_FALSE'),
            array('bar I do not exist', false),
            array(array(), false),
        );
    }

    /**
     * @test
     */
    public function equals()
    {
        $foo = new DeloreanEnum(DeloreanEnum::FOO);
        $number = new DeloreanEnum(DeloreanEnum::NUMBER);
        $anotherFoo = new DeloreanEnum(DeloreanEnum::FOO);
        $cloneFoo = new DeloreanClonedEnum(DeloreanEnum::FOO);

        $this->assertTrue($foo->equals($foo));
        $this->assertFalse($foo->equals($number));
        $this->assertTrue($foo->equals($anotherFoo));
        $this->assertFalse($foo->equals($cloneFoo));
    }

    /**
     * @test
     */
    public function equalsComparesProblematicValuesProperly()
    {
        $false = new DeloreanEnum(DeloreanEnum::PROBLEMATIC_BOOLEAN_FALSE);
        $emptyString = new DeloreanEnum(DeloreanEnum::PROBLEMATIC_EMPTY_STRING);
        $null = new DeloreanEnum(DeloreanEnum::PROBLEMATIC_NULL);
        $cloneNull = new DeloreanClonedEnum(DeloreanEnum::PROBLEMATIC_NULL);

        $this->assertTrue($false->equals($false));
        $this->assertFalse($false->equals($emptyString));
        $this->assertFalse($emptyString->equals($null));
        $this->assertFalse($null->equals($false));
        $this->assertFalse($null->equals($cloneNull));
    }
}