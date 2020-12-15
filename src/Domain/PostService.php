<?php

declare(strict_types=1);

namespace App\Domain;

use App\App\Infra\ResponseCode;
use App\Domain\DomainBlogException;
use App\Domain\DTOs\CreatedPostDTO;
use App\Domain\DTOs\CreatePostDTO;
use App\Domain\DTOs\CreateUserDTO;
use App\Domain\Utils\Jwt;

final class PostService
{
    private PostRepositoryInterface $repository;

    /**
     * PostService constructor.
     * @param PostRepositoryInterface $repository
     */
    public function __construct(PostRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function save(CreatePostDTO $post, int $userId): CreatedPostDTO
    {
        $this->repository->save($post, $userId);

        return new CreatedPostDTO(
            $post->getTitle(),
            $post->getContent(),
            $userId
        );
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
        $user = $this->repository->findUserById($id);;

        if (!$user) {
            throw new DomainBlogException('User not found', ResponseCode::HTTP_NOT_FOUND);
        }

        return $user;
    }
}
