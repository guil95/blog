<?php

declare(strict_types=1);

namespace App\Domain\VOs;

use App\Domain\Capabilities\VoCapabilities;
use App\Domain\Exceptions\InvalidDisplayNameException;
use App\Domain\Exceptions\InvalidEmailException;

final class EmailVo
{
    use VoCapabilities;

    /**
     * EmailVo constructor.
     * @param string $value
     * @throws InvalidEmailException
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Email is invalid');
        }

        $this->value = $value;
    }
}
