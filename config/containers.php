<?php

use App\App\Infra\DAO\Customer;
use App\Domain\Customer\CustomerService;

$container = new \DI\Container();

$db = [
    'driver' => getenv('DB_DRIVER'),
    'charset' => getenv('DB_CHARSET'),
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'pass' => getenv('DB_PASSWORD')
];

$conn = function () use ($db) {
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container->set(\App\Domain\UserService::class, function () use ($conn) {
    return new \App\Domain\UserService(
        new \App\App\Infra\Repositories\User\UserRepository(
            new \App\App\Infra\DAO\UserDAO($conn())
        )
    );
});

$container->set(\App\Domain\PostService::class, function () use ($conn, $container) {
    return new \App\Domain\PostService(
        new \App\App\Infra\Repositories\Post\PostRepository(
            new \App\App\Infra\DAO\PostDAO($conn())
        ),
        $container->get(\App\Domain\UserService::class)
    );
});

$container->set(\App\Domain\AuthService::class, function () use ($conn) {
    return new \App\Domain\AuthService(
        new \App\App\Infra\Repositories\User\UserRepository(
            new \App\App\Infra\DAO\UserDAO($conn())
        )
    );
});


