<?php

declare(strict_types=1);

namespace App\Domain\VOs;

use App\Domain\Capabilities\VoCapabilities;
use App\Domain\Exceptions\InvalidDisplayNameException;

final class DisplayNameVo
{
    use VoCapabilities;

    /**
     * DisplayNameVo constructor.
     * @param string $value
     * @throws InvalidDisplayNameException
     */
    public function __construct(string $value)
    {
        if (mb_strlen($value) < 8) {
            throw new InvalidDisplayNameException('Display name is invalid');
        }

        $this->value = $value;
    }
}
