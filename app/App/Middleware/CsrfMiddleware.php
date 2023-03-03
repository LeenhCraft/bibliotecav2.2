<?php
namespace App\Middleware;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class CsrfMiddleware implements MiddlewareInterface
{
    private $csrf;

    public function __construct(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $method = $request->getMethod();
        if ($method !== 'GET' && $method !== 'HEAD' && $method !== 'OPTIONS') {
            $token = $request->getHeaderLine('X-CSRF-Token') ?: $request->getParsedBody()['csrf_token'] ?? '';
            if (!$this->csrf->validateToken($token)) {
                $response = new Response();
                $response->getBody()->write('Invalid CSRF token');
                return $response->withStatus(403);
            }
        }

        return $handler->handle($request);
    }
}
