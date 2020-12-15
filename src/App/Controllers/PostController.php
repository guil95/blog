<?php

namespace App\App\Controllers;

use App\App\Infra\ResponseCode;
use App\App\Utils\RequiredFieldsValidator;
use App\Domain\DomainBlogException;
use App\Domain\DTOs\CreatePostDTO;
use App\Domain\DTOs\CreateUserDTO;
use App\Domain\PostService;
use App\Domain\UserService;
use App\Domain\VOs\DisplayNameVo;
use App\Domain\VOs\EmailVo;
use App\Domain\VOs\PasswordVo;
use Firebase\JWT\JWT;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Swaggest\JsonSchema\Schema;

class PostController
{

    protected PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws \Exception
     */
    public function save(Request $request, Response $response, $args)
    {
        $requestBody = $request->getParsedBody();

        RequiredFieldsValidator::validate(
            ['title', 'content'],
            $requestBody
        );

        $postCreated = $this->service->save(new CreatePostDTO(
            $requestBody['title'],
            $requestBody['content']
        ), (int) $requestBody['userId']);

        $response->getBody()->write(json_encode($postCreated->toArray()));
        return $response->withStatus(ResponseCode::HTTP_CREATED);
    }

    public function findAll(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode($this->service->findAll()));
        return $response->withStatus(ResponseCode::HTTP_OK);
    }

    public function findOne(Request $request, Response $response, $args)
    {
        $response->getBody()->write(json_encode($this->service->findById($args['id'])));
        return $response->withStatus(ResponseCode::HTTP_OK);
    }

    public function deleteUser(Request $request, Response $response, $args)
    {
        $requestBody = $request->getParsedBody();

        $this->service->deleteUser(new EmailVo($requestBody['userEmail']));
        return $response->withStatus(ResponseCode::HTTP_NO_CONTENT);
    }
}
