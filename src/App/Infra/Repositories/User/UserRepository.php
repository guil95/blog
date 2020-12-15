<?php

declare(strict_types=1);

namespace App\App\Infra\Repositories\User;

use App\App\Infra\DAO\UserDAO;
use App\Domain\DTOs\CreateUserDTO;
use App\Domain\UserRepositoryInterface;
use App\Domain\VOs\EmailVo;

final class UserRepository implements UserRepositoryInterface
{
    private UserDAO $userDAO;

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    public function findUserByEmail(EmailVo $email): array
    {
        $user = $this->userDAO->findByEmail($email->getValue());

        return $user ? $user : [] ;
    }

    public function findById(int $id): array
    {
        $user = $this->userDAO->findById($id);
        return $user ? $user : [];
    }

    public function save(CreateUserDTO $user): void
    {
        $this->userDAO->save($user->toArray());
    }

    public function findAll(): ?array
    {
        return $this->userDAO->findAll();
    }

    public function deleteByEmail(EmailVo $email): void
    {
        $this->userDAO->deleteByEmail($email->getValue());
    }
}
