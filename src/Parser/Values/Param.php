<?php

namespace Atrapalo\PHPTools\Parser\Values;

/**
 * Class Param
 * @package Atrapalo\PHPTools\Parser\Values
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class Param
{
    /** @var string */
    private $name;
    /** @var string */
    private $type;

    /**
     * Param constructor.
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type = '')
    {
        $this->setName($name);
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Param
     */
    private function setName(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name is mandatory and can not be empty');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }
}
