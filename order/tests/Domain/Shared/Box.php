<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Domain\Shared\ValueObject;
use InvalidArgumentException;

class Box extends ValueObject
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private int $a,
        private string $b,
        /** @var Item[] $c */
        private array $c,
        private array $d = []
    ) {
        array_map(
            fn($x) => $x instanceof Item ?: throw new InvalidArgumentException('Expected instance of ' . Item::class),
            $c
        );
    }

    /**
     * @param Box $other
     */
    public static function from(ValueObject $other): static
    {
        $c = array_map(fn($x) => clone $x, $other->c);

        return new static($other->a, $other->b, $c);
    }

    public function getA(): int
    {
        return $this->a;
    }

    public function getB(): string
    {
        return $this->b;
    }

    public function getC(): array
    {
        return $this->c;
    }

    public function getD(): array
    {
        return $this->d;
    }

    protected function equalityComponents(): iterable
    {
        yield $this->a;
        yield $this->b;
        yield $this->c;
        yield $this->d;
    }
}
