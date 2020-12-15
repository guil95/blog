<?php

declare(strict_types=1);


namespace App\Domain;

use App\Domain\DTOs\CreateUserDTO;
use App\Domain\VOs\EmailVo;

interface UserRepositoryInterface
{
    public function findUserByEmail(EmailVo $email): ?array;
    public function findAll(): ?array;
    public function findById(int $id): ?array;
    public function deleteByEmail(EmailVo $email): void;
    public function save(CreateUserDTO $user): void;
}
