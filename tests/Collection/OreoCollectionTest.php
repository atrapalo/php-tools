<?php

namespace Atrapalo\PHPTools\Tests\Collection;

use Atrapalo\PHPTools\Collection\EntityCollection;

/**
 * Class OreoCollectionTest
 * @package Collection
 */
class OreoCollectionTest extends BaseEntityCollectionTest
{
    /**
     * @param array $elements
     * @return OreoCollection
     */
    protected function buildCollection(array $elements)
    {
        return new OreoCollection($elements);
    }

    /**
     * @return array
     */
    public function provideDifferentElements()
    {
        return [
            'emptyArray'     => [[]],
            'indexed'     => [[new Oreo(), new Oreo(), new Oreo(), new Oreo(), new Oreo()]],
            'associative' => [['A' => new Oreo(), 'B' => new Oreo(), 'C' => new Oreo()]],
            'mixed'       => [['A' => new Oreo(), new Oreo(), 'B' => new Oreo(), new Oreo(), new Oreo()]],
        ];
    }
}
