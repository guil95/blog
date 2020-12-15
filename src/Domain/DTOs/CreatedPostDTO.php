<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

final class CreatedPostDTO
{
    private string $title;
    private string $content;
    private int $userId;

    /**
     * CreatedPostDTO constructor.
     * @param string $title
     * @param string $content
     * @param int $userId
     */
    public function __construct(string $title, string $content, int $userId)
    {
        $this->title = $title;
        $this->content = $content;
        $this->userId = $userId;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'userId' => $this->userId
        ];
    }
}
