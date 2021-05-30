<?php

declare(strict_types=1);

namespace App\Tests\Domain\Shared;

use App\Domain\Shared\ValueObject;
use Generator;

final class Item extends ValueObject
{
    public function __construct(
        private int $a,
        private string $b,
        private string $notEqualityComponent
    ) {
    }

    /**
     * @param Item $other
     * @@return Item 
     */
    public static function from(ValueObject $other): static
    {
        $other instanceof self ?: throw new \InvalidArgumentException('Expected instance of ' . self::class);

        return new self($other->a, $other->b, $other->notEqualityComponent);
    }

    /**
     * @return Generator<mixed>
     */
    protected function equalityComponents(): Generator
    {
        yield $this->a;
        yield $this->b;
    }
}
