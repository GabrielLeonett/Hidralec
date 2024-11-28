<?php
require_once "../../autoload.php";  #Traer el achivo para que se inicien las clases antes de ser instanciadas
require_once "../../config/app.php";

use app\controller\userController;

if (isset($_POST['modulo_cliente']) && !empty($_POST['modulo_cliente'])) {
    $usuario = new userController();

    if ($_POST['modulo_cliente'] == "registrar") {
        $respuesta = $usuario->registrarUsuario();
        echo json_encode($respuesta);
    }
} else {
    session_destroy();
    header("Location: " . APP_URL . "login");
}
