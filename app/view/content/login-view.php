<?php

// Verifica si el id de la sesión está definido y no está vacío
if (isset($_SESSION['Nombre']) && !empty($_SESSION['Nombre'])) {
    echo '<script>
        window.location.href = "http://localhost/Proyecto_Hidralec/home/";
    </script>';
    exit(); // Detiene la ejecución del script después de la redirección
}

?>

<main>
    <div class="contenedor--todo">
        <div class="caja--trasera">
            <div class="caja--trasera--login">
                <h3>¿Ya tienes una cuenta?</h3>
                <p>Inicia sesión para entrar en la página</p>
                <button id="btn--iniciarSesion">Iniciar Sesión</button>
            </div>
            <div class="caja--trasera--register">
                <h3>¿Aun no tienes una cuenta?</h3>
                <p>Registrate para que puedas iniciar sesión</p>
                <button id="btn--registrarse">Registrarse</button>
            </div>
        </div>
        <!--formulario de inicio y registro-->
        <div class="contenedor--loginRegister"> 
            <form action="" method="POST" class="formulario--login container-8" autocomplete="on">
                <!--inicio-->
                <h2>Iniciar Sesión</h2>
                <input type="text" placeholder="Correo Electronico o usuario" name="Usuario_Correo" required>
                <input type="password" placeholder="Contraseña" name="password" required>
                <div class="card-footer text-center">
                        <a href="#" id="olvidoContrasena" class="text-dark">Se me olvidó la contraseña</a>
                </div>
                <button type="submit">Entrar</button>
                <?php   
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $usuario->loginUsuario();
                }
                ?>
            </form>
            <!--registro-->
            <form action="<?php echo APP_URL ?>app/ajax/userAjax.php" method="POST" class="FormularioAjax container-8 formulario--register" autocomplete="on">
                <h2>Registrarse</h2>
                <input type="hidden" name="modulo_cliente" value="registrar">
                <input type="text" placeholder="Nombre Completo" name="nombre_completo">
                <input type="text" placeholder="Correo Electronico" name="correo">
                <input type="text" placeholder="Usuario" name="usuario">
                <input type="password" placeholder="Contraseña" name="contraseña">
                <button>Registrarse</button>
            </form>
        </div>
    </div>
</main>