<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Domain\Shared\ValueObject;
use Generator;
use InvalidArgumentException;


final class Box extends ValueObject
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private int $a,
        private string $b,
        /** @var array<Item> $c */
        private array $c,
        /** @var array<Item> $d */
        private array $d = []
    ) {
        $instanceOfItemClass = fn($x) => $x instanceof Item ?: throw new InvalidArgumentException(
            'Expected instance of ' . Item::class
        );
        array_map($instanceOfItemClass, $c);
        array_map($instanceOfItemClass, $d);
    }

    /**
     * @param Box $other
     * @return Box
     */
    public static function from(ValueObject $other): static
    {
        $other instanceof self ?: throw new \InvalidArgumentException('Expected instance of ' . self::class);

        $c = array_map(fn($x) => clone $x, $other->c);
        $d = array_map(fn($x) => clone $x, $other->d);

        return new self($other->a, $other->b, $c, $d);
    }

    public function getA(): int
    {
        return $this->a;
    }

    public function getB(): string
    {
        return $this->b;
    }

    /**
     * @return array<Item>
     */
    public function getC(): array
    {
        return $this->c;
    }

    /**
     * @return array<Item>
     */
    public function getD(): array
    {
        return $this->d;
    }

    /**
     * @return Generator<mixed>
     */
    protected function equalityComponents(): Generator
    {
        yield $this->a;
        yield $this->b;
        yield $this->c;
        yield $this->d;
    }
}
