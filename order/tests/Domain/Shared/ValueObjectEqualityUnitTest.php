<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Domain\Shared\ValueObject;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ValueObjectEqualityUnitTest extends TestCase
{
    /**
     * @dataProvider equalValueObjects
     */
    public function test_equal_value_objects_are_equal(ValueObject $voA, ValueObject $voB, string $reason): void
    {
        Assert::assertTrue($voA->equals($voB), $reason);
    }

    /**
     * @dataProvider nonEqualValueObjects
     */
    public function test_non_equal_value_objects_are_not_equal(ValueObject $voA, ValueObject $voB, string $reason): void
    {
        Assert::assertFalse($voA->equals($voB), $reason);
    }

    /**
     * @dataProvider \App\Tests\Domain\Shared\AllValueObjectSubclassesProvider::all_value_object_subclasses
     */
    public function test_copied_value_object_should_represent_the_same_value(ValueObject $original): void
    {
        $copy = $original::class::from($original);
        Assert::assertTrue($original->equals($copy));
    }

    public function equalValueObjects(): iterable
    {
        $item = new Item(1, 'a', 'nonEqualityComponent');
        yield [$item, $item, 'they should be equal because they are the same object'];

        yield [
            new Item(2, 'b', 'nonEqualityComponent'),
            new Item(2, 'b', 'nonEqualityComponent'),
            'they should be equal because they have equal members'
        ];

        yield [
            new Box(1, 'a', [new Item(2, 'b', 'nonEqualityComponent')]),
            new Box(1, 'a', [new Item(2, 'b', 'nonEqualityComponent')]),
            'they should be equal because they have equal members'
        ];
    }

    public function nonEqualValueObjects(): iterable
    {
        yield [
            new Item(3, 'a', 'nonEqualityComponent'),
            new Box(1, 'a', [new Item(1, 'a', 'nonEqualityComponent')]),
            'they should not be equal because they are different classes'
        ];

        $identicalArguments = [4, 'a', 'nonEqualityComponent'];
        yield [
            new Item(...$identicalArguments),
            new SpecificItem(...$identicalArguments),
            'they should not be equal because inherited classes should not be equal'
        ];

        yield [
            new Item(1, 'b', 'nonEqualityComponent'),
            new Item(2, 'b', 'nonEqualityComponent'),
            'they should not be equal because one of the equalityComponents on Item is different'
        ];

        yield [
            new Box(1, 'a', [new Item(2, 'a', 'nonEqualityComponent')]),
            new Box(1, 'a', [new Item(2, 'b', 'nonEqualityComponent')]),
            'they should not be equal because one of the equalityComponents on Box is different'
        ];

//        yield [
//            new Box(1, 'a', [new Item(2, 'a', 'nonEqualityComponent')]),
//            new Box(
//                1,
//                'a',
//                [
//                    new Item(2, 'a', 'nonEqualityComponent'),
//                    new Item(3, 'c', 'nonEqualityComponent')
//                ]
//            ),
//            'they should not be equal because one of the equalityComponents on Box is different'
//        ];
//
//        yield [
//            new Box(1, 'a', [new Item(2, 'a', 'nonEqualityComponent')]),
//            new Box(
//                1,
//                'a',
//                [
//                    new Item(2, 'a', 'nonEqualityComponent'),
//                ],
//                [
//                    new Item(2, 'a', 'nonEqualityComponent'),
//                    new Item(3, 'c', 'nonEqualityComponent')
//                ]
//            ),
//            'they should not be equal because one of the equalityComponents on Box is different'
//        ];
    }
}
