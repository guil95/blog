<?php

declare(strict_types=1);

namespace App\App\Infra\Repositories\Post;

use App\App\Infra\DAO\PostDAO;
use App\Domain\DTOs\CreatePostDTO;
use App\Domain\PostRepositoryInterface;

final class PostRepository implements PostRepositoryInterface
{
    private PostDAO $postDAO;

    public function __construct(PostDAO $postDAO)
    {
        $this->postDAO = $postDAO;
    }

    public function findById(int $id): array
    {
        $post = $this->postDAO->findById($id);
        return $post ? $post : [];
    }

    public function save(CreatePostDTO $post, int $userId): void
    {
        $this->postDAO->save($post->toArray(), $userId);
    }

    public function findAll(): ?array
    {
        return $this->postDAO->findAll();
    }
}
