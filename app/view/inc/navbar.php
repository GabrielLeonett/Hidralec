<nav class="navbar navbar-expand-md navbar-light Barra sticky-top z-2">
  <div class="container-fluid"> 
    <a class="navbar-brand d-flex flex-row align-items-center" href="<?php echo APP_URL?>home">
        <img src="<?php echo APP_URL?>app/view/img/Logo.ico" width="50" height="50" alt="Icono de la pagina web">
        <h1>Hidralec</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-toogler" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-toogler">
      <div class="container d-flex flex-row justify-content-end align-items-center link-barra">
          <ul class="navbar-nav nav-underline d-flex justify-content-center align-items-center">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?php echo APP_URL?>home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="<?php echo APP_URL?>productos">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL?>servicios">Servicios</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo APP_URL?>contacto">Contacto</a>
          </li>
          <li class="nav-item dropdown">
            <?php
              if (session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['Permisos'])) {
                if($_SESSION['Permisos'] === "Admin"){
                  echo '<div class="dropdown">
                              <div class="nav-link dropdown-toggle d-flex justify-content-center align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-4 mx-2" ></i>
                                <span class="align-middle">'.$_SESSION['Nombre'].' '.$_SESSION['ID'].'#</span>
                              </div>
                              <ul class="dropdown-menu dropdown-menu-end">
                                  <li><a class="dropdown-item" href="'.APP_URL.'Admin">Admin</a></li>                                  
                                  <li><a class="dropdown-item" href="'.APP_URL.'CerrarSesion">Cerrar sesión</a></li>
                              </ul>
                          </div>
                          ';
                }else{ 
                  echo '<div class="dropdown">
                              <div class="nav-link dropdown-toggle d-flex justify-content-center align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-4 mx-2" ></i>
                                <span class="align-middle">'.$_SESSION['Nombre'].' '.$_SESSION['ID'].'#</span>
                              </div>
                              <ul class="dropdown-menu dropdown-menu-end">
                                  <li><a class="dropdown-item" href="'.APP_URL.'miPerfil">Mi Perfil</a></li>                                  
                                  <li><a class="dropdown-item" href="'.APP_URL.'CerrarSesion">Cerrar sesión</a></li>
                              </ul>
                          </div>
                          ';
                }
              }else{
                  echo '<div class="dropdown">
                          <i class="bi bi-person-circle btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center fs-4" data-bs-toggle="dropdown" aria-expanded="false"></i>
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li><a class="dropdown-item" href="'.APP_URL.'login">Iniciar sesión</a></li>
                              <li><a class="dropdown-item" href="'.APP_URL.'login">Registrar</a></li>
                          </ul>
                        </div>';
                }
            ?>
          </li>
          </ul>
      </div>
    </div>
  </div>
</nav>