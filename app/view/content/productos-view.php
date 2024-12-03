<?php require_once "./app/view/inc/Carrito_de_Compras.php"; ?>
<div class="container">
  <form action="" method="POST" class="container-8" autocomplete="off">
    <div class="form-floating m-5">
      <input type="text" class="form-control rounded" name="Busqueda" pattern="[a-zA-ZáéíóúÁÉÍÓÚ1-9 ]{1,40}" id="floatingInputGroup1" placeholder="Buscar">
      <label for="floatingInputGroup1"><i class="bi bi-search"></i> Buscar</label>
    </div>
  </form>
  <div class="container d-flex flex-row flex-wrap justify-content-center respuesta">
    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $productos = $productos->busquedaProductos();
      if(empty($producto)){
        echo' <div class="container d-flex justify-content-center aling-items-center m-5 text-center">
                <h1>Lo Sentimos no se a encontrado el producto</h1>
              </div> ';
      }else{
        foreach ($productos as $producto) {
        echo '
          <div class="card">
              <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                  <h6 class="card-subtitle mb-2 texto-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                  <h6 class="card-subtitle mb-2 texto-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacen: ' . htmlspecialchars($producto['Stock']) . '</h6>
                  <p class="card-texto texto-break">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                  <a href="index.php?producto=' . htmlspecialchars($producto['ID_Productos']) . '"><button type="button" class="btn btn-outline-secondary">Ver Producto</button></a>
                  <button type="button" class="btn btn-warning agregar" data-id="' . htmlspecialchars($producto['ID_Productos']) . '">Agregar</button>
              </div>
          </div>
          ';}
        }
    } else {
      $respuesta = $productos->mostrarTodosProductos();
      foreach ($respuesta as $producto) {
        echo '
          <div class="card">
              <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="...">
              <div class="card-body">
                  <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                  <h6 class="card-subtitle mb-2 texto-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                  <h6 class="card-subtitle mb-2 texto-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacen: ' . htmlspecialchars($producto['Stock']) . '</h6>
                  <p class="card-texto texto-break">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                  <a href="' . htmlspecialchars(APP_URL) . 'producto/' . htmlspecialchars($producto['ID_Productos']) . '/"><button type="button" class="btn btn-outline-secondary">Ver Producto</button></a>
                  <button type="button" class="btn btn-warning agregar" data-id="' . htmlspecialchars($producto['ID_Productos']) . '">Agregar</button>
              </div>
          </div>
          ';
      }
    }
    ?>
  </div>
  <div class="position-fixed bottom-0 start-0 alerta z-3">
  </div>