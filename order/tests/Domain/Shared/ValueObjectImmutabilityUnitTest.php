<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Core\Domain\Shared\ValueObject;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ValueObjectImmutabilityUnitTest extends TestCase
{
    /**
     * @dataProvider \App\Tests\Domain\Shared\AllValueObjectSubclassesProvider::all_value_object_subclasses
     */
    public function test_copied_value_object_should_be_of_another_instance(ValueObject $original): void
    {
        Assert::assertNotSame(
            $original,
            $original::class::from($original),
            'they should be different because value objects must be immutable'
        );
    }

    public function test_copied_value_object_clones_object_references(): void
    {
        $item = new Item(1, 'a', 'b');
        $original = new Box(1, 'a', [$item]);
        $copy = Box::from($original);
        Assert::assertNotSame($item, $copy->getC()[0], 'they should be different to maintain immutability');
        Assert::markTestIncomplete('Test all subclasses which contain a reference to other objects');
    }
}