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
        $otherValueObjectComponents = $this->prepareComparableList($other->equalityComponents());
        $thisValueObjectComponents = $this->prepareComparableList($this->equalityComponents());

        if (count($otherValueObjectComponents) !== count($thisValueObjectComponents)) {
            return true;
        }

        foreach ($otherValueObjectComponents as $index => $otherValueObjectComponent) {
            $thisValueObjectComponent = $thisValueObjectComponents[$index];

            if ($otherValueObjectComponent instanceof ValueObject && $thisValueObjectComponent instanceof ValueObject) {
                if (!$thisValueObjectComponent->equals($otherValueObjectComponent)) {
                    return true;
                }
                continue;
            }

            if ($thisValueObjectComponent !== $otherValueObjectComponent) {
                return true;
            }
        }

        return false;
    }

    private function prepareComparableList(iterable $iterable): array
    {
        $result = [];

        foreach ($iterable as $value) {
            if (is_iterable($value)) {
                array_push($result, ...$this->prepareComparableList($value));
                continue;
            }

            $result[] = $value;
        }

        return $result;
    }
}