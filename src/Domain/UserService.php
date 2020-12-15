<?php

declare(strict_types=1);

namespace App\Domain;

use App\App\Infra\ResponseCode;
use App\Domain\DTOs\CreateUserDTO;
use App\Domain\Utils\Jwt;
use App\Domain\VOs\EmailVo;

final class UserService
{
    private UserRepositoryInterface $repository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save(CreateUserDTO $userDto): string
    {
        $user = $this->repository->findUserByEmail($userDto->getEmail());
        if ($user) {
            throw new DomainBlogException('User exists', ResponseCode::HTTP_CONFLICT);
        }

        $this->repository->save($userDto);

        return Jwt::generate([
            'email' => $userDto->getEmail()->getValue(),
            'code' => $user['id']
        ]);
    }

    public function findAll()
    {
        $users = $this->repository->findAll();

        if (!$users) {
            throw new DomainBlogException('Users not found', ResponseCode::HTTP_NOT_FOUND);
        }

        return $users;
    }

    public function findById(int $id)
    {
        $user = $this->repository->findById($id);

        if (!$user) {
            throw new DomainBlogException('User not found', ResponseCode::HTTP_NOT_FOUND);
        }

        return $user;
    }

    public function deleteUser(EmailVo $email)
    {
        if (!$this->repository->findUserByEmail($email)) {
            throw new DomainBlogException('User not found', ResponseCode::HTTP_NOT_FOUND);
        }

        $this->repository->deleteByEmail($email);
    }

    public function findUserByEmail(EmailVo $email): ?array
    {
        $user = $this->repository->findUserByEmail($email);
        if (!$user) {
            throw new DomainBlogException('User not found', ResponseCode::HTTP_NOT_FOUND);
        }

        return $user;
    }
}
