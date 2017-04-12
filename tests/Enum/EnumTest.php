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
        $value = new EnumFixture(EnumFixture::FOO);
        $this->assertEquals(EnumFixture::FOO, $value->value());

        $value = new EnumFixture(EnumFixture::BAR);
        $this->assertEquals(EnumFixture::BAR, $value->value());

        $value = new EnumFixture(EnumFixture::NUMBER);
        $this->assertEquals(EnumFixture::NUMBER, $value->value());
    }

    /**
     * @test
     */
    public function key()
    {
        $value = new EnumFixture(EnumFixture::FOO);
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
            'Value \'' . $value . '\' is not part of the enum Atrapalo\PHPTools\Tests\Enum\EnumFixture'
        );

        new EnumFixture($value);
    }

    /**
     * @test
     * @dataProvider invalidValueProvider
     * @param $value
     */
    public function creatingEnumWithInvalidValueAndCustomException($value)
    {
        $this->expectException(
            EnumFixtureClonedUnexpectedValueException::class
        );
        $this->expectExceptionMessage(
            'Value \'' . $value . '\' is not part of the enum Atrapalo\PHPTools\Tests\Enum\EnumFixtureCloned'
        );

        new EnumFixtureCloned($value);
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
            array(EnumFixture::FOO, new EnumFixture(EnumFixture::FOO)),
            array(EnumFixture::BAR, new EnumFixture(EnumFixture::BAR)),
            array((string) EnumFixture::NUMBER, new EnumFixture(EnumFixture::NUMBER)),
        );
    }

    /**
     * @test
     */
    public function keys()
    {
        $values = EnumFixture::keys();
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
        $values = EnumFixture::values();
        $expectedValues = array(
            "FOO"                       => new EnumFixture(EnumFixture::FOO),
            "BAR"                       => new EnumFixture(EnumFixture::BAR),
            "NUMBER"                    => new EnumFixture(EnumFixture::NUMBER),
            "PROBLEMATIC_NUMBER"        => new EnumFixture(EnumFixture::PROBLEMATIC_NUMBER),
            "PROBLEMATIC_NULL"          => new EnumFixture(EnumFixture::PROBLEMATIC_NULL),
            "PROBLEMATIC_EMPTY_STRING"  => new EnumFixture(EnumFixture::PROBLEMATIC_EMPTY_STRING),
            "PROBLEMATIC_BOOLEAN_FALSE" => new EnumFixture(EnumFixture::PROBLEMATIC_BOOLEAN_FALSE),
        );

        $this->assertEquals($expectedValues, $values);
    }

    /**
     * @test
     */
    public function toArray()
    {
        $values = EnumFixture::toArray();
        $expectedValues = array(
            "FOO"                   => EnumFixture::FOO,
            "BAR"                   => EnumFixture::BAR,
            "NUMBER"                => EnumFixture::NUMBER,
            "PROBLEMATIC_NUMBER"    => EnumFixture::PROBLEMATIC_NUMBER,
            "PROBLEMATIC_NULL"      => EnumFixture::PROBLEMATIC_NULL,
            "PROBLEMATIC_EMPTY_STRING"    => EnumFixture::PROBLEMATIC_EMPTY_STRING,
            "PROBLEMATIC_BOOLEAN_FALSE"    => EnumFixture::PROBLEMATIC_BOOLEAN_FALSE,
        );

        $this->assertSame($expectedValues, $values);
    }

    /**
     * @test
     */
    public function staticAccess()
    {
        $this->assertEquals(new EnumFixture(EnumFixture::FOO), EnumFixture::foo());
        $this->assertEquals(new EnumFixture(EnumFixture::BAR), EnumFixture::bar());
        $this->assertEquals(new EnumFixture(EnumFixture::NUMBER), EnumFixture::number());
        $this->assertEquals(new EnumFixture(EnumFixture::PROBLEMATIC_NUMBER), EnumFixture::problematicNumber());
        $this->assertEquals(new EnumFixture(EnumFixture::PROBLEMATIC_NULL), EnumFixture::problematicNull());
        $this->assertEquals(new EnumFixture(EnumFixture::PROBLEMATIC_EMPTY_STRING), EnumFixture::problematicEmptyString());
        $this->assertEquals(new EnumFixture(EnumFixture::PROBLEMATIC_BOOLEAN_FALSE), EnumFixture::problematicBooleanFalse());
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage No static method or enum constant 'UNKNOWN' in class
     *                           UnitTest\MyCLabs\Enum\Enum\EnumFixture
     */
    public function badStaticAccess()
    {
        EnumFixture::UNKNOWN();
    }

    /**
     * @test
     * @expectedException \Atrapalo\PHPTools\Tests\Enum\EnumFixtureClonedBadMethodCallException
     * @expectedExceptionMessage No static method or enum constant 'UNKNOWN' in class
     *                           UnitTest\MyCLabs\Enum\Enum\EnumFixtureCloned
     */
    public function badStaticAccessCustomException()
    {
        EnumFixtureCloned::UNKNOWN();
    }

    /**
     * @test
     */
    public function isAccess()
    {
        $this->assertTrue((new EnumFixture(EnumFixture::FOO))->isFoo());
        $this->assertTrue((new EnumFixture(EnumFixture::BAR))->isBar());
        $this->assertTrue((new EnumFixture(EnumFixture::NUMBER))->isNumber());
        $this->assertTrue((new EnumFixture(EnumFixture::PROBLEMATIC_NUMBER))->isProblematicNumber());
        $this->assertTrue((new EnumFixture(EnumFixture::PROBLEMATIC_NULL))->isProblematicNull());
        $this->assertTrue((new EnumFixture(EnumFixture::PROBLEMATIC_EMPTY_STRING))->isProblematicEmptyString());
        $this->assertTrue((new EnumFixture(EnumFixture::PROBLEMATIC_BOOLEAN_FALSE))->isProblematicBooleanFalse());

        $this->assertFalse((new EnumFixture(EnumFixture::FOO))->isBar());
        $this->assertFalse((new EnumFixture(EnumFixture::FOO))->isNumber());
        $this->assertFalse((new EnumFixture(EnumFixture::FOO))->isProblematicNumber());
        $this->assertFalse((new EnumFixture(EnumFixture::FOO))->isProblematicNull());
        $this->assertFalse((new EnumFixture(EnumFixture::FOO))->isProblematicEmptyString());
        $this->assertFalse((new EnumFixture(EnumFixture::FOO))->isProblematicBooleanFalse());
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage The method "isUnknown" is not defined.
     */
    public function badIsAccess()
    {
        (new EnumFixture(EnumFixture::FOO))->isUnknown();
    }

    /**
     * @test
     * @expectedException \Atrapalo\PHPTools\Tests\Enum\EnumFixtureClonedBadMethodCallException
     * @expectedExceptionMessage The method "isUnknown" is not defined.
     */
    public function badIsAccessCustomException()
    {
        (new EnumFixtureCloned(EnumFixture::FOO))->isUnknown();
    }

    /**
     * @test
     * @dataProvider isValidProvider
     * @param string $value
     * @param bool $isValid
     */
    public function isValid($value, $isValid)
    {
        $this->assertSame($isValid, EnumFixture::isValid($value));
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
        $this->assertTrue(EnumFixture::isValidKey('FOO'));
        $this->assertFalse(EnumFixture::isValidKey('BAZ'));
    }

    /**
     * @test
     * @dataProvider searchProvider
     * @param string $value
     * @param bool $expected
     */
    public function search($value, $expected)
    {
        $this->assertSame($expected, EnumFixture::search($value));
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
        $foo = new EnumFixture(EnumFixture::FOO);
        $number = new EnumFixture(EnumFixture::NUMBER);
        $anotherFoo = new EnumFixture(EnumFixture::FOO);
        $cloneFoo = new EnumFixtureCloned(EnumFixture::FOO);

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
        $false = new EnumFixture(EnumFixture::PROBLEMATIC_BOOLEAN_FALSE);
        $emptyString = new EnumFixture(EnumFixture::PROBLEMATIC_EMPTY_STRING);
        $null = new EnumFixture(EnumFixture::PROBLEMATIC_NULL);
        $cloneNull = new EnumFixtureCloned(EnumFixture::PROBLEMATIC_NULL);

        $this->assertTrue($false->equals($false));
        $this->assertFalse($false->equals($emptyString));
        $this->assertFalse($emptyString->equals($null));
        $this->assertFalse($null->equals($false));
        $this->assertFalse($null->equals($cloneNull));
    }
}