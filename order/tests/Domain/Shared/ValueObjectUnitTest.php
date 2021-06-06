<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Core\Domain\Shared\ValueObject;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ValueObjectUnitTest extends TestCase
{
    public function test_all_value_object_subclasses_are_tested(): void
    {
        Assert::assertEquals(
            count($this->getAllDeclaredValueObjectSubclasses()),
            iterator_count(AllValueObjectSubclassesProvider::all_value_object_subclasses()),
            'they should be equal because all Value Object subclasses must be tested'
        );
    }

    public function test_all_value_object_subclasses_are_final(): void
    {
        foreach ($this->getAllDeclaredValueObjectSubclasses() as $className) {
            /** @var class-string $className */
            $ref = new ReflectionClass($className);
            Assert::assertTrue($ref->isFinal());
        }
    }

    /**
     * @return array<string>
     */
    private function getAllDeclaredValueObjectSubclasses(): array
    {
        return array_filter(
            get_declared_classes(),
            fn($x) => is_subclass_of($x, ValueObject::class)
        );
    }
}