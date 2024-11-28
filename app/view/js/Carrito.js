let Productos = [];

let Compra = {
    Orden: [],
    Monto: 0
};

function agregarCarrito(e) {
    let boton_A = e.target;
    let productoId = boton_A.getAttribute('data-id');
    let Producto = Productos.find(p => p.N_boton == productoId);

    if (Producto) {
        let productoEnOrden = Compra.Orden.find(item => item.N_boton == productoId);

        if (productoEnOrden) {
            if (productoEnOrden.cantidad < Producto.Stock) {
                productoEnOrden.cantidad += 1;
                let targetDiv = document.querySelector(`.iconos-carrito[data-id='${productoId}']`);
                if (targetDiv) {
                    let divHermano = targetDiv.closest('.row').querySelector('.Cantidad_producto');
                    if (divHermano) {
                        divHermano.innerHTML = `${productoEnOrden.cantidad}x`;
                    }
                }
                sumarMonto(Producto.Precio);
            } else {
                mostrarMensajeAgotado(Producto.Nombre);
            }
        } else {
            Producto.cantidad = 1;
            let nuevoElemento = document.createElement('div');
            nuevoElemento.classList.add('row', 'padre');
            nuevoElemento.innerHTML = `
                <div class="col"><i class="bi bi-plus fs-4 sumar" data-id="${productoId}"></i></div>
                <div class="col"><i class="bi bi-dash fs-4 restar" data-id="${productoId}"></i></div>
                <div class="col"><p class="fs-5 Cantidad_producto">1x</p></div>
                <div class="col"><p class="fs-5 Nombre_carrito">${Producto.Nombre}</p></div>
                <div class="col"><p class="fs-5 Precio_carrito">${Producto.Precio}$</p></div>
                <div class="col"><i class="bi bi-x-circle fs-4 iconos-carrito quitar" data-id="${productoId}"></i></div>
            `;
            document.querySelector('.contenedor-carrito').appendChild(nuevoElemento);
            Compra.Orden.push(Producto);
            sumarMonto(Producto.Precio);
        }
    }
    actualizarCookie();
}

function mostrarMensajeAgotado(nombreProducto) {
    let mensaje = document.createElement('div');
    mensaje.classList.add('toast');
    mensaje.setAttribute('aria-live', 'assertive');
    mensaje.setAttribute('role', 'alert');
    mensaje.setAttribute('aria-atomic', 'true');
    mensaje.innerHTML = `
        <div class="toast-header bg-danger">
            <img src="app/view/img/Logo.webp" class="rounded me-2" alt="Logo" width="15" height="15">
            <strong class="me-auto">Hidralec</strong>
            <small>Ahora</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-danger">
            Lo sentimos, Usted agotó el producto: <strong>${nombreProducto}</strong>.
        </div>
    `;
    let Mostrar = document.querySelector('.alerta');
    Mostrar.appendChild(mensaje);
    var toastEl = document.querySelector('.toast');
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
}

function restarCarrito(e) {
    let botonRestar = e.target;
    let productoId = botonRestar.getAttribute('data-id');
    let padre = botonRestar.closest('.row');
    let divHermano = padre.querySelector('.Cantidad_producto');

    // Encontrar el producto correcto
    let indice = Compra.Orden.findIndex(p => p.N_boton == productoId);
    if (indice !== -1) {
        let Producto = Compra.Orden[indice];

        if (Producto.cantidad > 1) {
            // Reducir la cantidad
            Producto.cantidad -= 1;
            divHermano.innerHTML = `${Producto.cantidad}x`;
            restarMonto(Producto.Precio);
        } else {
            // Eliminar el producto del carrito
            restarMonto(Producto.Precio * Producto.cantidad);
            Compra.Orden.splice(indice, 1);
            padre.remove();
        }

        // Actualizar las cookies del carrito
        actualizarCookie();
    }
}

function sumarCarrito(e){
    let botonAumentar = e.target;
    let productoId = botonAumentar.getAttribute('data-id');
    let padre = botonAumentar.closest('.row');
    let divHermano = padre.querySelector('.Cantidad_producto');

    // Encontrar el producto correcto
    let indice = Compra.Orden.findIndex(p => p.N_boton == productoId);
    if (indice !== -1) {
        let Producto = Compra.Orden[indice];

        if (Producto.cantidad < Producto.Stock) {
            // Aumentar la cantidad
            Producto.cantidad += 1;
            divHermano.innerHTML = `${Producto.cantidad}x`;
            sumarMonto(Producto.Precio);

            // Actualizar las cookies del carrito
            actualizarCookie();
        } else {
            // Mostrar mensaje de que no hay más stock disponible
            mostrarMensajeAgotado(Producto.Nombre);
        }
    }
}

/*Esta funcion suma un Monto del carrito y la compra.Monto*/
function sumarMonto(Numero) {
    Compra.Monto += +Numero;
    let Monto_Carrito = document.querySelector('.Monto');
    Monto_Carrito.innerHTML = `${Compra.Monto}$`;
}

