<?php

declare(strict_types=1);

namespace PhpExtension\Tests\Uuid;

use PhpExtension\Uuid\InvalidUuidStringException;
use PhpExtension\Uuid\Uuid;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;


class UuidUnitTest extends TestCase
{
    /**
     * @dataProvider uuidProvider
     */
    public function test_it_correctly_validates_uuid(bool $expectedResult, string $uuid): void
    {
        Assert::assertSame($expectedResult, Uuid::isValid($uuid));
    }

    public function test_invalid_uuid_string_throws_exception(): void
    {
        $this->expectException(InvalidUuidStringException::class);
        new Uuid('bad uuid string');
    }

    public function test_uuid_is_stringable(): void
    {
        Assert::assertSame(
            '6b537455-c289-4d5b-894b-69b308a06d93',
            (string)new Uuid('6b537455-c289-4d5b-894b-69b308a06d93')
        );
    }

    public function uuidProvider(): iterable
    {
        yield [false, 'bad uuid'];
        yield [true, '349a1eab-af4e-44e7-8884-d1ed79f8276d'];
    }
}