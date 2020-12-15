<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\models\Comida;
use Throwable;

// error_reporting(0);

class ComidaController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = Comida::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Comida::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Comida = new Comida;
        if (!$parsedBody["nombre"] || !$parsedBody["precio"]) {
            $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
        } else if (is_nan($parsedBody["precio"])) {
            $response->getBody()->write("EL PRECIO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
        } else {
            $Comida->precio = $parsedBody["precio"];
            $Comida->nombre = $parsedBody["nombre"];
            $Comida->contador = 0;
            $Comida->save();
            $response->getBody()->write("Comida CARGADA CON ÉXITO!!");
        }
        return $response;
    }


    public function updateOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Comida = Comida::find($args['id']);

        if ($Comida != null) {
            if (!$parsedBody["nombre"] || !$parsedBody["precio"]) {
                $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
            } else if (is_nan($parsedBody["precio"])) {
                $response->getBody()->write("EL PRECIO DEBE SER NUMÉRICO, ACCIÓN CANCELADA");
            } else {
                $Comida->precio = $parsedBody["precio"];
                $Comida->nombre = $parsedBody["nombre"];
                $Comida->contador = 0;
                $Comida->save();
                $response->getBody()->write("Comida MODIFICADA CON ÉXITO!!");
            }
        } else {
            $response->getBody()->write("Comida NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public function deleteOne(Request $request, Response $response, $args)
    {
        $Comida = Comida::find($args['id']);

        if ($Comida != null) {
            $Comida->delete();
            $response->getBody()->write("COMIDA BORRADA CON ÉXITO!!");
        } else {
            $response->getBody()->write("COMIDA NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }

    public function contadorVentas($id)
    {
        try {
            $Comida = Comida::find($id);
            $Comida->contador++;
            return true;
        } catch (Throwable $e) {
            echo "NO SE PUDO ACTUALIZAR EL CONTADOR";
            return false;
        }
    }
}
