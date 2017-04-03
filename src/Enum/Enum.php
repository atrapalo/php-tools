<?php

namespace Atrapalo\PHPTools\Enum;

/**
 * Class Enum
 * @package Atrapalo\PHPTools\Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
abstract class Enum
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var array
     */
    protected static $cache = array();

    /**
     * @param mixed $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        if (!$this->isValid($value)) {
            throw static::customInvalidValueException($value);
        }

        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return static::search($this->value);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @param Enum $enum
     * @return bool True if Enums are equal, false if not equal
     */
    final public function equals(Enum $enum): bool
    {
        return $this->value() === $enum->value() && static::class === get_class($enum);
    }

    /**
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(static::toArray());
    }

    /**
     * @return static[] Constant name in key, Enum instance in value
     */
    public static function values(): array
    {
        $values = array();

        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }

        return $values;
    }

    /**
     * @return array Constant name in key, constant value in value
     */
    public static function toArray(): array
    {
        $class = get_called_class();
        if (!array_key_exists($class, static::$cache)) {
            $reflection            = new \ReflectionClass($class);
            static::$cache[$class] = $reflection->getConstants();
        }

        return static::$cache[$class];
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        return in_array($value, static::toArray(), true);
    }

    /**
     * @param $key
     * @return bool
     */
    public static function isValidKey($key): bool
    {
        $array = static::toArray();

        return isset($array[$key]);
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function search($value)
    {
        return array_search($value, static::toArray(), true);
    }

    /**
     * Returns a value when called statically like so: MyEnum::someValue() given SOME_VALUE is a class constant
     * @example MyEnum::someValue()
     *
     * @param string $name
     * @param array  $arguments
     * @return static
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $key = self::toSnakeCase($name);
        $array = static::toArray();
        if (array_key_exists($key, $array)) {
            return new static($array[$key]);
        }

        throw static::customUnknownStaticMethodException($name);
    }


    /**
     * Check if a given key is selected using the "isKey" syntax.
     * @example $myEnum->isSomeValue()
     *
     * @param string $method
     * @param        $arguments
     * @return bool
     * @throws \Exception
     */
    public function __call($method, $arguments): bool
    {
        if (substr($method, 0, 2) === 'is')  {
            $key = $this->toSnakeCase(substr($method, 2));
            $array = static::toArray();
            if (array_key_exists($key, $array)) {
                return $this->value() === $array[$key];
            }
        }

        throw static::customUnknownMethodException($method);
    }

    /**
     * @param string $string
     * @return string
     */
    private static function toSnakeCase(string $string): string
    {
        return strtoupper(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/',
            '_',
            $string
        ));
    }

    /**
     * @param string $value
     * @return \Exception
     */
    public static function customInvalidValueException(string $value): \Exception
    {
        return new \UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
    }

    /**
     * @param string $method
     * @return \Exception
     */
    public static function customUnknownStaticMethodException(string $method): \Exception
    {
        return new \BadMethodCallException("No static method or enum constant '$method' in class " . get_called_class());
    }

    /**
     * @param string $method
     * @return \Exception
     */
    public static function customUnknownMethodException(string $method): \Exception
    {
        return new \BadMethodCallException(sprintf('The method "%s" is not defined.', $method));
    }
}