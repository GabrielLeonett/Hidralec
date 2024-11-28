<?php

namespace app\controller;

use app\controller\productosController;

class pedidosController extends productosController {
    #Funcion que registra el pedido de un cliente con el cookies y demas datos de la compra
    public function registrarPedido() {
        if (isset($_COOKIE['La_Compra']) && !empty($_COOKIE['La_Compra'])) {
            $cookie = json_decode($_COOKIE['La_Compra'], true);
            
            try {
                $fecha = date("Y-m-d H:i:s");
    
                // Generar una clave única para la venta
                $ID_venta = $this->generarClaveUnica();
    
                // Paso 1: Insertar en ventas 
                $datos_venta = [
                    ["campos_nombre" => "ID_Ventas", "campos_marcador" => ":ID_ventas", "campos_valor" => $ID_venta],
                    ["campos_nombre" => "Fecha", "campos_marcador" => ":fecha", "campos_valor" => $fecha],
                    ["campos_nombre" => "Monto_total", "campos_marcador" => ":total_monto", "campos_valor" => $cookie['Monto']],
                    ["campos_nombre" => "ID_Usuario", "campos_marcador" => ":ID_usuario", "campos_valor" => $_SESSION['ID']],
                    ["campos_nombre" => "ID_Estado_Venta", "campos_marcador" => ":ID_Estado_Venta", "campos_valor" => 1]
                ];
                $this->guardarDatos('ventas', $datos_venta);
    
                // Paso 2: Insertar en detalle_venta
                foreach ($cookie['Orden'] as $producto) {
                    $ID_Detalle = $this->generarClaveUnica();
                    $datos_detalle = [
                        ["campos_nombre" => "ID_Detalles_Venta", "campos_marcador" => ":ID_dtll_venta", "campos_valor" => $ID_Detalle],
                        ["campos_nombre" => "ID_Productos", "campos_marcador" => ":ID_producto", "campos_valor" => $producto['N_boton']],
                        ["campos_nombre" => "ID_Ventas", "campos_marcador" => ":ID_venta", "campos_valor" => $ID_venta],
                        ["campos_nombre" => "Precio_Unitario", "campos_marcador" => ":Precio_unitario", "campos_valor" => $producto['Precio']],
                        ["campos_nombre" => "Cantidad", "campos_marcador" => ":cantidad", "campos_valor" => $producto['cantidad']]
                    ];
                    $this->guardarDatos('detalles_ventas', $datos_detalle);
                }

                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Perfecto",
                        text: "Su compra se ha realizado el Codigo de su compra es '.$ID_venta.'",
                        confirmButtonText: "Aceptar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "home";
                        }
                    });
                </script>';
            } catch (Exception $e) {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "No pudimos procesar su compra",
                        confirmButtonText: "Aceptar"
                    })
                </script>';
            }
        } else {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                Swal.fire({
                    icon: "warning",
                    title: "Advertencia",
                    text: "No hay datos de compra",
                    confirmButtonText: "Aceptar"
                });
            </script>';
        }
    }

    #Funcion para traer todos los pedidos que se hayan hecho.
    public function seleccionarTodosPedidos() {
        $datos = [
            "campos" => ["ID_Ventas"] // Lista de campos a seleccionar
        ];
        
        $tabla = $this->seleccionarDatos('ventas', $datos);
        $tabla = $tabla->fetchAll(\PDO::FETCH_ASSOC);
        $Mostrar = "";
        
        foreach ($tabla as $ID) {
            $tablas = [
                [
                    "Nombre_tabla" => "usuario",
                    "Campos" => ["Nombre_Usuario"]
                ],
                [
                    "Nombre_tabla" => "ventas",
                    "Campos" => ["Monto_total", "Fecha", "ID_Ventas"],
                    "Parametros_viculantes" => [["usuario", "ID_Usuario"]],
                    "Condicion" => [
                        "Condicion_tipo" => "nada",
                        "Condicion_nombre" => "ID_Ventas",
                        "Condicion_marcador" => "ID_venta",
                        "Condicion_valor" => $ID['ID_Ventas']
                    ]
                ],
                [
                    "Nombre_tabla" => "detalles_ventas",
                    "Campos" => ["Precio_Unitario", "Cantidad", "ID_Productos", "ID_Ventas"],
                    "Parametros_viculantes" => [["ventas", "ID_Ventas"]]
                ],
                [
                    "Nombre_tabla" => "productos",
                    "Campos" => ["Nombre_Productos", "Precio"],
                    "Parametros_viculantes" => [["detalles_ventas", "ID_Productos"]]
                ],
                [
                    "Nombre_tabla" => "estado_venta",
                    "Campos" => ["Estado"],
                    "Parametros_viculantes" => [["ventas", "ID_Estado_Venta"]],
                    "Condicion" => [
                        "Condicion_tipo" => "nada",
                        "Condicion_nombre" => "ID_Estado_Venta",
                        "Condicion_marcador" => "ID_est_venta",
                        "Condicion_valor" => 1
                    ]
                ]
            ];
    
            $pedidos = $this->innerJoinTablas($tablas);
            
            if (isset($pedidos) && !empty($pedidos)) {
                $fechaCompleta = new \DateTime($pedidos[0]['Fecha']);
                $fecha = $fechaCompleta->format('Y-m-d');
                $hora = $fechaCompleta->format('H:i');
    
                $Mostrar .= '
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Venta: ' . htmlspecialchars($pedidos[0]['ID_Ventas']) . '</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Cliente: ' . htmlspecialchars($pedidos[0]['Nombre_Usuario']) . '</h6>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Monto: ' . htmlspecialchars($pedidos[0]['Monto_total']) . '</h6>
                            <h6 class="card-subtitle mb-2 text-body-secondary">Fecha: ' . htmlspecialchars($fecha) . ' hora: ' . htmlspecialchars($hora) . '</h6>
                            <p class="card-text">
                                <ul class="list-group list-group-flush">';
    
                foreach ($pedidos as $pedidoProducto) {
                    $Mostrar .= '<li class="list-group-item">' . htmlspecialchars($pedidoProducto['Nombre_Productos']) . ' Cantidad: ' . htmlspecialchars($pedidoProducto['Cantidad']) . '  Precio: ' . htmlspecialchars($pedidoProducto['Precio']) . '</li>';
                }
    
                $Mostrar .= '
                                </ul>
                            </p>
                            <button type="button" class="btn btn-outline-secondary" data-id="' . htmlspecialchars($pedidos[0]['ID_Ventas']) . '" onclick="Eliminar_pedido(this)">Cancelar</button>
                            <button type="button" class="btn btn-warning aprobar" data-id="' . htmlspecialchars($pedidos[0]['ID_Ventas']) . '" onclick="Aceptar_pedido(this)">Aprobar</button>
                        </div>
                    </div>';
            }
        }
    
        if (empty($Mostrar)) {
            $Mostrar = '<div>No hay ninguna venta en estado: Pendiente</div>';
        }
        
        echo $Mostrar;
    }
    
    
    #Funcion para aceptar el pedido y hacer la venta por parte del admin
    public function aceptarPedido() {
        if (isset($_POST['ID_Venta']) && !empty($_POST['ID_Venta'])) {
            $ID_Venta = $_POST['ID_Venta'];
            $datos = [
                "campos" => ["ID_productos", "Cantidad"],
                "modo" => [
                    "campos_nombre" => "ID_Ventas",
                    "campos_marcador" => "ID_ventas",
                    "campos_valor" => $ID_Venta
                ]
            ];
    
            $respuesta = $this->seleccionarDatos('detalles_ventas', $datos);
            $respuesta = $respuesta->fetchAll(\PDO::FETCH_ASSOC);
    
            $contador = 0;
            $i = 0;
    
            foreach ($respuesta as $ID_producto) {
                $datos = [
                    "campos" => ["*"],
                    "modo" => [
                        "campos_nombre" => "ID_Productos",
                        "campos_marcador" => "ID_producto",
                        "campos_valor" => $ID_producto['ID_productos']
                    ]
                ];
                $producto = $this->seleccionarDatos('productos', $datos);
                $producto = $producto->fetch(\PDO::FETCH_ASSOC);
    
                if ($producto['Stock'] >= $ID_producto['Cantidad']) {
                    $Nuevo_Stock = $producto['Stock'] - $ID_producto['Cantidad'];
                    $dato = [
                        [
                            "campos_nombre" => "Stock",
                            "campos_marcador" => "new_stock",
                            "campos_valor" => $Nuevo_Stock
                        ]
                    ];
                    $id = [
                        "Campo" => "ID_Productos",
                        "Valor" => $producto['ID_Productos']
                    ];
                    $verificacion = $this->modificarDatos('productos', $dato, $id);
                    if ($verificacion->rowCount() > 0) {
                        $contador++;
                    }
                }
                $i++;
            }
    
            if ($contador == $i) {
                $dato = [
                    [
                        "campos_nombre" => "ID_Estado_Venta",
                        "campos_marcador" => "ID_Est_venta",
                        "campos_valor" => 3
                    ]
                ];
                $id = [
                    "Campo" => "ID_Ventas",
                    "Valor" => $ID_Venta
                ];
                $verificacion = $this->modificarDatos('ventas', $dato, $id);
                if ($verificacion->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "icono" => "success",
                        "titulo" => "Perfecto",
                        "texto" => "El Pedido ha sido Aceptado satisfactoriamente."
                    ];
                    return json_encode($alerta);
                }
            }else{
                $alerta = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps ha ocurrido un error",
                    "texto" => "Ha ocurrido un error en los productos de su venta"
                ];
                return json_encode($alerta);
            }
        } else {
            $alerta = [
                "tipo" => "simple",
                "icono" => "error",
                "titulo" => "Opps ha ocurrido un error",
                "texto" => "No hay ninguna venta con ese ID"
            ];
            return json_encode($alerta);
        }
    }
    
    #Funcion para cancelar un pedido que por el administrador
    public function cancelarPedido(){
        if(isset($_POST['ID_Venta']) && !empty($_POST['ID_Venta'])){
            $ID_Venta = $_POST['ID_Venta'];

            $datos = [
                "campos_nombre" => "ID_Ventas",
                "campos_marcador" => ":ID",
                "campos_valor" => $ID_Venta
                ];


            $respuesta = $this->eliminarDatos('detalles_ventas',$datos);
            if($respuesta->rowCount() > 0){
                $respuesta = $this->eliminarDatos('ventas',$datos);
                
                if($respuesta->rowCount() > 0){
                    $alerta = [
                        "tipo" => "simple",
                        "icono" => "success",
                        "titulo" => "Perfecto",
                        "texto" => "El Pedido $ID_Venta fue eliminado"
                    ];
                    return json_encode($alerta);
                }else{
                    $alerta = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps ha ocurrido un error",
                        "texto" => "El ID del producto no existe en la tabla venta"
                    ];
                    return json_encode($alerta);
                }

            }else{
                $alerta = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps ha ocurrido un error",
                    "texto" => "El ID del producto no existe en la tabla detalles_venta"
                ];
                return json_encode($alerta);
            }
            
        }else{
            $alerta = [
                "tipo" => "simple",
                "icono" => "success",
                "titulo" => "Opps ha ocurrido un error",
                "texto" => "No hay ninguna venta con ese ID"
            ];
            return json_encode($alerta);
        }
    }
       
}
