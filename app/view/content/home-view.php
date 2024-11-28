<div id="Animacion">
  <div id="Fondo">
    <div id="Cuadrado">
      <div id="Barra_Alta"></div>
      <div id="Barra_Baja1_Vertical"></div>
      <div id="Barra_Baja2_Vertical"></div>
      <div id="Barra_Central1_Horizontal"></div>
      <div id="Barra_Central2_Horizontal"></div>
      <div id="Barra_Central3_Horizontal"></div>
      <div id="Barra_Central4_Horizontal"></div>
    </div>
  </div>
</div>
  <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
      <img class="bd-placeholder-img" width="100%" height="100%" src="<?php echo APP_URL?>app/view/img/Ferreteria.webp" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" alt="Ferreteria">
      <div class="container">
          <div class="carousel-caption text-start">
            <h1>Productos</h1>
            <p class="opacity-75 fs-4">Una amplia variedad de productos, desde Herramientas manuales hasta maquinaria industrial.</p>
            <p><a class="btn btn-lg btn-primary" href="<?php echo APP_URL?>productos">Productos</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="bd-placeholder-img" width="100%" height="100%" src="<?php echo APP_URL?>app/view/img/perforaciones.jpeg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" alt="Ferreteria">
        <div class="container">
          <div class="carousel-caption">
            <h1>Servicios</h1>
            <p class="opacity-75 fs-4"> Hidralec abre sus puertas para traer todas las soluciones a tus problemas</p>
            <p><a class="btn btn-lg btn-primary" href="<?php echo APP_URL?>servicios">Servicios</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="bd-placeholder-img" width="100%" height="100%" src="<?php echo APP_URL?>app/view/img/vendedor.jpg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" alt="Ferreteria">
      <div class="container">
          <div class="carousel-caption text-end">
            <h1>One more for good measure.</h1>
            <p>Some representative placeholder content for the third slide of this carousel.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <?php
  $productos->MostrarCarrusel();
  ?>
  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

    <!-- START THE FEATURETTES -->
  <div class="container">
    <h1>Bienvenidos</h1>
    <hr class="featurette-divider">
    

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">Nuestra mision</h2>
        <p class="lead">Ofrecer a nuestros clientes herramientas, materiales y servicios de la más alta calidad, asegurando que cada proyecto, grande o pequeño, se realice con éxito.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"/><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading fw-normal lh-1">Oh yeah, it’s that good. <span class="text-body-secondary">See for yourself.</span></h2>
        <p class="lead">Another featurette? Of course. More placeholder content here to give you an idea of how this layout would work with some actual real-world content in place.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"/><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">And lastly, this one. <span class="text-body-secondary">Checkmate.</span></h2>
        <p class="lead">And yes, this is the last block of representative placeholder content. Again, not really intended to be actually read, simply here to give you a better view of what this would look like with some actual content. Your content.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-bg)"/><text x="50%" y="50%" fill="var(--bs-secondary-color)" dy=".3em">500x500</text></svg>
      </div>
    </div>
  </div>