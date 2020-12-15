<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

use App\Domain\VOs\DisplayNameVo;
use App\Domain\VOs\EmailVo;
use App\Domain\VOs\PasswordVo;

final class CreateUserDTO
{
    private DisplayNameVo $displayName;
    private EmailVo $email;
    private PasswordVo $password;
    private ?string $image;

    /**
     * CreateUserDTO constructor.
     * @param DisplayNameVo $displayName
     * @param EmailVo $email
     * @param PasswordVo $password
     * @param string|null $image
     */
    public function __construct(
        DisplayNameVo $displayName,
        EmailVo $email,
        PasswordVo $password,
        ?string $image = null
    ) {
        $this->displayName = $displayName;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
    }

    /**
     * @return DisplayNameVo
     */
    public function getDisplayName(): DisplayNameVo
    {
        return $this->displayName;
    }

    /**
     * @return EmailVo
     */
    public function getEmail(): EmailVo
    {
        return $this->email;
    }

    /**
     * @return PasswordVo
     */
    public function getPassword(): PasswordVo
    {
        return $this->password;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function toArray(): array
    {
        return [
            'display_name' => $this->displayName->getValue(),
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
            'image' => $this->image
        ];
    }
}
