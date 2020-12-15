<?php

namespace App\Middlewares;

//use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Controllers\UserController;
//use \Firebase\JWT\JWT;


class SociosMozosMiddleware
{

    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        $token = $request->getHeaderLine('token');

        if (!UserController::verificarPermisos($token, 'socios') && !UserController::verificarPermisos($token, 'mozos')) {
            $response = new Response();
            $response->getBody()->write("USUARIO NO HABILITADO PARA REALIZAR ESTA ACCIÓN");

            return $response->withStatus(403);
        } else {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $resp = new Response();
            $resp->getBody()->write($existingContent);
            return $resp;
        }
    }
}
