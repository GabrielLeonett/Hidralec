<?php
    require_once "./app/view/inc/Carrito_de_Compras.php";
    use app\controller\productosController;

    $producto = new productosController();

    $producto = $producto->unSoloProducto($url[1]);

    echo '<div class="row justify-content-center m-5 p-4 border border-secondary border-opacity-50 rounded-3 especificaciones">
                <img src="'. htmlspecialchars(APP_URL) .'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="rounded float-end imagen_producto" alt="">
                <div class="col-lg-5 col-sm-12 p-3">
                    <div class="row"><h1>' . htmlspecialchars($producto['Nombre_Productos']) . '</h1></div>
                    <hr>
                    <div class="row mx-3">
                        <h3>Precio: ' . htmlspecialchars($producto['Precio']) . '</h3>
                        <h3>En almacén: ' . htmlspecialchars($producto['Stock']) . '</h3>
                        <p>Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                    </div>
                    <hr>
                    <div class="row justify-content-center align-items-center mt-4">
                        <button type="button" class="btn btn-warning agregar" data-id="' . htmlspecialchars($producto['ID_Productos']) . '">Agregar al carrito</button>
                    </div>
                </div>
            </div>
          ';

$carrusel = new productosController();
$carrusel->MostrarCarrusel();