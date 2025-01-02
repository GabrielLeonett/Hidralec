<?php         
    namespace app\controller;
    define('MainModel', dirname(__FILE__) . '/../models/mainModel.php');
    
    require_once MainModel;
    use app\models\mainModel;

    class productosController extends mainModel{
        
        #Para mostrar Todos los productos
        public function mostrarTodosProductos() {
            $array = [
                "campos" => "",
                "modo" => []
            ];
            $respuesta = $this->seleccionarDatos("productos", $array);
    
            $resultados = $respuesta->fetchAll(\PDO::FETCH_ASSOC);
    
            return $resultados;
        }

        #funcion para registrar un producto en la base de datos y guardar la imagen
        public function registrarProducto(){
            $respuesta = [];
            $datos = [];
            $error = [];


            # Verificando el nombre
            if (isset($_POST['Producto_name']) && $_POST['Producto_name'] != "") {
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 |]{3,40}", $_POST['Producto_name']) == false) {
                    $nombre = $this->limpiarCadena($_POST['Producto_name']);
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Nombre no cumple con lo pedido"
                        ];
                    return $error;
                    exit();
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El campo Nombre está vacío"
                ];
                return $error;
                exit();
            }

            # Verificando la descripción
            if (isset($_POST['Producto_des']) && $_POST['Producto_des'] != "") {
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]{3,400}",$_POST['Producto_des']) == false){
                    $descripcion = $this->limpiarCadena($_POST['Producto_des']);
                }else{
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Descripción No coincide con lo que se le esta pidiendo"
                    ];
                    return $error;
                    exit();
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El campo Descripción está vacío"
                ];
                return $error;
                exit();
            }
            $prueba_de_existencia = [
                [
                    "campos_nombre" => "Nombre_Productos",
                    "campos_marcador" => ":nombre",
                    "campos_valor" => $nombre
                ],
                [
                    "campos_nombre" => "Descripcion_Producto",
                    "campos_marcador" => ":descripcion",
                    "campos_valor" => $descripcion
                ]
            ];
            
            #Funcion que verifica si el producto que se quiere registrar de nuevo
            if($this->VerificarExistencia('productos',$prueba_de_existencia) == false){

                # Verificando el precio
                if (isset($_POST['Producto_precio']) && $_POST['Producto_precio'] != "") {
                    if($this->verificarDatos("[0-9.]{1,5}",$_POST['Producto_precio']) == false){
                        $precio = $this->limpiarCadena($_POST['Producto_precio']);
                    }else{
                        $error = ["tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps a ocurrido un error",
                            "texto" => "El campo Precio No coincide con lo que se le esta pidiendo"
                        ];
                        return $error;
                        exit();
                    }
                } else {
                    $error = ["tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Precio está vacío"
                    ];
                    return $error;
                    exit();
                }

                # Verificando el stock
                if (isset($_POST['Producto_stock']) && $_POST['Producto_stock'] != "") {
                    if($this->verificarDatos("[0-9]{1,5}",$_POST['Producto_stock']) == false){
                        $stock = $this->limpiarCadena($_POST['Producto_stock']);
                    }else{
                        $error = ["tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps a ocurrido un error",
                            "texto" => "El campo Stock No coincide con lo que se le esta pidiendo"
                        ];
                        return $error;
                        exit();
                    }
                } else {
                    $error = ["tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Stock está vacío"
                    ];
                    return $error;
                    exit();
                }

                # Verificando el área
                if (isset($_POST['Producto_area']) && $_POST['Producto_area'] != "") {
                    if($this->verificarDatos("[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ, ]{7,100}",$_POST['Producto_area']) == false){
                        $area = $this->limpiarCadena($_POST['Producto_area']);
                    }else{
                        $error = ["tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps a ocurrido un error",
                            "texto" => "El campo Area de uso No coincide con lo que se le esta pidiendo"
                            ];
                        return $error;
                        exit();
                    }
                } else {
                    $error = ["tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Area de uso está vacío"
                    ];
                    return $error;
                    exit();
                }

                # Verificando la imagen
                if (isset($_FILES['imagen_producto']) && $_FILES['imagen_producto']['error'] == UPLOAD_ERR_OK) {
                    $imagen = $this->renombrarFotos(basename($_FILES['imagen_producto']['name']));
                    $imagen = $this->limpiarCadena($imagen);
                    $imagen_Guardada = $this->guardarImagen($_FILES['imagen_producto'],$imagen);
                    if($imagen_Guardada['confirmacion'] == false){
                        return $imagen_Guardada['Error'];
                        exit();
                    }
                }else {
                    $error = [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps a ocurrido un error",
                            "texto" => "El Campo de la imagen esta vacío"
                        ];
                        return $error;
                        exit();
                }

                if ($_POST['Carrusel'] == true) {
                    $Carrusel = 1;
                } else {
                    $Carrusel = 0;
                }
                

                
                
                    if(empty($error) && $imagen_Guardada['confirmacion'] == true ){
                        $datos = [
                            [
                                "campos_nombre" => "Nombre_Productos",
                                "campos_marcador" => ":nombre",
                                "campos_valor" => $nombre
                            ],
                            [
                                "campos_nombre" => "Descripcion_Producto",
                                "campos_marcador" => ":descripcion",
                                "campos_valor" => $descripcion
                            ],
                            [
                                "campos_nombre" => "Precio",
                                "campos_marcador" => ":precio",
                                "campos_valor" => $precio
                            ],
                            [
                                "campos_nombre" => "Stock",
                                "campos_marcador" => ":stock",
                                "campos_valor" => $stock
                            ],
                            [
                                "campos_nombre" => "`Areas de uso`",
                                "campos_marcador" => ":area",
                                "campos_valor" => $area
                            ],
                            [
                                "campos_nombre" => "DIr_Imagen",
                                "campos_marcador" => ":imagen",
                                "campos_valor" => $imagen
                            ],
                            [
                                "campos_nombre" => "Carrusel_Productos",
                                "campos_marcador" => ":Carrusel",
                                "campos_valor" => $Carrusel
                            ]
                        ];
                        $tabla = "productos";
                        $respuesta = $this->guardarDatos($tabla,$datos);
                        if($respuesta->rowCount() > 0){
                            $alerta = [
                                "tipo" => "simple",
                                "icono" => "success",
                                "titulo" => "Perfecto",
                                "texto" => "Su producto ha sido registrado."
                            ];
                            return $alerta;
                        }else{
                            $error = [
                                "tipo" => "simple",
                                "icono" => "error",
                                "titulo" => "Opps a ocurrido un error",
                                "texto" => "Ha habido un error en la base de datos."
                            ];
                            return $error;
                        }

                    }else{
                        $error = [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps a ocurrido un error",
                            "texto" => "Hay errores por favor vuelva a hacer todo de nuevo."
                        ];
                        return $error;
                    }
            }else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "Este producto ya fue esta registrado."
                ];
                return $error;
            }
            
        }

        #funcion para buscar productos en la base de datos
        public function busquedaProductos(){
            $buscador = $_POST['Busqueda'];
            if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]{1,400}",$_POST['Busqueda']) == false){
            $buscador = $this->limpiarCadena($buscador);
            $consulta = "(Nombre_Productos LIKE :busqueda OR Descripcion_Producto LIKE :busqueda OR Precio LIKE :busqueda OR Stock LIKE :busqueda OR `Areas de uso` LIKE :busqueda)";
            $buscador = $this->Buscador("productos",$consulta,$buscador);
            return $buscador;
            }else{
                echo "No cumple lo que esta pidiendo el campo";
                return;
            }

        }

        #funcion para eliminar productos en la base de datos
        public function eliminarProducto() {
            if (isset($_POST['boton'])) {
                $Boton = $_POST['boton'];
        
                $datos = [
                    [
                        "campos_nombre" => "Eliminado",
                        "campos_marcador" => "El",
                        "campos_valor" => 1
                    ]
                ];
        
                $ID = [
                    "Campo" => "ID_Productos",
                    "Valor" => $Boton
                ];
        
                $respuesta = $this->modificarDatos('productos', $datos, $ID);
        
                if ($respuesta->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "icono" => "success",
                        "titulo" => "Perfecto",
                        "texto" => "El producto ha sido eliminado."
                    ];
                    return $alerta;
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El producto no está registrado. Por favor, reinicia la página."
                    ];
                    return $error;
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El producto no está registrado. Por favor, reinicia la página."
                ];
                return $error;
            }
        }
        
        

        public function habilitarProducto(){
            if (isset($_POST['boton'])) {
                $Boton = $_POST['boton'];
        
                $datos = [
                    [
                        "campos_nombre" => "Eliminado",
                        "campos_marcador" => "El",
                        "campos_valor" => 0
                    ]
                ];
        
                $ID = [
                    "Campo" => "ID_Productos",
                    "Valor" => $Boton
                ];
        
                $respuesta = $this->modificarDatos('productos', $datos, $ID);
        
                if ($respuesta->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "icono" => "success",
                        "titulo" => "Perfecto",
                        "texto" => "El producto ha sido habilitado."
                    ];
                    return $alerta;
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El producto no está registrado. Por favor, reinicia la página."
                    ];
                    return $error;
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El producto no está registrado. Por favor, reinicia la página."
                ];
                return $error;
            }
        }

        public function mostrarFormularioActualizar(){
            $ID_Producto = $_POST['boton'];
            if (isset($ID_Producto)) {
                $conex = $this->conectarBD();
                $consulta = "SELECT * FROM productos WHERE ID_Productos = :Id_producto";
                $producto = $conex->prepare($consulta);
                $producto->bindParam(':Id_producto', $ID_Producto);
                $producto->execute();
            
                if ($producto->rowCount() == 1) {
                    $producto = $producto->fetch();
                echo '
                            <div class="container d-flex flex-column justify-content-center align-items-center">
                                <h1>Modificación del Producto </h1>
                                <h2>' . htmlspecialchars($producto['Nombre_Productos']) . '</h2>
                            </div>
                            <div class="container d-flex flex-row flex-wrap justify-content-center">
                                <div class="card">
                                    <img src="' . htmlspecialchars(APP_URL) . 'app/imagenes_productos/' . htmlspecialchars($producto['DIr_Imagen']) . '" class="card-img-top" alt="Imagen del producto">
                                    <div class="card-body">
                                        <h5 class="card-title" data-nombre="' . htmlspecialchars($producto['Nombre_Productos']) . '">' . htmlspecialchars($producto['Nombre_Productos']) . '</h5>
                                        <h6 class="card-subtitle mb-2 text-body-secondary precio" data-precio="' . htmlspecialchars($producto['Precio']) . '">Precio: ' . htmlspecialchars($producto['Precio']) . '</h6>
                                        <h6 class="card-subtitle mb-2 text-body-secondary stock" data-stock="' . htmlspecialchars($producto['Stock']) . '">En almacén: ' . htmlspecialchars($producto['Stock']) . '</h6>
                                        <p class="card-text">Descripción: ' . htmlspecialchars($producto['Descripcion_Producto']) . '</p>
                                    </div>
                                </div>
                            </div>
                            <form action="app/ajax/productoAjax.php" method="POST" class="FormularioAjax container-8" autocomplete="off">
                                <div class="d-flex flex-row justify-content-around align-items-center">
                                    <div class="container">
                                        <input type="hidden" name="modulo_producto" value="modificar">
                                        <input type="hidden" name="etapa" value="enviar">
                                        <input type="hidden" name="boton" value="' . htmlspecialchars($producto['ID_Productos']) . '">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input class="form-control" type="text" placeholder="Nombre Producto" name="Producto_name" pattern="[a-zA-ZáéíóúÁÉÍÓÚ1-9 ]{3,40}" maxlength="40">
                                            <div id="passwordHelpBlock" class="form-text">
                                                Colocar el nombre del producto.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input class="form-control" type="text" placeholder="Descripción" name="Producto_des" pattern="[a-zA-ZáéíóúÁÉÍÓÚ\t., ]{3,4000}" maxlength="400">
                                            <div id="passwordHelpBlock" class="form-text">
                                                Colocar la descripción del producto.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around align-items-center">
                                    <div class="container">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input class="form-control" type="number" placeholder="Precio" name="Producto_precio" pattern="[0-9]{1,5}" maxlength="20">
                                            <div id="passwordHelpBlock" class="form-text">
                                                Colocar el precio del producto.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input class="form-control" type="number" name="Producto_stock" placeholder="Stock" pattern="[0-9]{1,5}" maxlength="70">
                                            <div id="passwordHelpBlock" class="form-text">
                                                Colocar la cantidad del producto. Ej: 15 Martillos.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around align-items-center">
                                    <div class="container">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input class="form-control" type="text" name="Producto_area" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="Áreas de uso">
                                            <div id="passwordHelpBlock" class="form-text">
                                                Áreas de uso del producto. Ej: Carpintería, Jardinería, Construcción. Separado por una ",".
                                            </div>   
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input class="form-control" type="file" id="formFile" name="imagen_producto" accept="image/*" placeholder="Imagen">                       
                                            <div id="passwordHelpBlock" class="form-text">   
                                                Colocar la imagen. Los formatos de imagen tienen que ser: "jpg", "png", "jpeg", "webp".
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around align-items-center">
                                    <div class="container">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <input type="checkbox" id="star-checkbox" class="hidden-checkbox" name="Carrusel">
                                            <i id="star-icono" class="bi bi-star fs-3"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                </p>
                            </form>
                        ';
                }
            }
        }

        #funcion para modificar productos en la base de datos
        public function actualizarProducto() {
            $ID_Producto = $_POST['boton'];
            $datos = [];
            $error = [];
        
            if (isset($_POST['Producto_name']) && $_POST['Producto_name'] != "") {
                if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 ]{3,40}", $_POST['Producto_name']) === false) {
                    $nombre = $this->limpiarCadena($_POST['Producto_name']);
                    $datos[] = [
                        "campos_nombre" => "Nombre_Productos",
                        "campos_marcador" => "nombre",
                        "campos_valor" => $nombre
                    ];
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Oops, ha ocurrido un error",
                        "texto" => "El campo Nombre no cumple con lo pedido"
                    ];
                    return $error;
                }
            }
        
            if (isset($_POST['Producto_des']) && $_POST['Producto_des'] != "") {
                if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ., ]{3,400}", $_POST['Producto_des']) === false) {
                    $descripcion = $this->limpiarCadena($_POST['Producto_des']);
                    $datos[] = [
                        "campos_nombre" => "Descripcion_Producto",
                        "campos_marcador" => "descripcion",
                        "campos_valor" => $descripcion
                    ];
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Oops, ha ocurrido un error",
                        "texto" => "El campo Descripción no coincide con lo que se le está pidiendo"
                    ];
                    return $error;
                }
            }
        
            if (isset($_POST['Producto_precio']) && $_POST['Producto_precio'] != "") {
                if ($this->verificarDatos("[0-9.]{1,5}", $_POST['Producto_precio']) === false) {
                    $precio = $this->limpiarCadena($_POST['Producto_precio']);
                    $datos[] = [
                        "campos_nombre" => "Precio",
                        "campos_marcador" => "precio",
                        "campos_valor" => $precio
                    ];
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Oops, ha ocurrido un error",
                        "texto" => "El campo Precio no coincide con lo que se le está pidiendo"
                    ];
                    return $error;
                }
            }
        
            if (isset($_POST['Producto_stock']) && $_POST['Producto_stock'] != "") {
                if ($this->verificarDatos("[0-9]{1,5}", $_POST['Producto_stock']) === false) {
                    $stock = $this->limpiarCadena($_POST['Producto_stock']);
                    $datos[] = [
                        "campos_nombre" => "Stock",
                        "campos_marcador" => "stock",
                        "campos_valor" => $stock
                    ];
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Oops, ha ocurrido un error",
                        "texto" => "El campo Stock no coincide con lo que se le está pidiendo"
                    ];
                    return $error;
                }
            }
        
            if (isset($_POST['Producto_area']) && $_POST['Producto_area'] != "") {
                if ($this->verificarDatos("[a-zA-Z0-9ÁÉÍÓÚáéíóúÑñ, ]{7,100}", $_POST['Producto_area']) === false) {
                    $area = $this->limpiarCadena($_POST['Producto_area']);
                    $datos[] = [
                        "campos_nombre" => "Areas de uso",
                        "campos_marcador" => "area",
                        "campos_valor" => $area
                    ];
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Oops, ha ocurrido un error",
                        "texto" => "El campo Área de uso no coincide con lo que se le está pidiendo"
                    ];
                    return $error;
                }
            }
        
            if (isset($_FILES['imagen_producto']) && $_FILES['imagen_producto']['error'] == UPLOAD_ERR_OK) {
                $stmt = $this->conectarBD()->query("SELECT DIr_imagen FROM productos WHERE ID_Productos = $ID_Producto");
                $nombre_imagen_actual = $stmt->fetch(\PDO::FETCH_ASSOC)['DIr_imagen'];
                
                $resultado = $this->actualizarImagen($_FILES['imagen_producto'], $nombre_imagen_actual);
            
                if ($resultado['confirmacion'] === false) {
                    return $resultado['error'];
                }
            
                $datos[] = [
                    "campos_nombre" => "DIr_Imagen",
                    "campos_marcador" => "imagen",
                    "campos_valor" => $resultado['nombre_imagen']
                ];
            }   

            if(isset($_POST['Carrusel'])){
                $datos[] = [
                    "campos_nombre" => "Carrusel_Productos",
                    "campos_marcador" => "carrusel",
                    "campos_valor" => 1
                ];
            }

            if(!empty($datos)){
                if (empty($error)) {
                    $ID = ["Campo" => "ID_Productos", "Valor" => $ID_Producto];
                    $tabla = "productos";
                    $respuesta = $this->modificarDatos($tabla, $datos, $ID);
                    if ($respuesta->rowCount() > 0) {
                        return [
                            "tipo" => "simple",
                            "icono" => "success",
                            "titulo" => "Perfecto",
                            "texto" => "Su producto ha sido Modificado/Actualizado"
                        ];
                    } else {
                        return [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Oops, ha ocurrido un error",
                            "texto" => "Ha habido un error en la base de datos."
                        ];
                    }
                }else{
                    $error = [
                    "tipo" => "simple",
                    "icono" => "question",
                    "titulo" => "Oops, ha ocurrido un error",
                    "texto" => "No hay ningun cambio."
                    ];
                    return $error;
                }
            }else{
                $error = [
                    "tipo" => "simple",
                    "icono" => "question",
                    "titulo" => "Oops, ha ocurrido un error",
                    "texto" => "No se ha eviado nada por lo cual no hay cambios."
                    ];
                    return $error;
            }
            
        }
        
        #Funcion para seleccionar un solo producto de la base de datos
        public function unSoloProducto($id) {
            $datos = [
                "campos" => [],
                "modo" => [
                    "campos_nombre" => "ID_Productos",
                    "campos_marcador" => "ID",
                    "campos_valor" => $id
                ]
            ];
            

            $producto = $this->seleccionarDatos('productos', $datos);
            return $producto->fetch(\PDO::FETCH_ASSOC);
        }
        
        #Funcion para mostrar el Carrusel de productos con un max de 15 productos en el Carrusel
        public function MostrarCarrusel(){
            $datos = [
                    "campos" => [],
                    "modo" => [
                        "campos_nombre" => "Carrusel_Productos",
                        "campos_marcador" => "productos",
                        "campos_valor" => 1
                    ]
            ];

            $Productos = $this->seleccionarDatos('productos',$datos);
            $Productos = $Productos->fetchAll(\PDO::FETCH_ASSOC);

            $Carrusel = '<section id="content_Carrusel">';

            $i = 1;
            foreach($Productos as $producto){
                $Carrusel .= '
                            <div class="elementos-'.htmlspecialchars($i).'"">
                                <img src="'. htmlspecialchars(APP_URL) .'app/imagenes_productos/'.htmlspecialchars($producto['DIr_Imagen']).'" class="card-img-top img-thumbnail" alt="...">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <strong class="text-success my-1">'. htmlspecialchars($producto['Precio']) .'$</strong>
                                <a href="'. htmlspecialchars(APP_URL) .'producto/' . htmlspecialchars($producto['ID_Productos']) . '/"><button type="button" class="btn btn-outline-secondary">Ver Producto</button></a>
                                </div>
                            </div>
                ';
                $i++;
            }

            $Carrusel .= '</section>';
            echo $Carrusel;
        }
}