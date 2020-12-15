<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;
use App\models\Pedido;
use App\models\Bebida;
use App\models\Cerveza;
use App\models\Comida;
use App\models\Mesa;

use App\Controllers\UserController;
use App\Controllers\BebidaController;
use App\Controllers\CervezaController;
use App\Controllers\ComidaController;
use App\Controllers\MesaController;
use App\models\User;
use Throwable;

error_reporting(0);

class PedidoController
{
    public function getAll(Request $request, Response $response, $args)
    {
        $rta = Pedido::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function getOne(Request $request, Response $response, $args)
    {
        $rta = Pedido::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }


    public function addOne(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();

        $Pedido = new Pedido;
        $token = getallheaders()['token'];

        $codigoMesa = self::asignarMesa();
        if ($codigoMesa != null) {

            $Pedido->cod_mesa = $codigoMesa;

            if ($parsedBody["cod_bebida"]) {
                $Bebida = Bebida::find($parsedBody["cod_bebida"]);
                if ($Bebida != null) {
                    $Pedido->cod_bebida = $parsedBody["cod_bebida"];
                    $Bebida->contador++;
                    $Bebida->save();
                } else {
                    $response->getBody()->write("BEBIDA NO EXISTE, ITEM DESCARTADO\n\n!!");
                }
            }
            if ($parsedBody["cod_cerveza"]) {
                $Cerveza = Cerveza::find($parsedBody["cod_cerveza"]);
                if ($Cerveza != null) {
                    $Pedido->cod_cerveza = $parsedBody["cod_cerveza"];
                    $Cerveza->contador++;
                    $Cerveza->save();
                } else {
                    $response->getBody()->write("CERVEZA NO EXISTE, ITEM DESCARTADO\n\n!!");
                }
            }
            if ($parsedBody["cod_comida"]) {
                $Comida = Comida::find($parsedBody["cod_comida"]);
                if ($Comida != null) {
                    $Pedido->cod_comida = $parsedBody["cod_comida"];
                    $Comida->contador++;
                    $Comida->save();
                } else {
                    $response->getBody()->write("COMIDA NO EXISTE, ITEM DESCARTADO\n\n!!");
                }
            }
            $Pedido->nombre_cliente = $parsedBody["nombre_cliente"];
            $Pedido->codigo = self::asignarID();
            $Pedido->estado = 1;
            $Pedido->tiempo_estimado = rand(10, 50);
            $Pedido->tiempo_restante = $Pedido->tiempo_estimado;
            $Pedido->tiempo_entrega = rand(10, 60);
            $Pedido->costo = self::asignarCosto($parsedBody["cod_bebida"], $parsedBody["cod_cerveza"], $parsedBody["cod_comida"]);
            $Pedido->id_usuario = UserController::ObtenerIdToken($token);
            $Usuario = User::find($Pedido->id_usuario);
            $Usuario->contador++;
            $Usuario->save();
            $Pedido->save();
            $response->getBody()->write("PEDIDO INGRESADO CON EXITO!!\n\nEl codigo de su pedido es: " . $Pedido->codigo);
        } else {
            $response->getBody()->write("NO HAY MESAS DISPONIBLES EN ESTE MOMENTO!!");
        }

        return $response;
    }

    public function cambiarEstado(Request $request, Response $response, $args)
    {

        $parsedBody = $request->getParsedBody();
        $Pedido = Pedido::firstWhere('codigo', $parsedBody["codigo"]);
        $token = getallheaders()['token'];
        $idPreparador = UserController::ObtenerIdToken($token);

        if ($Pedido != null) {
            if ($Pedido->estado == 4) {
                $response->getBody()->write("ESTE PEDIDO HA SIDO CANCELADO!!");
            } else if ($Pedido->estado < 3) {
                $Pedido->estado++;
                $Pedido->save();
                $Usuario = User::find($idPreparador);
                $Usuario->contador++;
                $Usuario->save();
                $response->getBody()->write("SE CAMBIO EL ESTADO DEL PEDIDO!!");
                if ($Pedido->estado == 3) {
                    $Pedido->tiempo_restante = 0;
                    $Pedido->save();
                }
            } else {
                $response->getBody()->write("ESTE PEDIDO YA FUE PREPARADO Y ESTA LISTO PARA SERVIR!!");
            }
        } else {
            $response->getBody()->write("Pedido NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }

    public function cancelarPedido(Request $request, Response $response, $args)
    {

        $parsedBody = $request->getParsedBody();
        $Pedido = Pedido::firstWhere('codigo', $parsedBody["codigo"]);

        if ($Pedido != null) {
            $Pedido->estado = 4;
            $Pedido->save();
            $response->getBody()->write("PEDIDO CANCELADO CON ÉXITO!!");
        } else {
            $response->getBody()->write("PEDIDO NO EXISTE, ACCIÓN CANCELADA");
        }
        return $response;
    }


    public static function asignarMesa()
    {
        $Mesa = Mesa::firstWhere('estado', 4);
        if ($Mesa != null) {
            $Mesa->estado = 1;
            $Mesa->contador++;
            $Mesa->save();
            return $Mesa->codigo;
        } else {
            return null;
        }
    }

    public static function asignarID()
    {
        $permitted_chars = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
        return "P-" . substr(str_shuffle($permitted_chars), 0, 5);
    }

    public static function asignarCosto($cod_bebida, $cod_cerveza, $cod_comida)
    {
        $Costo = 0;
        if ($cod_bebida != null) {
            $Bebida = Bebida::find($cod_bebida);
            $Costo += $Bebida->precio;
        }
        if ($cod_cerveza != null) {
            $Cerveza = Cerveza::find($cod_cerveza);
            $Costo += $Cerveza->precio;
        }
        if ($cod_comida != null) {
            $Comida = Comida::find($cod_comida);
            $Costo += $Comida->precio;
        }
        return $Costo;
    }

    public function verEstado(Request $request, Response $response, $args)
    {

        $Pedidos = Pedido::get();

        if ($Pedidos != null) {
            foreach ($Pedidos as $value) {
                switch ($value->estado) {
                    case 1:
                        echo ("\nCodigo: " . $value->codigo . "\nEstado: Pedido nuevo...\n");

                        break;
                    case 2:
                        echo ("\nCodigo: " . $value->codigo . "\nEstado: En preparación...\n");

                        break;
                    case 3:
                        echo ("\nCodigo: " . $value->codigo . "\nEstado: Listo para servir...\n");

                        break;
                    case 4:
                        echo ("\nCodigo: " . $value->codigo . "\nEstado: Cancelado\n");

                        break;
                    default:
                        # code...
                        break;
                }
            }
            $response->getBody()->write("\nFin lista de pedidos");
        } else {
            $response->getBody()->write("No hay pedidos en curso");
        }
        return $response;
    }

    public function verTiempoRestante(Request $request, Response $response, $args)
    {
        $parsedBody = $request->getParsedBody();
        $Pedido = Pedido::firstWhere('codigo', $args["cod_pedido"]);

        if ($Pedido != null) {
            $restante = $Pedido->tiempo_restante;
            $response->getBody()->write("\nSU PEDIDO ESTARA LISTO EN: " . $restante . "minutos.");
        } else {
            $response->getBody()->write("EL CODIGO DE PEDIDO INGRESADO ES ERRONEO");
        }
        return $response;
    }





    // public function updateOne(Request $request, Response $response, $args)
    // {
    //     $parsedBody = $request->getParsedBody();

    //     $Pedido = Pedido::find($args['id']);

    //     if ($Pedido != null) {
    //         if (!$parsedBody["cod_bebida"] || !$parsedBody["cod_cerveza"] || !$parsedBody["cod_comida"]) {
    //             $response->getBody()->write("FALTAN DATOS DE INGRESO, ACCIÓN CANCELADA");
    //         } else {
    //             $Pedido->cod_bebida = $parsedBody["cod_bebida"];
    //             $Pedido->cod_cerveza = $parsedBody["cod_cerveza"];

    //             if (
    //                 $parsedBody["cod_comida"] != "bartender" && $parsedBody["cod_comida"] != "cocineros"
    //                 && $parsedBody["cod_comida"] != "cerveceros" && $parsedBody["cod_comida"] != "mozos" && $parsedBody["cod_comida"] != "socios"
    //             ) {
    //                 $response->getBody()->write("EL cod_comida INGRESADO ES INCORRECTO, ACCIÓN CANCELADA");
    //             } else {
    //                 $Pedido->cod_comida = $parsedBody["cod_comida"];
    //                 $Pedido->save();
    //                 $response->getBody()->write("USUARIO MODIFICADO CON ÉXITO!!");
    //             }
    //         }
    //     } else {
    //         $response->getBody()->write("USUARIO NO EXISTE, ACCIÓN CANCELADA");
    //     }
    //     return $response;
    // }


    // public function deleteOne(Request $request, Response $response, $args)
    // {
    //     $Pedido = Pedido::find($args['id']);

    //     if ($Pedido != null) {
    //         $Pedido->delete();
    //         $response->getBody()->write("USUARIO BORRADO CON ÉXITO!!");
    //     } else {
    //         $response->getBody()->write("USUARIO NO EXISTE, ACCIÓN CANCELADA");
    //     }
    //     return $response;
    // }
}
