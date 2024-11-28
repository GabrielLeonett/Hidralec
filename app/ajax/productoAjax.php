<?php
    require_once "../../autoload.php";
    require_once "../../config/app.php";

    use app\controller\productosController;

    if (isset($_POST['modulo_producto']) && !empty($_POST['modulo_producto'])){

        $controladorProductos = new productosController;

            if ($_POST['modulo_producto'] == "registrar") {
                $respuesta = $controladorProductos->registrarProducto();
                echo json_encode($respuesta);
            }


            elseif ($_POST['modulo_producto'] == "modificar") {
                if(isset($_POST['etapa'])){
                    if($_POST['etapa'] == "formulario"){
                        $respuesta = $controladorProductos->mostrarFormularioActualizar();
                    }
                    elseif($_POST['etapa'] == "enviar"){
                        $respuesta = $controladorProductos->actualizarProducto();
                        echo json_encode($respuesta);
                    }
                }
            }

            elseif ($_POST['modulo_producto'] == "eliminar") {
                $respuesta = $controladorProductos->eliminarProducto();
                echo json_encode($respuesta);
            }

        } else {
            session_destroy();
            header("Location: " . APP_URL . "login");
        }
    
