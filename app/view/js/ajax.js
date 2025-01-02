function alertas_ajax(alerta){
    if(alerta.tipo=="simple"){

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        });

    }else if(alerta.tipo=="recargar"){

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                location.reload();
            }
        });

    }else if(alerta.tipo=="limpiar"){

        Swal.fire({
            icon: alerta.icono,
            title: alerta.titulo,
            text: alerta.texto,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if(result.isConfirmed){
                document.querySelector(".FormularioAjax").reset();
            }
        });

    }else if(alerta.tipo=="redireccionar"){
        window.location.href=alerta.url;
    }
}

/* Enviar formularios via AJAX */
const formularios_ajax=document.querySelectorAll(".FormularioAjax");

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit", enviarFormularioAjax)
});
function enviarFormularioAjax(e) {
    e.preventDefault();

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Quieres realizar la acción solicitada",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, realizar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            let data = new FormData(e.target);
            let method = e.target.getAttribute("method");
            let action = e.target.getAttribute("action");
            let config = {
                method: method,
                mode: 'cors',
                cache: 'no-cache',
                body: data
            };
            fetch(action, config)
                .then(respuesta => respuesta.json())
                .then(respuesta => alertas_ajax(respuesta));
        }
    });
}

function Modificar(button) {
    let BotonID = button.getAttribute('data-id');
    let Nombre = button.getAttribute('data-nombre');
    
    Swal.fire({
        title: 'Modificar/Actualizar',
        text: "Seguro que quieres Modificar este producto: " + Nombre,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, realizar',
        cancelButtonText: 'No, cancelar'
    }).then((result) =>{
        if (result.isConfirmed) {
            const data = new URLSearchParams();
            data.append('boton', BotonID);
            data.append('modulo_producto', 'modificar')
            data.append('etapa', 'formulario')
            let method = 'POST';
            let action = 'app/ajax/productoAjax.php';

            let config = {
                method: method,
                mode: 'cors',
                cache: 'no-cache',
                body: data
            };

            fetch(action, config)
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                let contenedor = document.querySelector(".Modificar");
                contenedor.innerHTML = respuesta;
            });
        }
    })
}

let listaEspera = [];

function Eliminar(button) {
    let BotonID = button.getAttribute('data-id');
    let Nombre = button.getAttribute('data-nombre');
    
    Swal.fire({
        title: 'Eliminar',
        text: "Seguro que quieres eliminar este producto: " + Nombre,
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
                data.append('boton', BotonID); // Asegúrate de que BotonID está definido
                data.append('modulo_producto', 'eliminar');
                let method = 'POST';
                let action = 'app/ajax/productoAjax.php';

                let config = {
                    method: method,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                fetch(action, config)
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        if(respuesta.texto === "El producto ha sido eliminado"){
                            respuesta.texto = "El producto "+Nombre+" ha sido eliminado";
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

function Habilitar(button) {
    let BotonID = button.getAttribute('data-id');
    let Nombre = button.getAttribute('data-nombre');
    
    Swal.fire({
        title: 'Eliminar',
        text: "Seguro que quieres Habilitar este producto: " + Nombre,
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
                data.append('boton', BotonID); // Asegúrate de que BotonID está definido
                data.append('modulo_producto', 'habilitar');
                let method = 'POST';
                let action = 'app/ajax/productoAjax.php';

                let config = {
                    method: method,
                    mode: 'cors',
                    cache: 'no-cache',
                    body: data
                };

                fetch(action, config)
                    .then(respuesta => respuesta.json())
                    .then(respuesta => {
                        if(respuesta.texto === "El producto ha sido eliminado"){
                            respuesta.texto = "El producto "+Nombre+" ha sido eliminado";
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

const buscador = document.querySelector(".BuscadorAjax");

buscador.addEventListener('submit', function(e) {
    e.preventDefault();

    let data = new FormData(e.target);
    let method = e.target.getAttribute("method");
    let action = e.target.getAttribute("action");

    let config = {
        method: method,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    };

    fetch(action, config)
    .then(respuesta => respuesta.text())
    .then(respuesta => {
        let contenedor = document.querySelector(".respuesta");
        contenedor.innerHTML = respuesta;
    });
});

const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.addedNodes.length) {
            const form = document.querySelector('.FormularioAjax');
            if (form) {
                form.addEventListener('submit', enviarFormularioAjax);
                observer.disconnect();
            }
        }
    });
});

observer.observe(document.body, { childList: true, subtree: true });

