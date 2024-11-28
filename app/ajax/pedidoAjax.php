<?php
    require_once "../../autoload.php";
    require_once "../../config/app.php";
    use app\controller\pedidosController;

    if (isset($_POST['modulo_pedido']) && !empty($_POST['modulo_pedido'])) {

        $controladorPedidos = new pedidosController;

        if ($_POST['modulo_pedido'] == "eliminar") {
            $respuesta = $controladorPedidos->cancelarPedido();
            echo $respuesta;
        }        
        else if ($_POST['modulo_pedido'] == "aceptar") {
            $respuesta = $controladorPedidos->aceptarPedido();
            echo $respuesta;
        }

    } else {
        session_destroy();
        header("Location: " . APP_URL . "login");
    }
?>
