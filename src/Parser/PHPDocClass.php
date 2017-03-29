<?php

namespace Atrapalo\PHPTools\Parser;

use Atrapalo\PHPTools\Parser\Values\Method;
use Atrapalo\PHPTools\Parser\Values\Param;

/**
 * Class PHPDocClass
 * @package Atrapalo\PHPTools\Parser
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class PHPDocClass
{
    /**
     * @param string $className
     * @return Method[]
     */
    public static function staticMethods(string $className): array
    {
        $classDoc = self::docComment($className);

        preg_match_all(
            '/^[*\h]+@method(?>\hstatic)\s?([a-zA-Z0-9_\-\$\\\h]*)\h(\w+)\(([a-zA-Z0-9_\-$,\\\h]*)\)\h?(.*)$/im',
            $classDoc,
            $staticMethodsOfDoc,
            PREG_SET_ORDER
        );

        return self::createMethods($staticMethodsOfDoc, true);
    }

    /**
     * @param string $className
     * @return Method[]
     */
    public static function methods(string $className): array
    {
        $classDoc = self::docComment($className);

        preg_match_all(
            '/^[*\h]+@method(?!.*static\h)([a-zA-Z0-9_\-\$\\\h]*)\h(\w+)\(([a-zA-Z0-9_\-$,\\\h]*)\)\h?(.*)$/im',
            $classDoc,
            $staticMethodsOfDoc,
            PREG_SET_ORDER
        );

        return self::createMethods($staticMethodsOfDoc, false);
    }

    /**
     * @param string $className
     * @return string
     */
    private static function docComment(string $className): string
    {
        $rc = new \ReflectionClass($className);

        return $rc->getDocComment();
    }

    /**
     * @param array $methodsOfDoc
     * @param bool  $areStatics
     * @return array
     */
    private static function createMethods(array $methodsOfDoc, bool $areStatics): array
    {
        $methods = [];
        foreach ($methodsOfDoc as $methodOfDoc) {
            $return = isset($methodOfDoc[1]) ? $methodOfDoc[1] : '';
            $name = isset($methodOfDoc[2]) ? $methodOfDoc[2] : '';
            $params = isset($methodOfDoc[3]) ? self::parseParams($methodOfDoc[3]) : [];
            $description = isset($methodOfDoc[4]) ? trim($methodOfDoc[4]) : '';

            $method = new Method($areStatics, $name);
            $method->setReturn($return)
                ->setDescription($description)
                ->setParams($params);

            $methods[] = $method;
        }

        return $methods;
    }

    /**
     * @param string $stringParams
     * @return array
     */
    private static function parseParams(string $stringParams): array
    {
        $params = [];
        if (!empty($stringParams)){
            $paramsSlice = explode(',', $stringParams);
            foreach ($paramsSlice as $paramElement) {
                preg_match('/([\\a-z]*)\h?(\$\w+)/i', $paramElement, $paramData);
                if (count($paramData) == 3) {
                    $type = isset($paramData[1]) ? $paramData[1] : '';
                    $name = isset($paramData[2]) ? $paramData[2] : '';

                    $params[] = new Param($name, $type);
                }
            }
        }

        return $params;
    }
}
