<?php

namespace App\App\Infra\DAO;

use Carbon\Carbon;

final class UserDAO
{
    private $connection;

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
        $stmt = $this->connection->prepare("SELECT id, display_name, email, image FROM users");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam('email', $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $stmt = $this->connection->prepare("SELECT id, display_name, email, image FROM users WHERE id = :id");
        $stmt->bindParam('id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(array $user): void
    {
        $stmt = $this->connection->prepare("
            INSERT INTO users (display_name, email, password, image, created_at, updated_at) VALUES (:display_name, :email, :password, :image, :created_at, :updated_at)
        ");
        $now = Carbon::now();
        $stmt->bindParam('display_name', $user['display_name']);
        $stmt->bindParam('email', $user['email']);
        $stmt->bindParam('password', $user['password']);
        $stmt->bindParam('image', $user['image']);
        $stmt->bindParam('created_at', $now);
        $stmt->bindParam('updated_at', $now);
        $stmt->execute();
    }
    public function deleteByEmail(string $email)
    {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE email = :email");
        $stmt->bindParam('email', $email);
        $stmt->execute();
    }
}
