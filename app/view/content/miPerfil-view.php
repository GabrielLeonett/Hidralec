<?php 
  if (!isset($_SESSION['Nombre']) || empty($_SESSION['Nombre'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Opps a ocurrido un error",
        text: "Lo sentimos, Debe de iniciar sesion para acceder a tu perfil",
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
        text: "Lo sentimos, El Admin no puede acceder a esta pantalla",
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
<!--perfil de usuario imagen-->
<div class="container d-flex align-items-center">
    <div class="col-3">
    <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
    </svg>
<!--perfil de usuario informacion-->
</div>
    <div class="col-9">
    <div class="ms4">
                <h2>Perfil de Usuario</h2>
            </div>
            <div class="card-body">
                <!-- Datos del usuario que se muestran -->
                <p><strong>Nombre: <?php echo $_SESSION['Nombre']; ?></strong><span name="nombre_completo" class="text-dark">
                <p><strong>Usuario: <?php echo $_SESSION['Usuario']; ?></strong> <span name="usuario" class="text-dark">
                <p><strong>Correo:<?php echo $_SESSION['Correo']; ?></strong> <span name="correo" class="text-dark">
            </div>
    </div>
</div>

<section class="Historial-compras d-flex flex-column justify-content-center aling-items-center historial">
  <h2 class="text-center aling-middle">Historrial De Compras</h2>
  <?php
    $usuario->Compras();
  ?>
</section>

<div class="d-flex justify-content-center mt-4">
  <button type="button" class="btn btn-warning"><a href="home" class="nav-link">Volver al Home</a></button>
</div>