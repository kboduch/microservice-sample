<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

abstract class AllValueObjectSubclassesProvider
{
    public static function all_value_object_subclasses(): iterable
    {
        yield [new Item(1, 'a', 'b')];
        yield [new Box(1, 'a', [new Item(2, 'b', 'b')])];
        yield [new SpecificItem(1, 'a', 'b')];
    }
}
