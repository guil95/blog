<?php

declare(strict_types=1);


namespace App\Domain\VOs;

use App\Domain\Capabilities\VoCapabilities;
use App\Domain\Exceptions\InvalidPasswordException;

final class PasswordVo
{
    use VoCapabilities;

    public function __construct(string $value, bool $encrypt = true)
    {
        if (mb_strlen($value) < 6) {
            throw new InvalidPasswordException('Password is invalid');
        }

        $this->value = $encrypt
            ? password_hash($value, PASSWORD_BCRYPT, ['cost' => 12])
            : $value
        ;
    }
}
