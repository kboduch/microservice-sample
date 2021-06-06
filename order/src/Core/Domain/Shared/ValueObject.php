<?php
declare(strict_types=1);

namespace App\Core\Domain\Shared;

use Generator;

abstract class ValueObject
{
    /**
     * @return Generator<mixed>
     */
    abstract protected function equalityComponents(): Generator;

    public function equals(self $other): bool
    {
        if ($other::class !== $this::class) {
            return false;
        }

        if ($this->areEqualityComponentsDifferent($other)) {
            return false;
        }

        return true;
    }

    abstract public static function from(self $other): static;

    private function areEqualityComponentsDifferent(self $other): bool
    {
        $otherValueObjectComponents = $this->prepareComparableList($other->equalityComponents());
        $thisValueObjectComponents = $this->prepareComparableList($this->equalityComponents());

        if (\count($otherValueObjectComponents) !== \count($thisValueObjectComponents)) {
            return true;
        }

        foreach ($otherValueObjectComponents as $index => $otherValueObjectComponent) {
            $thisValueObjectComponent = $thisValueObjectComponents[$index];

            if ($otherValueObjectComponent instanceof self && $thisValueObjectComponent instanceof self) {
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

    /**
     * @param iterable<mixed> $iterable
     * @return array<mixed>
     */
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
