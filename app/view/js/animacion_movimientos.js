function movimiento(i) {
  const elementos = document.querySelectorAll(".elementos-" + i);

  const animacion = elementos[0].animate(
    [
      { transform: "translateX(0)" },
      { transform: "translateX(-70em)"},
      { transform: "translateX(0)" }
    ],
    {
      fill: "forwards",
      duration: 14000 // Duración en milisegundos
    }
  );

  // Pausar la animación al pasar el cursor sobre el elemento
  document.getElementById('content_Carrusel').addEventListener("mouseenter", () => {
    animacion.pause();
  });

  // Reanudar la animación al quitar el cursor del elemento
  document.getElementById('content_Carrusel').addEventListener("mouseleave", () => {
    animacion.play();
  });
}

// Llama a la función para cada valor de i (por ejemplo, de 1 a 10)
for (let i = 1; i <= 15; i++) {
  movimiento(i);
}
  // Llama a la función nuevamente para actualizar la animación
  setInterval(() =>{
  for (let i = 1; i <= 15; i++) {
    movimiento(i);
  }}
  , 20000
  )

  const icono = document.querySelector('#star-icono');

  icono.addEventListener('click', () => {
      icono.classList.toggle('bi-star'); // Sin el punto
      icono.classList.toggle('bi-star-fill'); // Sin el punto
  });
