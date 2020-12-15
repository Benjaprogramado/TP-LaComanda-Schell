<?php

date_default_timezone_set("America/Argentina/Buenos_Aires");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Config\Database;

use App\Controllers\UserController;
use App\Controllers\BebidaController;
use App\Controllers\CervezaController;
use App\Controllers\ComidaController;
use App\Controllers\MesaController;
use App\Controllers\PedidoController;
use App\Controllers\EncuestaController;

use App\Middlewares\JsonMiddleware;
use App\Middlewares\SociosMiddleware;
use App\Middlewares\SociosMozosMiddleware;
use App\Middlewares\CambiarEstadoMiddleware;
use App\Middlewares\MozosMiddleware;



require __DIR__ . '/../vendor/autoload.php';

$conn = new Database;
$app = AppFactory::create();
$app->setBasePath("/TrabajoEnClases/TP-LaComanda-Schell/public");

$app->add(new JsonMiddleware);


$app->post('/login[/]', UserController::class . ":login");
$app->group('/users', function (RouteCollectorProxy $group) {
    $group->get('[/]', UserController::class . ":getAll");
    $group->get('/{id}', UserController::class . ":getOne");
    $group->post('[/]', UserController::class . ":addOne");
    $group->put('/{id}', UserController::class . ":updateOne");
    $group->delete('/{id}', UserController::class . ":deleteOne");
})->add(new SociosMiddleware);
$app->group('/bebidas', function (RouteCollectorProxy $group) {
    $group->get('[/]', BebidaController::class . ":getAll");
    $group->get('/{id}', BebidaController::class . ":getOne");
    $group->post('[/]', BebidaController::class . ":addOne");
    $group->put('/{id}', BebidaController::class . ":updateOne");
    $group->delete('/{id}', BebidaController::class . ":deleteOne");
})->add(new SociosMiddleware);
$app->group('/cervezas', function (RouteCollectorProxy $group) {
    $group->get('[/]', CervezaController::class . ":getAll");
    $group->get('/{id}', CervezaController::class . ":getOne");
    $group->post('[/]', CervezaController::class . ":addOne");
    $group->put('/{id}', CervezaController::class . ":updateOne");
    $group->delete('/{id}', CervezaController::class . ":deleteOne");
})->add(new SociosMiddleware);
$app->group('/comidas', function (RouteCollectorProxy $group) {
    $group->get('[/]', ComidaController::class . ":getAll");
    $group->get('/{id}', ComidaController::class . ":getOne");
    $group->post('[/]', ComidaController::class . ":addOne");
    $group->put('/{id}', ComidaController::class . ":updateOne");
    $group->delete('/{id}', ComidaController::class . ":deleteOne");
})->add(new SociosMiddleware);
$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->post('[/]', MesaController::class . ":addOne")->add(new SociosMiddleware);
    $group->get('/{codigo}', MesaController::class . ":verEstado")->add(new SociosMiddleware);
    $group->put('/nuevoEstado', MesaController::class . ":cambiarEstado")->add(new SociosMozosMiddleware);
    $group->put('/cerrar', MesaController::class . ":cerrarMesa")->add(new SociosMiddleware);
});
$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->post('[/]', PedidoController::class . ":addOne")->add(new mozosMiddleware);
    $group->get('/verEstados', PedidoController::class . ":verEstado")->add(new SociosMiddleware);
    $group->put('/nuevoEstado', PedidoController::class . ":cambiarEstado")->add(new cambiarEstadoMiddleware);
    $group->put('/cancelar', PedidoController::class . ":cancelarPedido")->add(new SociosMiddleware);
});
$app->group('/clientes', function (RouteCollectorProxy $group) {
    $group->get('/{cod_pedido}', PedidoController::class . ":verTiempoRestante");
    $group->post('/encuesta', EncuestaController::class . ":addOne");
    // $group->put('/nuevoEstado', PedidoController::class . ":cambiarEstado")->add(new cambiarEstadoMiddleware);
    // $group->put('/cancelar', PedidoController::class . ":cancelarPedido")->add(new SociosMiddleware);
});

$app->addBodyParsingMiddleware();

$app->run();