/*Esta funcion resta un Monto del carrito y la compra.Monto*/
function restarMonto(Numero) {
    Compra.Monto -= Numero; // Corregir la resta
    let Monto_Carrito = document.querySelector('.Monto');
    Monto_Carrito.innerHTML = `${Compra.Monto}$`;
}

/*Esta funcion quita todo el producto del carrito y la compra*/
function quitarCarrito(e) {
    let botonQuitar = e.target;
    let productoId = botonQuitar.getAttribute('data-id');
    let padre = botonQuitar.closest('.row');

    // Encontrar el producto correcto
    let indice = Compra.Orden.findIndex(p => p.N_boton == productoId);
    let Producto = Compra.Orden[indice];

    // Eliminar el producto del carrito
    let Valor = Producto.Precio * Producto.cantidad;
    restarMonto(Valor);
    Compra.Orden.splice(indice,1);
    padre.remove();


    // Actualizar las cookies del carrito
    actualizarCookie();
}

//Funcion para Hacer que los botones corresponden a su producto
function guardarDatos() {
    let botones_Agregar = document.querySelectorAll('.agregar');

    botones_Agregar.forEach(boton_A => {
        let cuadro = boton_A.closest('.card-body');

        if (cuadro) {
            let precio = cuadro.querySelector('.precio')?.getAttribute('data-precio');
            let nombre = cuadro.querySelector('.card-title')?.getAttribute('data-nombre');
            let stock = cuadro.querySelector('.stock')?.getAttribute('data-stock');
            let ID_producto = cuadro.querySelector('.agregar')?.getAttribute('data-id');

            if (stock === "0" || !precio || !nombre) {
                return;
            }

            let Producto = {
                Nombre: nombre,
                Precio: precio,
                Stock: stock,
                N_boton: ID_producto

            };

            Productos.push(Producto);
            boton_A.setAttribute('data-id', ID_producto); // Asocia el botón con el producto
        }
    });
}

//Usando las funciones creadas con sus respectivos eventos
document.addEventListener('DOMContentLoaded', () => {
    guardarDatos();
    CookieDelCarritoDeCompra();

    document.querySelector('.contenedor-carrito').addEventListener('click', (e) => {
        if (e.target.classList.contains('quitar')) {
            quitarCarrito(e);
        }
        else if (e.target.classList.contains('restar')) {
            restarCarrito(e);
        }
        else if (e.target.classList.contains('sumar')) {
            sumarCarrito(e);
        }
    });

    let botones_Agregar = document.querySelectorAll('.agregar');
    botones_Agregar.forEach(boton_A => {
        boton_A.addEventListener('click', agregarCarrito);
    });

    let boton_Cancelar = document.querySelector('.Cancelar');
    boton_Cancelar.addEventListener('click', function () {
        Compra.Orden = [];
        Compra.Monto = 0;
        let Borrar = document.querySelectorAll('.padre');
        Borrar.forEach(elements =>
            elements.remove()
        )
        let Monto_Carrito = document.querySelector('.Monto');
        Monto_Carrito.innerHTML = `${Compra.Monto}$`;
        actualizarCookie();
    })
});

//Función para actualizar la cookie
function actualizarCookie(){
    let CookieCompra = JSON.stringify(Compra);
    document.cookie = "La_Compra=" + CookieCompra + "; path=/; expires=Fri, 31 Dec 2024 23:59:59 GMT";
}

//Función para leer la cookie
function leerCookies(nombre){
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
        Compra = CookieCompra;
        Orden = Compra.Orden;
        Orden.forEach(Producto => {
            let nuevoElemento = document.createElement('div');
            nuevoElemento.classList.add('row', 'padre');
            nuevoElemento.innerHTML = `
                <div class="col"><i class="bi bi-plus fs-4 iconos-carrito sumar" data-id="${Producto.N_boton}"></i></div>
                <div class="col"><i class="bi bi-dash fs-4 iconos-carrito restar" data-id="${Producto.N_boton}"></i></div>
                <div class="col"><p class="fs-5 Cantidad_producto">${Producto.cantidad}x</p></div>
                <div class="col"><p class="fs-5 Nombre_carrito">${Producto.Nombre}</p></div>
                <div class="col"><p class="fs-5 Precio_carrito">${Producto.Precio}$</p></div>
                <div class="col"><i class="bi bi-x-circle fs-4 iconos-carrito quitar" data-id="${Producto.N_boton}"></i></div>
            `;
            document.querySelector('.contenedor-carrito').appendChild(nuevoElemento);
        })
        let Monto_Carrito = document.querySelector('.Monto');
        Monto_Carrito.innerHTML = `${Compra.Monto}$`;
    } else {
        console.log("No se encontró la cookie 'La_Compra'");
    }
}
