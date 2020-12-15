<?php

use App\App\Infra\ResponseCode;

$app->get('/health', function() {
    $response = new \Slim\Psr7\Response();
    $response->getBody()->write('Ok');
    return $response->withStatus(ResponseCode::HTTP_OK);
});

$app->post('/user', \App\App\Controllers\UserController::class. ':save')
    ->add(\App\App\Middleware\ParseRequest::class)
    ->add(\App\App\Middleware\NormalizeErrorsResponses::class)
;

$app->get('/user', \App\App\Controllers\UserController::class. ':findAll')
    ->add(
        new Tuupola\Middleware\JwtAuthentication([
            "secure" => false,
            "secret" => getenv("SECRET_JWT")
        ])
    )
    ->add(\App\App\Middleware\ParseRequest::class)
    ->add(\App\App\Middleware\NormalizeErrorsResponses::class)
    ->add(new \App\App\Middleware\UserExists($app->getContainer()))
;


$app->get('/user/{id}', \App\App\Controllers\UserController::class. ':findOne')
    ->add(
        new Tuupola\Middleware\JwtAuthentication([
            "secure" => false,
            "secret" => getenv("SECRET_JWT")
        ])
    )
    ->add(\App\App\Middleware\ParseRequest::class)
    ->add(\App\App\Middleware\NormalizeErrorsResponses::class)
    ->add(new \App\App\Middleware\UserExists($app->getContainer()))
;

$app->delete('/user/me', \App\App\Controllers\UserController::class. ':deleteUser')
    ->add(
        new Tuupola\Middleware\JwtAuthentication([
            "secure" => false,
            "secret" => getenv("SECRET_JWT")
        ])
    )
    ->add(\App\App\Middleware\ParseRequest::class)
    ->add(\App\App\Middleware\NormalizeErrorsResponses::class)
    ->add(new \App\App\Middleware\UserExists($app->getContainer()))
;

$app->post('/post', \App\App\Controllers\PostController::class. ':save')
    ->add(
        new Tuupola\Middleware\JwtAuthentication([
            "secure" => false,
            "secret" => getenv("SECRET_JWT")
        ])
    )
    ->add(\App\App\Middleware\ParseRequest::class)
    ->add(\App\App\Middleware\NormalizeErrorsResponses::class)
    ->add(new \App\App\Middleware\UserExists($app->getContainer()))
;

$app->post('/login', \App\App\Controllers\LoginController::class. ':auth')
    ->add(\App\App\Middleware\ParseRequest::class)
    ->add(\App\App\Middleware\NormalizeErrorsResponses::class)
;
