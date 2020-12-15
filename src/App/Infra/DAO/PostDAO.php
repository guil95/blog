<?php

namespace App\App\Infra\DAO;

use Carbon\Carbon;

final class PostDAO
{
    private $connection;
    private string $tableName = 'posts';
    /**
     * Customer constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        /**
         * @var $connection \PDO
         */
        $this->connection = $connection;
    }

    public function findAll(): array
    {
        $stmt = $this->connection->prepare("SELECT id, display_name, email, image FROM $this->tableName");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM $this->tableName WHERE email = :email");
        $stmt->bindParam('email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = $this->connection->prepare("SELECT id, display_name, email, image FROM $this->tableName WHERE id = :id");
        $stmt->bindParam('id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(array $post, int $userId): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO posts (user_id, title, content, published, updated_at) VALUES (:user_id, :title, :content, :published, :updated_at)
        ");
        $now = Carbon::now();
        $stmt->bindParam('user_id', $userId);
        $stmt->bindParam('title', $post['title']);
        $stmt->bindParam('content', $post['content']);
        $stmt->bindParam('published', $now);
        $stmt->bindParam('updated_at', $now);
        $stmt->execute();
    }
    public function deleteByEmail(string $email)
    {
        $stmt = $this->connection->prepare("DELETE FROM $this->tableName WHERE email = :email");
        $stmt->bindParam('email', $email);
        $stmt->execute();
    }
}
