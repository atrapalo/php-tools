<?php

namespace Atrapalo\PHPTools\Enum;

class EnumDocHelper
{
    /**
     * @param bool $exit
     */
    public static function main(bool $exit = true)
    {
        $command = new static;
        return $command->run($_SERVER['argv'], $exit);
    }

    /**
     * @param array $argv
     * @param bool  $exit
     *
     * @return int
     */
    public function run(array $argv, bool $exit = true)
    {
        var_dump($argv);

        return 0;
    }
}