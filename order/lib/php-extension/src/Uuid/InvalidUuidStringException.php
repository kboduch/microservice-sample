<?php

declare(strict_types=1);

namespace PhpExtension\Uuid;

use RuntimeException;

final class InvalidUuidStringException extends RuntimeException
{
    public function __construct(string $uuid)
    {
        parent::__construct('Invalid UUID string provided: ' . $uuid);
    }
}
