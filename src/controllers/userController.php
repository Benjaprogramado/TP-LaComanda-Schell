<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;
use App\models\User;
use Throwable;

// error_reporting(0);

class UserController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = User::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = User::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $User = new User;
        if (!$parsedBody["nombre"] || !$parsedBody["clave"] || !$parsedBody["tipo"]) {
            $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
        } else {
            $User->nombre = $parsedBody["nombre"];
            $User->clave = $parsedBody["clave"];

            if (
                $parsedBody["tipo"] != "bartender" && $parsedBody["tipo"] != "cocineros"
                && $parsedBody["tipo"] != "cerveceros" && $parsedBody["tipo"] != "mozos" && $parsedBody["tipo"] != "socios"
            ) {
                $response->getBody()->write("EL TIPO INGRESADO ES INCORRECTO, ACCIÓN CANCELADA");
            } else {
                $User->tipo = $parsedBody["tipo"];
                $User->save();
                $response->getBody()->write("USUARIO CARGADO CON ÉXITO!!");
            }
        }
        return $response;
    }


    public function login(Request $request, Response $response)
    {
        $nombre = $request->getParsedBody()['nombre'];
        $clave = $request->getParsedBody()['clave'];

        $token = self::generarToken($clave, $nombre);

        if ($token != false) {
            $response->getBody()->write("Token generado con éxito!!\n" . json_encode($token));
        } else {
            $response->getBody()->write("\nError al generar token, datos inválidos");
        }
        return $response;
    }


    public function updateOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $User = User::find($args['id']);

        if ($User != null) {
            if (!$parsedBody["nombre"] || !$parsedBody["clave"] || !$parsedBody["tipo"]) {
                $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
            } else {
                $User->nombre = $parsedBody["nombre"];
                $User->clave = $parsedBody["clave"];

                if (
                    $parsedBody["tipo"] != "bartender" && $parsedBody["tipo"] != "cocineros"
                    && $parsedBody["tipo"] != "cerveceros" && $parsedBody["tipo"] != "mozos" && $parsedBody["tipo"] != "socios"
                ) {
                    $response->getBody()->write("EL TIPO INGRESADO ES INCORRECTO, ACCIÓN CANCELADA");
                } else {
                    $User->tipo = $parsedBody["tipo"];
                    $User->save();
                    $response->getBody()->write("USUARIO MODIFICADO CON ÉXITO!!");
                }
            }
        } else {
            $response->getBody()->write("USUARIO NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public function deleteOne(Request $request, Response $response, $args)
    {
        $User = User::find($args['id']);

        if ($User != null) {
            $User->delete();
            $response->getBody()->write("USUARIO BORRADO CON ÉXITO!!");
        } else {
            $response->getBody()->write("USUARIO NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }

    //MANEJO DE TOKEN PARA VERIFICACIÓN

    public static function generarToken($clave, $nombre)
    {

        $usuario = User::where('clave', $clave)->where('nombre', $nombre)->first();
        $payload = array();

        $token = false;
        if ($usuario != null) {
            $payload = array(
                "nombre" => $nombre,
                "clave" => $clave,
                "id" => $usuario->id,
                "tipo" => $usuario->tipo
            );
            $token = JWT::encode($payload, 'tpcomanda');
        } else {
            echo "Usuario no registrado!!";
        }
        return $token;
    }


    public static function verificarPermisos($token, $tipo)
    {
        $retorno = false;
        try {
            $payload = JWT::decode($token, "tpcomanda", array('HS256'));

            foreach ($payload as $value) {
                if ($value == $tipo) {

                    $retorno = true;
                }
            }
        } catch (\Throwable $th) {
            echo 'Excepcion:' . $th->getMessage();
        }
        return $retorno;
    }


    public static function ObtenerIdToken($token)
    {
        try {
            $payload = JWT::decode($token, "tpcomanda", array('HS256'));

            foreach ($payload as $key => $value) {
                if ($key == 'id') {

                    return $value;
                }
            }
        } catch (\Throwable $th) {
            echo 'Excepcion:' . $th->getMessage();
        }
    }


    public static function ObtenerTipoToken($token)
    {
        try {
            $payload = JWT::decode($token, "tpcomanda", array('HS256'));
            foreach ($payload as $key => $value) {
                if ($key == 'tipo') {
                    return $value;
                }
            }
        } catch (\Throwable $th) {
            echo 'Excepcion:' . $th->getMessage();
        }
    }
}
