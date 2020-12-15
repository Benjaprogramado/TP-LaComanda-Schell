<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;
use App\models\Encuesta;
use App\models\Pedido;
use App\models\Mesa;
use Throwable;

error_reporting(0);

class EncuestaController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = Encuesta::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Encuesta::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Encuesta = new Encuesta;
        if (
            !$parsedBody["cod_pedido"] || !$parsedBody["puntaje_mesa"] || !$parsedBody["puntaje_restaurante"]
            || !$parsedBody["puntaje_mozo"] || !$parsedBody["puntaje_cocinero"] || !$parsedBody["comentario"]
        ) {
            $response->getBody()->write("POR FAVOR LLENE TODOS LOS CAMPOS DE LA ENCUESTA, ACCIÓN CANCELADA");
        } else {
            $Pedido = Pedido::find($parsedBody["cod_pedido"]);
            $Mesa = Mesa::find($Pedido->cod_mesa);
            if ($Mesa->estado != 4) {
                $Encuesta->puntaje = self::calcularPuntaje(
                    $parsedBody["puntaje_mesa"],
                    $parsedBody["puntaje_restaurante"],
                    $parsedBody["puntaje_mozo"],
                    $parsedBody["puntaje_cocinero"]
                );
                $Encuesta->cod_pedido = $parsedBody["cod_pedido"];
                $Encuesta->comentario = $parsedBody["comentario"];
                $Encuesta->save();
                $response->getBody()->write("MUCHAS GRACIAS POR SU DEVOLUCIÓN, HASTA PRONTO");
            } else {
                $response->getBody()->write("LA ENCUESTA SE HABILITARÁ UNA VEZ QUE CIERREN LA MESA");
            }
        }
        return $response;
    }

    public static function calcularPuntaje($mesa, $restaurante, $mozo, $cocinero)
    {
        $puntaje = 0;
        $puntaje += $mesa;
        $puntaje += $restaurante;
        $puntaje += $mozo;
        $puntaje += $cocinero;
        return $puntaje;
    }
}
