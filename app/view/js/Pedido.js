let Productos = [];

let Compra = {
    Orden: [],
    Monto: 0
};

// Función para leer la cookie 
function leerCookies(nombre) {
    let arrayCookies = document.cookie.split(";");
    for (let i = 0; i < arrayCookies.length; i++) {
        let unaCookie = arrayCookies[i].split("=");
        if (nombre == unaCookie[0].trim()) {
            return decodeURIComponent(unaCookie[1]);
        }
    }
    return null;
}

function CookieDelCarritoDeCompra() {
    let cookieValue = leerCookies('La_Compra');
    if (cookieValue) {
        let CookieCompra = JSON.parse(cookieValue);
        let Compra = CookieCompra; // Declarar localmente para evitar problemas de alcance 
        let Orden = Compra.Orden;
        Orden.forEach(Producto => {
            let nuevoElemento = document.createElement('div');
            nuevoElemento.classList.add('card', 'mb-3');
            nuevoElemento.innerHTML = `
                <div class="card-body">
                    <h5 class="card-title">${Producto.Nombre}</h5>
                    <p class="card-text">Cantidad: ${Producto.cantidad}</p>
                    <p class="card-text">Precio: ${Producto.Precio}$</p>
                </div>
            `;
            document.querySelector('.contenedor-carrito-pedido').appendChild(nuevoElemento);
        });
        let Monto_Carrito = document.querySelector('.Monto');
        Monto_Carrito.innerHTML = `${Compra.Monto}$`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    CookieDelCarritoDeCompra();
});
