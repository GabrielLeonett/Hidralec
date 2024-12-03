<?php
    if (!isset($_SESSION['Nombre']) || empty($_SESSION['Nombre'])) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Opps a ocurrido un error",
            text: "Lo sentimos, Debe de iniciar sesion para poder realizar la compra",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login";
            }
        });
        </script>';
        exit(); // Detiene la ejecución del script después de la redirección
    } 

    if ($_SESSION['Permisos'] === "Admin") {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
        Swal.fire({
            icon: "error",
            title: "Opps a ocurrido un error",
            text: "Lo sentimos, El Admin no puede hacer ninguna compra",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login";
            }
        });
        </script>';
        exit(); // Detiene la ejecución del script después de la redirección
    }
?>
<header class=" text-warning p-3 text-center">
        <div class="container">
            <h1 class="h1">Pedidos</h1>
        </div>
</header>
    <main class="container my-4">
        <div class="container-fluid d-flex flex-row justify-content-center align-items-center p-2 text-center">
            <div class=" text-warning p-3 d-flex flex-column justify-content-center align-items-center col-4 m-3">
                <div class="container contenedor-carrito-pedido "></div>
                <div class="row m-4 ">
                    <p class="fs-3 col text-end ">Monto:</p>
                    <p class="col fs-3 text-start Monto">0$</p>
                    <form id="compraForm" action="" method="POST">
                        <div class="d-flex flex-row justify-content-center">
                            <button type="submit" class="btn btn-warning Realizar-compra">Realizar Compra</button>
                        </div>
                    </form>
                </div>   
            </div>
        </div>
    </main>
    <?php 
    use app\controller\pedidosController;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $pedido = new pedidosController();
        $resultado = $pedido->registrarPedido();
    }
    ?>

<script src="<?php echo APP_URL?>app/view/js/pedido.js"></script>