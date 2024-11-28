<?php
    require_once "./app/view/inc/session_start.php"; // Crear la variable de sesión
    require_once "./config/app.php"; // Traer variables de la app
    require_once "./autoload.php"; // Traer el archivo para que se inicien las clases antes de ser instanciadas
    require_once "./app/view/inc/head.php";

    // Obtener la vista solicitada
    if (isset($_GET['views'])) {
        $url = explode("/", $_GET['views']);
    } else {
        $url = ["home"];
    }

    use app\controller\userController;
    use app\controller\viewsController;
    use app\controller\cookiesController;
    use app\controller\productosController;

    if (isset($_SESSION['Nombre']) || !empty($_SESSION['Nombre'])) {
        $userID = $_SESSION['ID'];
    }
    $productos = new productosController();
    $cookie = new cookiesController();
    $cookie->cookieCompra();
    $usuario = new userController();
    $viewsController = new viewsController();
    $vista = $viewsController->traerVista($url[0]);
?>

<body>
<?php

    if ($vista["view"] == "404" || $vista["view"] == "login") {
        require_once "./app/view/inc/navbar.php";
        require_once "./app/view/content/" . $vista["view"] . "-view.php";
    } elseif ($vista["usuario"] == "Cliente") {
        if ($vista["view"] == "CerrarSesion") {
            require_once "./app/view/content/" . $vista["view"] . "-view.php";
        } else {
            require_once "./app/view/inc/navbar.php";
            require_once "./app/view/content/" . $vista["view"] . "-view.php";
            require_once "./app/view/inc/footer.php";
        }
    } elseif ($vista["usuario"] == "Admin") {
        if (isset($_SESSION['Permisos']) && $_SESSION['Permisos'] == "Admin") {
            require_once "./app/view/inc/Admin_menu.php";
            require_once "./app/view/content/" . $vista["view"] . "-view.php";
        } else {
            session_destroy();
            header("Location: " . APP_URL . "login");
        }
    }

    require_once "./app/view/inc/script.php";
?>
<div class="position-fixed bottom-0 end-0 alerta">
</div>
</body>
</html>
