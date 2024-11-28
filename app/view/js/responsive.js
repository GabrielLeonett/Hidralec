function ajustarPantallaMedia() {
        const anchoVentana = window.innerWidth;
        const carrito = document.querySelector('.Carrito');
        const barra = document.querySelector('.link-barra');
    
        if (anchoVentana <= 768) {
            barra.classList.remove('justify-content-end');
            barra.classList.add('justify-content-center');
            carrito.classList.remove('offcanvas-end');
            carrito.classList.add('offcanvas-bottom');
        } else {
            carrito.classList.remove('offcanvas-bottom');
            carrito.classList.add('offcanvas-end');
            barra.classList.remove('justify-content-center');
            barra.classList.add('justify-content-end');
        }
    }
    
    window.addEventListener('resize', ajustarPantallaMedia);
    document.addEventListener('DOMContentLoaded', ajustarPantallaMedia);
    