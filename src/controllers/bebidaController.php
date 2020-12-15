<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\models\Bebida;
use Throwable;

// error_reporting(0);

class BebidaController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = Bebida::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Bebida::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Bebida = new Bebida;
        if (!$parsedBody["nombre"] || !$parsedBody["precio"]) {
            $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
        } else if (is_nan($parsedBody["precio"])) {
            $response->getBody()->write("EL PRECIO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
        } else {
            $Bebida->precio = $parsedBody["precio"];
            $Bebida->nombre = $parsedBody["nombre"];
            $Bebida->contador = 0;
            $Bebida->save();
            $response->getBody()->write("BEBIDA CARGADA CON ÉXITO!!");
        }
        return $response;
    }


    public function updateOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Bebida = Bebida::find($args['id']);

        if ($Bebida != null) {
            if (!$parsedBody["nombre"] || !$parsedBody["precio"]) {
                $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
            } else if (is_nan($parsedBody["precio"])) {
                $response->getBody()->write("EL PRECIO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
            } else {
                $Bebida->precio = $parsedBody["precio"];
                $Bebida->nombre = $parsedBody["nombre"];
                $Bebida->contador = 0;
                $Bebida->save();
                $response->getBody()->write("BEBIDA MODIFICADA CON ÉXITO!!");
            }
        } else {
            $response->getBody()->write("BEBIDA NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public function deleteOne(Request $request, Response $response, $args)
    {
        $Bebida = Bebida::find($args['id']);
        if ($Bebida != null) {
            $Bebida->delete();
            $response->getBody()->write("BEBIDA BORRADA CON ÉXITO!!");
        } else {
            $response->getBody()->write("BEBIDA NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }

    public function contadorVentas($id)
    {
        try {
            $Bebida = Bebida::find($id);
            $Bebida->contador++;
            return true;
        } catch (Throwable $e) {
            echo "NO SE PUDO ACTUALIZAR EL CONTADOR";
            return false;
        }
    }
}
