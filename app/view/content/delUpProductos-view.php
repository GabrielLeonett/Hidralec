    <div class="container Modificar">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <h1>Productos</h1>
            <h2>Eliminar Y Modificar Producto/s</h2>
        </div>
        <div class="container">
            <form action="app/ajax/productoAjax.php" method="POST" class="BuscadorAjax container-8" autocomplete="off">
                <div class="form-floating m-5">
                    <input type="hidden" name="modulo_producto" value="busqueda_eliminar">
                    <input type="text" class="form-control rounded" name="Busqueda" pattern="[a-zA-ZáéíóúÁÉÍÓÚ1-9 ]{1,40}" id="floatingInputGroup1" placeholder="Buscar">
                    <label for="floatingInputGroup1"><i class="bi bi-search"></i> Buscar</label>
                </div>
            </form>
        </div>

        <div class="container d-flex flex-row flex-wrap justify-content-center respuesta">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $productos = $productos->busquedaProductos();
                if (isset($productos)) {
                    foreach ($productos as $producto) {
                        if ($producto['Eliminado'] == 0) {
                            echo '
                        <div class="card">
                            <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                                <h6 class="card-subtitle mb-2 texto-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                                <h6 class="card-subtitle mb-2 texto-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacen: ' . htmlspecialchars($producto['Stock']) . '</h6>
                                <p class="card-texto texto-break">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                                <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn-outline-secondary" onclick="Eliminar(this)">Eliminar</button>
                                <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn btn-warning" onclick="Modificar(this)">Modificar</button>
                
                            </div>
                        </div>
                        ';
                        } else {
                            echo '
                            <div class="card">
                                <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                                    <h6 class="card-subtitle mb-2 texto-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                                    <h6 class="card-subtitle mb-2 texto-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacen: ' . htmlspecialchars($producto['Stock']) . '</h6>
                                    <h6 class="card-subtitle mb-2 texto-body-secondary text-danger"> Eliminado: Si </h6>
                                    <p class="card-texto texto-break">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                                    <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn-outline-secondary" onclick="Habilitar(this)">Habilitar</button>
                                    <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn btn-warning" onclick="Modificar(this)">Modificar</button>
                                </div>
                            </div>
                            ';
                        }
                    }
                } else {
                    echo 'No se encontro el producto deseado';
                }
            } else {
                $respuesta = $productos->mostrarTodosProductos();
                foreach ($respuesta as $producto) {
                    if ($producto['Eliminado'] == 0) {
                        echo '
                    <div class="card">
                        <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                            <h6 class="card-subtitle mb-2 texto-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                            <h6 class="card-subtitle mb-2 texto-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacen: ' . htmlspecialchars($producto['Stock']) . '</h6>
                            <p class="card-texto texto-break">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                            <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn-outline-secondary" onclick="Eliminar(this)">Eliminar</button>
                            <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn btn-warning" onclick="Modificar(this)">Modificar</button>
            
                        </div>
                    </div>
                    ';
                    } else {
                        echo '
                        <div class="card">
                            <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                                <h6 class="card-subtitle mb-2 texto-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                                <h6 class="card-subtitle mb-2 texto-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacen: ' . htmlspecialchars($producto['Stock']) . '</h6>
                                <h6 class="card-subtitle mb-2 texto-body-secondary text-danger"> Eliminado: Si </h6>
                                <p class="card-texto texto-break">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                                <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn-outline-secondary" onclick="Habilitar(this)">Habilitar</button>
                                <button type="button" data-id="' . htmlspecialchars($producto['ID_Productos']) . '" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '" class="btn btn btn-warning" onclick="Modificar(this)">Modificar</button>
                            </div>
                        </div>
                        ';
                    }
                }
            }
            ?>
        </div>
    </div>
    </div>
    </div>