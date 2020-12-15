<?php

declare(strict_types=1);

namespace App\Domain;

use App\App\Infra\ResponseCode;
use App\Domain\DomainBlogException;
use App\Domain\DTOs\AuthUserDTO;
use App\Domain\DTOs\CreateUserDTO;
use App\Domain\Utils\Jwt;

final class AuthService
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

    public function auth(AuthUserDTO $authUserDTO): string
    {
        $user = $this->repository->findUserByEmail($authUserDTO->getEmail());
        if (!$user) {
            throw new DomainBlogException('User is invalid');
        }

        if (
            !password_verify(
                $authUserDTO->getPassword(),
                $user['password']
            )
        ) {
            throw new DomainBlogException('User is invalid');
        }

        return Jwt::generate([
            'email' => $user['email'],
            'code' => $user['id']
        ]);
    }
}
