<?php

namespace App\App\Controllers;

use App\App\Infra\ResponseCode;
use App\App\Utils\RequiredFieldsValidator;
use App\Domain\AuthService;
use App\Domain\DTOs\AuthUserDTO;
use App\Domain\VOs\EmailVo;
use App\Domain\VOs\PasswordVo;
use Firebase\JWT\JWT;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LoginController
{
    private AuthService $service;

    /**
     * LoginController constructor.
     * @param AuthService $service
     */
    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|Response
     * @throws \App\Domain\DomainBlogException
     * @throws \Swaggest\JsonSchema\Exception
     * @throws \Swaggest\JsonSchema\InvalidValue
     */
    public function auth(Request $request, Response $response, $args)
    {
        $requestBody = $request->getParsedBody();

        RequiredFieldsValidator::validate(['email', 'password'], $requestBody);

        $token = $this->service->auth(
            new AuthUserDTO(
                new EmailVo($requestBody['email']),
                $requestBody['password']
            )
        );

        $response->getBody()->write(json_encode(['token' => $token]));
        return $response->withStatus(ResponseCode::HTTP_OK);
    }
}
