<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Shared;

use App\Domain\Shared\ValueObject;

class Item extends ValueObject
{
    public function __construct(
        private int $a,
        private string $b,
        private string $notEqualityComponent
    ) {
    }

    /**
     * @param Item $other
     */
    public static function from(ValueObject $other): static
    {
        return new static($other->a, $other->b, $other->notEqualityComponent);
    }

    protected function equalityComponents(): iterable
    {
        yield $this->a;
        yield $this->b;
    }
}
