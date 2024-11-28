const contenedor_consulta = document.querySelector('.consulta');
const formulario_consulta = document.querySelector('.form_consulta');

formulario_consulta.addEventListener('change', (event) => {
    let valor = event.target.value;
    let input = '';

    if (valor === "Time") {
        input = `
            <form class="Formulario_Consulta" action="app/ajax/consultaAjax.php" method="POST">
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="input-group m-3">
                        <input type="date" class="form-control" name="fecha_inicio" aria-label="Fecha inicio" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group m-3">
                        <input type="date" class="form-control" name="fecha_fin" aria-label="Fecha fin" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary my-3">Enviar</button>
                </div>
            </form>`;
    } else if (valor === "Precio") {
        input = `
            <form class="Formulario_Consulta" action="app/ajax/consultaAjax.php" method="POST">
                <div class="container d-flex justify-content-center align-items-center">
                    <div class="input-group m-3">
                        <input type="number" class="form-control" name="precio_minimo" placeholder="Precio mínimo" aria-label="Precio mínimo" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group m-3">
                        <input type="number" class="form-control" name="precio_maximo" placeholder="Precio máximo" aria-label="Precio máximo" aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary my-3">Enviar</button>
                </div>
            </form>`;
    }

    contenedor_consulta.innerHTML = input;

    // Adjuntar el listener al nuevo formulario dinámico
    const nuevo_formulario = document.querySelector('.Formulario_Consulta');
    nuevo_formulario.addEventListener('submit', (event) => {
        event.preventDefault();
        let data = new FormData(nuevo_formulario);
        data.append('modulo_consulta', 'consulta');
        let config = {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };
        fetch(nuevo_formulario.action, config)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text();
            })
            .then(responseText => {
                contenedor_consulta.innerHTML = responseText;
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    });
});
