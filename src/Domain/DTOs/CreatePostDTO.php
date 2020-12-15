<?php

declare(strict_types=1);

namespace App\Domain\DTOs;

final class CreatePostDTO
{
    private string $title;
    private string $content;

    /**
     * CreateUserDTO constructor.
     * @param string $title
     * @param string $content
     */
    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
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

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
