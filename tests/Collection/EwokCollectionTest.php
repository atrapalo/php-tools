<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityCollection;

/**
 * Class EwokCollectionTest
 * @package Atrapalo\PHPTools\Tests\Collection
 *
 * @author Guillermo González <guillermo.gonzalez@atrapalo.com>
 */
class EwokCollectionTest extends BaseEntityCollectionTest
{
    /**
     * @param array $elements
     * @return EntityCollection
     */
    protected function buildCollection(array $elements)
    {
        return new EwokCollection($elements);
    }

    /**
     * @return array
     */
    public function provideDifferentElements()
    {
        return [
            'indexed'     => [[new Ewok(), new Ewok(), new Ewok(), new Ewok(), new Ewok()]],
            'associative' => [['A' => new Ewok(), 'B' => new Ewok(), 'C' => new Ewok()]],
            'mixed'       => [['A' => new Ewok(), new Ewok(), 'B' => new Ewok(), new Ewok(), new Ewok()]],
        ];
    }
}
