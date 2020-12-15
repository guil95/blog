<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\DTOs\CreatePostDTO;

interface PostRepositoryInterface
{
    public function findAll(): ?array;
    public function findById(int $id): ?array;
    public function save(CreatePostDTO $post, int $userId): void;
}
