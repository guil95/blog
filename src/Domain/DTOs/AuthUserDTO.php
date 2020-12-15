<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

use App\Domain\VOs\DisplayNameVo;
use App\Domain\VOs\EmailVo;
use App\Domain\VOs\PasswordVo;

final class AuthUserDTO
{
    private EmailVo $email;
    private string $password;

    /**
     * AuthUserDTO constructor.
     * @param EmailVo $email
     * @param string $password
     */
    public function __construct(
        EmailVo $email,
        string $password
    ) {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return EmailVo
     */
    public function getEmail(): EmailVo
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
