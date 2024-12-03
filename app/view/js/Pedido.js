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


function Aceptar_pedido(button) {
    let BotonID = button.getAttribute('data-id');
    let Nombre = button.getAttribute('data-id');
    
    Swal.fire({
        title: 'Aceptar',
        text: "Seguro que quieres Aceptar este Pedido: " + Nombre,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, realizar',
        cancelButtonText: 'No, cancelar'
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            
            const zona_alerta = document.querySelector('.alerta');
            
            // Añadir a la lista de espera
            listaEspera.push({ id: BotonID, nombre: Nombre });

            zona_alerta.innerHTML += `
                <div class="alert alert-success" role="alert" id="alerta${BotonID}">
                    Quiere Cancelar la Aceptacion del producto: <strong>${Nombre}</strong>
                    <button type="button" class="btn btn-outline-danger opacity-75 mx-3 btn_cancelar${BotonID}">Cancelar</button>
                </div>
            `;

            const botonCancelar = document.querySelector('.btn_cancelar' + BotonID);

            let temporizador = setTimeout(function() {
                const data = new URLSearchParams();
                data.append('ID_Venta', BotonID); // Asegúrate de que BotonID está definido
                data.append('modulo_pedido', 'aceptar');
                let method = 'POST';
                let action = 'app/ajax/pedidoAjax.php';

                let config = {
                    method: method,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                fetch(action, config)
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        if(respuesta.texto === "El Pedido ha sido Aceptado"){
                            respuesta.texto = "El Pedido "+Nombre+" ha sido Aceptado";
                        }
                        alertas_ajax(respuesta);
                        listaEspera = listaEspera.filter(item => item.id !== BotonID);
                    });
            }, 10000);

            botonCancelar.addEventListener('click', function() {
                clearTimeout(temporizador);
                document.querySelector('#alerta' + BotonID).remove();
                listaEspera = listaEspera.filter(item => item.id !== BotonID);
            });
        }

    })
}

function Eliminar_pedido(button) {
    let BotonID = button.getAttribute('data-id');
    let Nombre = button.getAttribute('data-id');
    
    Swal.fire({
        title: 'Eliminar',
        text: "Seguro que quieres eliminar este Pedido: " + Nombre,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, realizar',
        cancelButtonText: 'No, cancelar'
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            
            const zona_alerta = document.querySelector('.alerta');
            
            // Añadir a la lista de espera
            listaEspera.push({ id: BotonID, nombre: Nombre });

            zona_alerta.innerHTML += `
                <div class="alert alert-danger" role="alert" id="alerta${BotonID}">
                    Quiere Cancelar la eliminación del producto: <strong>${Nombre}</strong>
                    <button type="button" class="btn btn-outline-danger opacity-75 mx-3 btn_cancelar${BotonID}">Cancelar</button>
                </div>
            `;

            const botonCancelar = document.querySelector('.btn_cancelar' + BotonID);

            let temporizador = setTimeout(function() {
                const data = new URLSearchParams();
                data.append('ID_Venta', BotonID); // Asegúrate de que BotonID está definido
                data.append('modulo_pedido', 'eliminar');
                let method = 'POST';
                let action = 'app/ajax/pedidoAjax.php';

                let config = {
                    method: method,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                fetch(action, config)
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        if(respuesta.texto === "El Pedido ha sido eliminado"){
                            respuesta.texto = "El Pedido "+Nombre+" ha sido eliminado";
                        }
                        alertas_ajax(respuesta);
                        listaEspera = listaEspera.filter(item => item.id !== BotonID);
                    });
            }, 10000);

            botonCancelar.addEventListener('click', function() {
                clearTimeout(temporizador);
                document.querySelector('#alerta' + BotonID).remove();
                listaEspera = listaEspera.filter(item => item.id !== BotonID);
            });
        }

    })
}