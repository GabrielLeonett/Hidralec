<div class="position-absolute top-50 start-50 translate-middle bg-light" >
    <div class="d-flex flex-column justify-content-center aling-items-center p-5">
        <img src="app/view/img/mascota.png" class="img-fluid" alt="Icono de la pagina web">
        <h1>Hasta Pronto</h1>
        <span>Esperamos tenerte de vuelta pronto !</span>
        <a href="home"><button type="button" class="btn btn-primary my-3">Home</button></a>
        <?php
            $usuario->destruirSession();
        ?>
    </div>
</div>