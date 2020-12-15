<?php

namespace App\App\Middleware;

use App\App\Infra\ResponseCode;
use App\Domain\DomainBlogException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class NormalizeErrorsResponses
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        try {
            return $handler->handle($request);
        } catch (DomainBlogException $blogException) {
            return $this->sendErrorResponse(
                $blogException->getMessage(),
                $blogException->getCode() != 0
                    ? $blogException->getCode()
                    : ResponseCode::HTTP_BAD_REQUEST
            );
        } catch (\Exception $exception) {
            die("<pre>" . __FILE__ . " - " . __LINE__ . "\n" . print_r($exception->getMessage(), true) . "</pre>");
            return $this->sendErrorResponse(
                'Internal Error',
                ResponseCode::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function sendErrorResponse(
        string $message,
        int $statusCode
    ): Response {
        $response = new Response();
        $response->getBody()->write(json_encode([
            'message' => $message
        ]));
        return $response->withStatus($statusCode);
    }
}
