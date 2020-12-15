<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\models\Mesa;
use Throwable;

// error_reporting(0);

class MesaController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = Mesa::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Mesa::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Mesa = new Mesa;
        if (!$parsedBody["codigo"]) {
            $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
        } else if (is_nan($parsedBody["codigo"])) {
            $response->getBody()->write("EL CODIGO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
        } else {
            $MesaRepetida = Mesa::firstWhere('codigo', $parsedBody["codigo"]);
            if ($MesaRepetida != null) {
                $response->getBody()->write("EL CODIGO DE MESA YA EXISTE, ACCIÓN CANCELADA");
            } else {
                $Mesa->codigo = $parsedBody["codigo"];
                $Mesa->estado = 4;
                $Mesa->contador = 0;
                $Mesa->save();
                $response->getBody()->write("Mesa CARGADA CON ÉXITO!!");
            }
        }
        return $response;
    }


    public function cambiarEstado(Request $request, Response $response, $args)
    {

        $parsedBody = $request->getParsedBody();
        $Mesa = Mesa::firstWhere('codigo', $parsedBody["codigo"]);

        if ($Mesa != null) {
            if ($Mesa->estado == 4) {
                $Mesa->estado = 1;
                $Mesa->save();
                $response->getBody()->write("SE CAMBIO EL ESTADO DE LA MESA!!");
            } else if ($Mesa->estado < 3) {
                $Mesa->estado++;
                $Mesa->save();
                $response->getBody()->write("SE CAMBIO EL ESTADO DE LA MESA!!");
            } else {
                $response->getBody()->write("SOLO SOCIOS PUEDEN CERRAR LAS MESAS!!");
            }
        } else {
            $response->getBody()->write("Mesa NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public function cerrarMesa(Request $request, Response $response, $args)
    {

        $parsedBody = $request->getParsedBody();
        $Mesa = Mesa::firstWhere('codigo', $parsedBody["codigo"]);

        if ($Mesa != null) {
            $Mesa->estado = 4;
            $Mesa->contador++;
            $Mesa->save();
            $response->getBody()->write("Mesa CERRADA CON ÉXITO!!");
        } else {
            $response->getBody()->write("Mesa NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }

    public function verEstado(Request $request, Response $response, $args)
    {

        $Mesa = Mesa::firstWhere('codigo', $args['codigo']);

        if ($Mesa != null) {

            switch ($Mesa->estado) {
                case 1:
                    $response->getBody()->write("Mesa con cliente esperando el pedido...");
                    break;
                case 2:
                    $response->getBody()->write("Mesa con clientes comiendo...");
                    break;
                case 3:
                    $response->getBody()->write("Mesa con clientes pagando...");
                    break;
                case 4:
                    $response->getBody()->write("Mesa CERRADA");
                    break;
                default:
                    # code...
                    break;
            }
        } else {
            $response->getBody()->write("Mesa NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public function deleteOne(Request $request, Response $response, $args)
    {
        $Mesa = Mesa::firstWhere('codigo', $args['codigo']);

        if ($Mesa != null) {
            $Mesa->delete();
            $response->getBody()->write("Mesa BORRADA CON ÉXITO!!");
        } else {
            $response->getBody()->write("Mesa NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }
}
