<?php

declare(strict_types=1);

namespace PhpExtension\Uuid;

use Ramsey\Uuid\Uuid as BaseUuid;
use Stringable;

final class Uuid implements Stringable
{
    public function __construct(private string $uuid)
    {
        self::isValid($uuid) ?: throw new InvalidUuidStringException($uuid);
    }

    public static function isValid(string $string): bool
    {
        return BaseUuid::isValid($string);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }
}
