<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Core\Domain\Shared\ValueObject;
use Generator;

abstract class AllValueObjectSubclassesProvider
{
    /**
     * @return Generator<array<ValueObject>>
     */
    public static function all_value_object_subclasses(): Generator
    {
        yield [new Item(1, 'a', 'b')];
        yield [
            new Box(
                1,
                'a',
                [
                    new Item(2, 'b', 'b'),
                    new Item(3, 'c', 'c')
                ],
                [
                    new Item(4, 'd', 'f'),
                    new Item(5, 'e', 'g')
                ],
            )
        ];
    }
}
