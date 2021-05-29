<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared;

use App\Domain\Shared\ValueObject;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ValueObjectTest extends TestCase
{
    /**
     * @dataProvider \App\Tests\Unit\Domain\Shared\AllValueObjectSubclassesProvider::all_value_object_subclasses
     */
    public function test_all_value_object_subclasses_are_tested(): void
    {
        $numberOfDeclaredSubclasses = array_filter(
            get_declared_classes(),
            fn($x) => is_subclass_of($x, ValueObject::class)
        );
        Assert::assertEquals(
            count($numberOfDeclaredSubclasses),
            iterator_count(AllValueObjectSubclassesProvider::all_value_object_subclasses()),
            'they should be equal because all Value Object subclasses must be tested'
        );
    }
}