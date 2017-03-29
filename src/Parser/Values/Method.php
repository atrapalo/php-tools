<?php

namespace Atrapalo\PHPTools\Parser\Values;

/**
 * Class Method
 * @package Atrapalo\PHPTools\Parser\Values
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class Method
{
    /** @var bool */
    private $isStatic;
    /** @var string */
    private $name;
    /** @var string */
    private $return;
    /** @var Param[] */
    private $params;
    /** @var string */
    private $description;

    /**
     * Method constructor.
     * @param bool   $isStatic
     * @param string $name
     */
    public function __construct(bool $isStatic, string $name)
    {
        $this->isStatic = $isStatic;
        $this->setName($name);
    }

    /**
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->isStatic;
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
     * @return Method
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
    public function return ()
    {
        return $this->return;
    }

    /**
     * @param string $return
     * @return Method
     */
    public function setReturn(string $return)
    {
        $this->return = $return;

        return $this;
    }

    /**
     * @return Param[]
     */
    public function params()
    {
        return $this->params;
    }

    /**
     * @param Param[] $params
     * @return Method
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Method
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}
