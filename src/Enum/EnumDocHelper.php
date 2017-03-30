<?php

namespace Atrapalo\PHPTools\Enum;

/**
 * Class EnumDocHelper
 * @package Atrapalo\PHPTools\Enum
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EnumDocHelper
{
    /**
     * @return int
     */
    public static function main(): int
    {
        $command = new static;

        return $command->run($_SERVER['argv']);
    }

    /**
     * @param array $arguments
     * @return int
     */
    public function run(array $arguments): int
    {
        try {
            $className = $this->handleArguments($arguments);
            if (class_exists($className)) {
                $reflection = new \ReflectionClass($className);
                $constants = $this->constants($reflection);

                $this->printHeader($reflection->getShortName(), $reflection->getNamespaceName());
                $this->printMethods($constants, $reflection->getShortName());
                $this->printFooter();
            } else {
                throw new \InvalidArgumentException('Class not exist');
            }
        } catch (\Exception $exception) {
            $this->printError($exception->getMessage());
        }

        return 0;
    }

    /**
     * @param \ReflectionClass $reflection
     * @return array
     */
    private function constants(\ReflectionClass $reflection): array
    {
        if (!$this->isFinalParentEnumInstance($reflection)) {
            throw new \LogicException('Class must be instance of Enum');
        }

        $constants = $reflection->getConstants();
        if (empty($constants)) {
            throw new \LengthException('Not exist constants in this Enum class');
        }

        return $constants;
    }

    /**
     * @param \ReflectionClass $reflection
     * @return bool
     */
    private function isFinalParentEnumInstance(\ReflectionClass $reflection): bool
    {
        $maxLoop = 100;
        while (($parent = $reflection->getParentClass()) && --$maxLoop > 0)
        {
            if ($parent->getName() === Enum::class) {
                return true;
            }

            $reflection = $parent;
        }

        return false;
    }

    /**
     * @param array $arguments
     * @return string
     */
    private function handleArguments(array $arguments): string
    {
        if (isset($arguments[1])) {
            return $arguments[1];
        }

        return '';
    }

    /**
     * @param string $shortClassName
     * @param string $nameSpace
     */
    private function printHeader(string $shortClassName, string $nameSpace)
    {
        echo "/**".PHP_EOL;
        echo " * Class $shortClassName".PHP_EOL;
        echo " * @package $nameSpace".PHP_EOL;
        $this->printBlankLine();
    }

    /**
     * @param array  $constants
     * @param string $shortClassName
     */
    private function printMethods(array $constants, string $shortClassName)
    {
        $this->staticMethodsForConstants($constants, $shortClassName);
        $this->printBlankLine();
        $this->conditionalMethodsForConstants($constants);
    }

    private function printBlankLine()
    {
        echo " * ".PHP_EOL;
    }

    private function printFooter()
    {
        echo " */".PHP_EOL;
    }

    /**
     * @param array  $constants
     * @param string $shortClassName
     */
    private function staticMethodsForConstants(array $constants, string $shortClassName)
    {
        foreach ($constants as $constantName => $constantValue) {
            $function = $this->snakeCaseToCamelCase($constantName);

            echo " * @method static {$shortClassName} {$function}()".PHP_EOL;
        }
    }

    /**
     * @param array $constants
     */
    private function conditionalMethodsForConstants(array $constants)
    {
        foreach ($constants as $constantName => $constantValue) {
            $function = $this->snakeCaseToCamelCase("IS_$constantName");

            echo " * @method bool $function()".PHP_EOL;
        }
    }

    /**
     * @param string $string
     * @return string
     */
    private function snakeCaseToCamelCase(string $string): string
    {
        return preg_replace_callback('/_(.?)/', function($matches) {
            return ucfirst($matches[1]);
        }, strtolower($string));
    }

    /**
     * @param string $errorMessage
     */
    private function printError(string $errorMessage)
    {
        echo "\e[31;1mERROR\e[0m: $errorMessage".PHP_EOL;;
    }
}
