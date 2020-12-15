<?php

namespace App\App\Middleware;

use App\App\Infra\DAO\UserDAO;
use App\App\Infra\Repositories\User\PostRepository;
use App\App\Infra\ResponseCode;
use App\Domain\AuthService;
use App\Domain\DTOs\AuthUserDTO;
use App\Domain\UserService;
use App\Domain\VOs\EmailVo;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class UserExists
{
    private ContainerInterface $container;

    /**
     * ValidMerchant constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, RequestHandler $handler) {
        try {
            $headers = array_change_key_case($request->getHeaders(), CASE_LOWER);

            if (!isset($headers['authorization'])) {
                return $this->responseUnauthorized();
            }

            $jwt = explode(' ', $headers['authorization'][0])[1];
            $jwtDecoded = JWT::decode($jwt, getenv('SECRET_JWT'), ["HS256", "HS512", "HS384"]);

            /**
             * @var UserService
             */
            $userService = $this->container->get(UserService::class);
            $userService->findUserByEmail(new EmailVo($jwtDecoded->email));

            return $handler->handle($request);
        }catch (\Exception $exception) {
            return $this->responseUnauthorized();
        }
    }

    private function responseUnauthorized(): Response
    {
        $response = new Response();
        return $response->withStatus(ResponseCode::HTTP_UNAUTHORIZED);
    }
}
