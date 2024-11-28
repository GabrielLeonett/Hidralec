<?php
    require_once "../../autoload.php";
    require_once "../../config/app.php";
    use app\controller\consultaController;

    if (isset($_POST['modulo_consulta']) && !empty($_POST['modulo_consulta'])) {

        $controladorConsulta = new consultaController();

        if ($_POST['modulo_consulta'] == "consulta") {
            $respuesta = $controladorConsulta->mostrarConsulta();
        }

    } else {
        session_destroy();
        $error = ["tipo" => "redireccionar",
                    "url" => "login/"
                ];
        echo json_encode();
        header("Location: " . APP_URL . "login");
    }
?>
