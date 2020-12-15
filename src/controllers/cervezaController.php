<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\models\Cerveza;
use Throwable;

// error_reporting(0);

class CervezaController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = Cerveza::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Cerveza::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Cerveza = new Cerveza;
        if (!$parsedBody["nombre"] || !$parsedBody["precio"]) {
            $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
        } else if (is_nan($parsedBody["precio"])) {
            $response->getBody()->write("EL PRECIO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
        } else {
            $Cerveza->precio = $parsedBody["precio"];
            $Cerveza->nombre = $parsedBody["nombre"];
            $Cerveza->contador = 0;
            $Cerveza->save();
            $response->getBody()->write("Cerveza CARGADA CON ÉXITO!!");
        }
        return $response;
    }


    public function updateOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Cerveza = Cerveza::find($args['id']);

        if ($Cerveza != null) {
            if (!$parsedBody["nombre"] || !$parsedBody["precio"]) {
                $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
            } else if (is_nan($parsedBody["precio"])) {
                $response->getBody()->write("EL PRECIO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
            } else {
                $Cerveza->precio = $parsedBody["precio"];
                $Cerveza->nombre = $parsedBody["nombre"];
                $Cerveza->contador = 0;
                $Cerveza->save();
                $response->getBody()->write("Cerveza MODIFICADA CON ÉXITO!!");
            }
        } else {
            $response->getBody()->write("Cerveza NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public function deleteOne(Request $request, Response $response, $args)
    {
        $Cerveza = Cerveza::find($args['id']);

        if ($Cerveza != null) {
            $Cerveza->delete();
            $response->getBody()->write("CERVEZA BORRADA CON ÉXITO!!");
        } else {
            $response->getBody()->write("CERVEZA NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }

    public function contadorVentas($id)
    {
        try {
            $Cerveza = Cerveza::find($id);
            $Cerveza->contador++;
            return true;
        } catch (Throwable $e) {
            echo "NO SE PUDO ACTUALIZAR EL CONTADOR";
            return false;
        }
    }
}
