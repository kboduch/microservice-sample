<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared;

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
        private array $c
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

    protected function equalityComponents(): iterable
    {
        yield $this->a;
        yield $this->b;
        foreach ($this->c as $item) {
            yield $item;
        }
    }
}
