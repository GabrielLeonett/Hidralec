<nav class="navbar navbar-expand-md navbar-light Barra sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex flex-row align-items-center" href="<?php echo APP_URL?>home">
      <img src="<?php echo APP_URL?>app/view/img/Logo.ico" width="50" height="50" alt="Icono de la pagina web">
      <h1>Sistema Administrativo Hidralec</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toogler"
      aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-toogler">
      <div class="container d-flex flex-row justify-content-end align-items-center">
        <ul class="navbar-nav nav-underline d-flex justify-content-center align-items-center">
          <li class="nav-item">
            <a href="<?php echo APP_URL?>CerrarSesion"><button type="button" class="btn btn-dark">Cerrar sesión</button></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<div class="container-fluid d-flex flex-row p-0">
  <div class="d-flex flex-column flex-shrink-0 p-3 barra-lateral" style="width: 280px;, ">
    <ul class="list-unstyled ps-0 ">
      <li class="nav-item mx-2 my-2">
          <a href="<?php echo APP_URL?>Admin" class="nav-link active" aria-current="page">
            <i class="bi bi-house fs-3"></i>
            <strong class="mx-1">Home</strong>
          </a>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          <i class="bi bi-tools fs-4"></i>
          <strong class="mx-2">Productos</strong>
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal m-1 pb-1 small">
            <li><a href="<?php echo APP_URL?>newProducto" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Nuevo</a></li>
            <li><a href="<?php echo APP_URL?>delUpProductos" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Eliminar o Modificar</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          <i class="bi bi-person-raised-hand fs-4"></i>
          <strong class="mx-2">Ventas</strong>
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal m-1 pb-1 small">
            <li><a href="<?php echo APP_URL?>consultarVentas" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Consultar Ventas</a></li>
          </ul>
      </li>
      </ul>
    <hr>
    <div class="dropdown">
      <a href="<?php echo APP_URL?>" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
        data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?php echo APP_URL?>app/view/img/Logo.webp" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong class="text-black"><?php echo $_SESSION['Usuario']?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
        <li><a class="dropdown-item" href="<?php echo APP_URL?>#">Cerrar Sección</a></li>
      </ul>
    </div>
  </div>