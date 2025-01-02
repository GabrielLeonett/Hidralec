<?php

namespace app\controller;

use app\controller\productosController;

class cookiesController extends productosController{

    public function cookieCompra() {
        if (isset($_COOKIE['La_Compra'])) {
            $cookie_vieja = json_decode($_COOKIE['La_Compra'], true); // Decodificar JSON
            $cookie_nueva = [
                "Orden" => [],
                "Monto" => 0
            ];

            if (isset($cookie_vieja['Orden']) && is_array($cookie_vieja['Orden'])) {
                foreach ($cookie_vieja['Orden'] as $producto) {
                    $productoBD = $this->unSoloProducto($producto['N_boton']);
                    if ($productoBD) {
                        if ($productoBD['Stock'] >= $producto['cantidad']) {
                            $Vector = [
                                "Nombre" => $productoBD['Nombre_Productos'],
                                "N_boton" => $productoBD['ID_Productos'],
                                "Precio" => $productoBD['Precio'],
                                "cantidad" => $producto['cantidad']
                            ];

                            if ($productoBD['Precio'] != $producto['Precio']) {
                                $Vector['Precio'] = $productoBD['Precio'];
                                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                                echo '<script>
                                    Swal.fire({
                                        icon: "error",
                                        title: "Opps ocurrio un error",
                                        text: "Hubo un cambio en un precio del producto '.$productoBD['Nombre_Productos'].'",
                                        confirmButtonText: "Aceptar"
                                    })
                                </script>';
                            }

                            array_push($cookie_nueva['Orden'], $Vector);
                            $cookie_nueva['Monto'] += $producto['cantidad'] * $productoBD['Precio'];
                        } else {
                            array_push($cookie_nueva['Orden'], [
                                "Nombre" => $productoBD['Nombre_Productos'],
                                "N_boton" => $productoBD['ID_Productos'],
                                "Precio" => $productoBD['Precio'],
                                "cantidad" => $productoBD['Stock']
                            ]);
                            $cookie_nueva['Monto'] += $productoBD['Stock'] * $productoBD['Precio'];
                        }
                    }
                }
            }

            // Actualizar la cookie con la nueva información
            setcookie('La_Compra', json_encode($cookie_nueva), time() + (60 * 60 * 24 * 7), "/");
        }
    }
}