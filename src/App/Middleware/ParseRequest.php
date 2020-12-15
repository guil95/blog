<?php

namespace App\App\Middleware;

use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class ParseRequest
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $headers = array_change_key_case($request->getHeaders(), CASE_LOWER);
        $requestBody = json_decode($request->getBody()->getContents(), 1);

        if (isset($headers['authorization'])) {
            $jwt = explode(' ', $headers['authorization'][0])[1];
            $jwtDecoded = JWT::decode($jwt, getenv('SECRET_JWT'), ["HS256", "HS512", "HS384"]);
            $requestBody['userEmail'] = $jwtDecoded->email;
            $requestBody['userId'] = $jwtDecoded->code;
        }

        return $handler->handle($request->withParsedBody($requestBody));
    }
}
