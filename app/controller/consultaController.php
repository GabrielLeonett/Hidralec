<?php

namespace app\controller;

use app\controller\productosController;

class consultaController extends productosController {

    public function mostrarConsulta() {
        // Inicializa variables con valores predeterminados
        $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
        $precio_max = isset($_POST['precio_maximo']) ? $_POST['precio_maximo'] : null;
        $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
        $precio_minimo = isset($_POST['precio_minimo']) ? $_POST['precio_minimo'] : null;
        $buscar = isset($_POST['buscar']) ? $_POST['buscar'] : null;
    
        // Determina el campo y el valor a utilizar
        if ($fecha_inicio) {
            $campo1 = 'Fecha';
            $tipo1 = 'Tiempo';
            $valor1 = $fecha_inicio;
        } elseif ($precio_minimo) {
            $campo1 = 'Monto_total';
            $tipo1 = 'Precio';
            $valor1 = $precio_minimo;
        } else {
            $campo1 = null;
            $valor1 = null;
        }
    
        if ($fecha_fin) {
            $campo2 = 'Fecha';
            $tipo2 = 'Tiempo';
            $valor2 = $fecha_fin;
        } elseif ($precio_max) {
            $campo2 = 'Monto_total';
            $tipo2 = 'Precio';
            $valor2 = $precio_max;
        } else {
            $campo2 = null;
            $valor2 = null;
        }
    
        $tablas = [
            [
                "Nombre_tabla" => "usuario",
                "Campos" => ["Nombre_Usuario"]
            ],
            [
                "Nombre_tabla" => "ventas",
                "Campos" => ["Monto_total", "Fecha", "ID_Ventas"],
                "Parametros_viculantes" => [["usuario", "ID_Usuario"]]
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
                    "Condicion_valor" => 3
                ]
            ]
        ];
    
        if (!empty($campo1) && !empty($valor1)) {
            $tablas[1]['Condicion1'] = [
                "Condicion_tipo" => $tipo1,
                "Condicion_nombre" => $campo1,
                "Condicion_marcador" => "Campo1",
                "Condicion_valor" => $valor1
            ];
        }
    
        if (!empty($campo2) && !empty($valor2)) {
            $tablas[1]['Condicion2'] = [
                "Condicion_tipo" => $tipo2,
                "Condicion_nombre" => $campo2,
                "Condicion_marcador" => "Campo2",
                "Condicion_valor" => $valor2
            ];
        }
    
        if (!empty($buscar)) {
            $tablas["Buscador"] = [
                "Buscador_marcador" => "Busqueda", 
                "Buscador_valor" => $buscar
            ];
        }
    
        $pedidos = $this->innerJoinTablas($tablas);
    
        $tabla = '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">Usuario</th>
                        <th scope="col">ID_Venta</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>';
    
                $ventas = [];

                foreach ($pedidos as $venta) {
                    if (!in_array($venta['ID_Ventas'], $ventas)) {
                        $ventas[] = $venta['ID_Ventas'];
                        $tabla .= '<tr>
                            <td>' . htmlspecialchars($venta['Nombre_Usuario']) . '</td>
                            <td>' . htmlspecialchars($venta['ID_Ventas']) . '</td>
                            <td>' . htmlspecialchars($venta['Monto_total']) . '</td>
                            <td>' . htmlspecialchars($venta['Fecha']) . '</td>
                            <td>' . htmlspecialchars($venta['Estado']) . '</td>
                        </tr>';
                    }
                }
                
    
        $tabla .= '</tbody></table>';
        echo $tabla;
        }
}