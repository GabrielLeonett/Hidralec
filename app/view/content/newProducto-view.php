    <div class="container">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <h1>Productos</h1>
            <h2>Crear/Insertar Productos</h2>
        </div>
        <div class="container">
            <form action="app/ajax/productoAjax.php" method="POST" class="FormularioAjax container-8" autocomplete="on">
                <div class="d-flex flex-row justify-content-around align-items-center">
                    <input type="hidden" name="modulo_producto" value="registrar">
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input class="form-control" type="text" placeholder="Nombre Producto" name='Producto_name' class="input" pattern="[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 |]{3,40}" maxlength="40" required>
                            <div id="passwordHelpBlock" class="form-text">
                                Colocar el nombre del producto.
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                        <input class="form-control" type="text" placeholder="Descripcion" name="Producto_des" class="input" pattern="[a-zA-ZáéíóúÁÉÍÓÚÑñ., ]{3,400}" maxlength="400" required>
                        <div id="passwordHelpBlock" class="form-text">
                            Colocar la descripcion del producto.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-around align-items-center">
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input class="form-control" type="num" placeholder="Precio" name='Producto_precio' class="input" pattern="[0-9.]{1,5}" maxlength="20" required>
                            <div id="passwordHelpBlock" class="form-text">
                                Colocar el precio del producto.
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input class="form-control" type="num" name='Producto_stock' placeholder="Stock" class="input" pattern="[0-9]{1,5}" maxlength="70" required>
                            <div id="passwordHelpBlock" class="form-text">
                                Colocar la cantidad del producto. Ej: 15 Martillos.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-around align-items-center">
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input class="form-control" type="text" name='Producto_area' class="input" pattern="[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ, ]{7,100}"
                                maxlength="100" placeholder="Areas de uso" required>
                            <div id="passwordHelpBlock" class="form-text">
                                Areas de Usos del productos. Ej:Carpinteria,Jardineria, Construccion. Separado por una ",". 
                            </div>   
                        </div>
                    </div>
                    <div class="container">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <input class="form-control" type="file" id="formFile" name='imagen_producto' class="input" accept="Image/*" placeholder="Imagen" required>
                            <div id="passwordHelpBlock" class="form-text">
                                Colocar la imagen.
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="d-flex flex-row justify-content-around align-items-center">
                    <div class="container">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <input type="checkbox" id="star-checkbox" class="hidden-checkbox" name="Carrusel">
                                <i id="star-icono" class="bi bi-star fs-3"></i>
                            </div>
                    </div>
                </div>
                <p class="d-flex justify-content-center align-items-center">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </p>
            </form>
        </div>
        <div class="container Respuesta">

        </div>
    </div>
</div>