<div class="d-flex justify-content-end">
    <button class="btn btn-primary position-fixed float-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="bi bi-cart4 fs-3"></i></button>
</div>
<div class="offcanvas Carrito offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Carrito De Compra</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container contenedor-carrito">
      </div>
        <div class="row m-4">
            <p class="fs-3 col text-end">Monto:</p>
            <p class="col fs-3 text-start Monto">0$</p>
        </div>
        <div class="d-flex flex-row justify-content-between"> 
            <button type="reset" class="btn btn-secondary Cancelar">Cancelar Compra</button>
            <a href="http://localhost/Proyecto_Hidralec/Pedido"><button type="button" class="btn btn-warning Realizar">Realizar Compra</button></a>
        </div>
    </div>
  </div>
</div>
<?php
    use app\controller\productosController;

    $producto = new productosController();

    $producto = $producto->unSoloProducto($url[1]);

    echo '<div class="row justify-content-center m-5 p-4 border border-secondary border-opacity-50 rounded-3">
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