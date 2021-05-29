<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use function count;

abstract class ValueObject
{
    protected abstract function equalityComponents(): iterable;

    public function equals(ValueObject $other): bool
    {
        if ($other::class !== $this::class) {
            return false;
        }

        if ($this->areEqualityComponentsDifferent($other)) {
            return false;
        }

        return true;
    }

    public abstract static function from(ValueObject $other): static;

    private function areEqualityComponentsDifferent(ValueObject $other): bool
    {
        $otherValueObjectComponents = $this->flatEqualityComponents($other->equalityComponents());
        $thisValueObjectComponents = $this->flatEqualityComponents($this->equalityComponents());

        if (count($otherValueObjectComponents) !== count($thisValueObjectComponents)) {
            return true;
        }

        foreach ($otherValueObjectComponents as $index => $otherValueObjectComponent) {
            $thisValueObjectComponent = $thisValueObjectComponents[$index];

            if ($thisValueObjectComponent !== $otherValueObjectComponent) {
                return true;
            }
        }

        return false;
    }

    private function flatEqualityComponents(iterable $iterable): array
    {
        $result = [];

        foreach ($iterable as $value) {
            if ($value instanceof ValueObject) {
                return array_merge($result, $this->flatEqualityComponents($value->equalityComponents()));
            }

            if (is_iterable($value)) {
                return array_merge($result, $this->flatEqualityComponents($value));
            }

            $result[] = $value;
        }

        return $result;
    }
}