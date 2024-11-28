<?php
    namespace app\models;

    define('Server', dirname(__FILE__) . '/../../config/server.php');
    
    require_once Server;
    

    class mainModel{
        #Funcion para conectar a la base de datos
        protected function conectarBD(){
            try {
                // Usar \PDO para referenciar la clase global PDO
                $pdo = new \PDO('mysql:host=localhost;dbname=hidralec', 'root', '');
                // Configurar el modo de error de PDO para que lance excepciones
                $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (\PDOException $e) {
                // Mostrar el mensaje de error
                echo 'Error de conexión: ' . $e->getMessage();
                return null;
            }
        }
        
        #Funcion para verificar el correo y ver si es un correo
        protected function mascaraCorreo($email){
            if (filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL)) {
                return true;
            }else {
                return false;
            }
        }
        
        #Funcion para buscar en una tabla un dato especifico
        protected function Buscador($tabla,$consulta,$dato){
            if (isset($dato) && $dato != "") {
                $busqueda = $dato;
            
                $busqueda = $this->limpiarCadena($busqueda);
        
                $conex = $this->conectarBD();
        
                $consulta_Datos = "SELECT * FROM $tabla WHERE $consulta";
                $respuesta = $conex->prepare($consulta_Datos);
                $busqueda_param = "%" . $dato . "%";
                $respuesta->bindParam(':busqueda', $busqueda_param, \PDO::PARAM_STR);
                $respuesta->execute();
                return $respuesta;
            }
        }

        #Verificar datos 
        protected function verificarDatos($filtro, $cadena) {
            return !preg_match("/^".$filtro."$/", $cadena);
        }

        #limpiar cadenas de texto
        protected function limpiarCadena($cadena){
            $cadena = trim($cadena);
            $cadena = stripcslashes($cadena);
            $cadena = str_ireplace("<script>","",$cadena);
            $cadena = str_ireplace("</script>","",$cadena);
            $cadena = str_ireplace("<script src>","",$cadena);
            $cadena = str_ireplace("<script type=>","",$cadena);
            $cadena = str_ireplace("SELECT * FROM","",$cadena);
            $cadena = str_ireplace("DELETE FROM","",$cadena);
            $cadena = str_ireplace("INSERT INTO","",$cadena);
            $cadena = str_ireplace("DROP TABLE","",$cadena);
            $cadena = str_ireplace("DROP DATABASE","",$cadena);
            $cadena = str_ireplace("TRUNCATE TABLE","",$cadena);
            $cadena = str_ireplace("SHOW TABLES","",$cadena);
            $cadena = str_ireplace("SHOW DATABASE","",$cadena);
            $cadena = str_ireplace("<?php>","",$cadena);
            $cadena = str_ireplace("?>","",$cadena);
            $cadena = str_ireplace("--","",$cadena);
            $cadena = str_ireplace("^","",$cadena);
            $cadena = str_ireplace("<","",$cadena);
            $cadena = str_ireplace("[","",$cadena);
            $cadena = str_ireplace("]","",$cadena);
            $cadena = str_ireplace("==","",$cadena);
            $cadena = str_ireplace(";","",$cadena);
            $cadena = str_ireplace("::","",$cadena);
            $cadena = trim($cadena);
            $cadena = stripcslashes($cadena);
            return $cadena;
        }

        #Funcion para renombrar las fotos
        protected function renombrarFotos($nombre){
            $nombre = str_ireplace(" ","_",$nombre);
            $nombre = str_ireplace("/","_",$nombre);
            $nombre = str_ireplace("#","_",$nombre);
            $nombre = str_ireplace("-","_",$nombre);
            $nombre = str_ireplace("$","_",$nombre);
            $nombre = str_ireplace(",","_",$nombre);
            return $nombre;
        }   
        
        #funcion para guardar datos en un formularios de registro o nuevo
        protected function guardarDatos($tabla, $datos){

            $consulta = "INSERT INTO $tabla("; #Creacion de la consulta

            $i = 0; #variable para saber cuando si va a ir una como o no 
            foreach ($datos as $clave) {#Convierte los datos array datos a clave para iterar
                if($i >= 1){ #Saber si (i) es mayor que 1
                    $consulta .= ","; #Concatenacion de la (,) para poder separa propiedades de la tabla
                }
                $consulta .= $clave["campos_nombre"]; #Concatenacion del campos_nombre en la consulta
                $i++; #incrementar la variable (i)
            }

            $consulta .= ") VALUES(" ; # Concatenacion (VALUES) para seguir la consulta

            $i = 0; #variable para saber cuando si va a ir una como o no 
            foreach ($datos as $clave) {#Convierte los datos array datos a clave para iterar
                if($i >= 1){#Saber si (i) es mayor que 1
                    $consulta .= ",";#Concatenacion de la (,) para poder separa propiedades de la tabla
                }
                $consulta .= $clave["campos_marcador"]; #Concatenacion del Campos_marcador en la consulta
                $i++;#incrementar la variable (i)
            }

            $consulta .= ")"; #Concatenar ) para terminar la consulta
            
            //Descomentar el codigo de abajo para la depuracion
            //echo $consulta;

            $sql = $this->conectarBD()->prepare($consulta); #Inicializa y iguala sql a una coneccion prepara la consulta

            foreach($datos as $clave){ #Convierte los datos array datos a clave para iterar
                $sql->bindParam($clave["campos_marcador"],$clave["campos_valor"]); #Blinda cada parametro 
            }

            $sql->execute(); #ejecuta la consulta 
            return $sql; #devuelve la consulta
        }

        #funcion para seleccionar cualquier tabla con campos multiples o especifico y con condicion especifica o no 
        protected function seleccionarDatos($tabla, $datos) {
            $consulta = "SELECT ";
        
            // Selección de campos
            if (empty($datos["campos"])) {
                $consulta .= "* FROM $tabla";
            } else {
                // Asegurarse de que 'campos' es un array
                if (is_string($datos["campos"])) {
                    $datos["campos"] = explode(',', $datos["campos"]);
                }
                $consulta .= implode(", ", $datos["campos"]) . " FROM $tabla";
            }
        
            // Condición WHERE
            if (!empty($datos["modo"])) {
                $consulta .= ' WHERE ' . $datos["modo"]["campos_nombre"] . ' = :' . $datos["modo"]["campos_marcador"];
            }
        
            try {
                $sql = $this->conectarBD()->prepare($consulta);
        
                // Bind de parámetros
                if (!empty($datos["modo"])) {
                    $sql->bindParam(':' . $datos["modo"]["campos_marcador"], $datos["modo"]["campos_valor"]);
                }
        
                $sql->execute();
                return $sql; // Devolvemos el objeto PDOStatement
            } catch (PDOException $e) {
                // Manejo de errores
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        
        #Funcion para modificar datos de cualquier tabla de la BD con campos especificos o no 
        protected function modificarDatos($tabla, $datos, $ID) {
            $consulta = "UPDATE $tabla SET ";
            $i = 0;
            foreach ($datos as $clave) {
                if ($i > 0) {
                    $consulta .= ", ";
                }
                $consulta .= "`" . $clave["campos_nombre"] . "` = :" . $clave["campos_marcador"];
                $i++;
            }
            $consulta .= " WHERE " . $ID["Campo"] . " = :id";
            $sql = $this->conectarBD()->prepare($consulta);
            foreach ($datos as $clave) {
                if (isset($clave["campos_marcador"]) && isset($clave["campos_valor"])) {
                    $sql->bindParam(':' . $clave["campos_marcador"], $clave["campos_valor"]);
                }
            }

            //Descomentar el codigo de abajo para la depuracion
            //echo $consulta;
            
            $sql->bindParam(':id', $ID['Valor']);
        
            $sql->execute();
            return $sql;
        }  
        
        #Funcion para eliminar datos de cualquier tabla de la BD de un dato especifico
        protected function eliminarDatos($tabla,$datos){
            $consulta = "DELETE FROM $tabla WHERE ".$datos['campos_nombre']." = ".$datos['campos_marcador'];
            $sql = $this->conectarBD()->prepare($consulta);
            $sql->bindParam($datos['campos_marcador'],$datos['campos_valor']);
            $sql->execute();
            return $sql;
        }

        #Funcion para generar una clave dinamica para un id
        public function generarClaveUnica() {
            $maxIntentos = 50;
            $intentos = 0;
        
            do {
                $clave_dinamica = substr(md5(uniqid()), 0, 10);
                $datos = [
                    ["campos_nombre" => "ID_Ventas", 
                    "campos_marcador" => ":ID", 
                    "campos_valor" => $clave_dinamica]
                ];
        
            } while ($this->VerificarExistencia('ventas', $datos) == true);
        
            return $clave_dinamica;
        }

        #Funcion que guarda la imagen en el servidor
        protected function guardarImagen($Imagen, $nombre_producto) {
            if (isset($Imagen)) {

                $nombre_producto = pathinfo($nombre_producto, PATHINFO_FILENAME);
                $nombre_imagen = $nombre_producto . '.' . strtolower(pathinfo($Imagen['name'], PATHINFO_EXTENSION));
                $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_Hidralec/app/imagenes_productos/' . $nombre_imagen;
                $Pruebas = true;
                $imageFileType = strtolower(pathinfo($nombre_imagen, PATHINFO_EXTENSION));
                $check = getimagesize($Imagen["tmp_name"]);
        
                // Verificar si la carpeta no existe y crearla
                $carpeta = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_Hidralec/app/imagenes_productos';
        
                if (!is_dir($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }
        
                if ($check === false) {
                    return [
                        "confirmacion" => false,
                        "error" => [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps, ha ocurrido un error",
                            "texto" => "El archivo no es una imagen válida."
                        ]
                    ];
                }
        
                if (file_exists($rutaDestino)) {
                    $this->eliminarImagen($nombre_imagen);
                }
        
                if ($Imagen["size"] > 500000) {
                    return [
                        "confirmacion" => false,
                        "error" => [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps, ha ocurrido un error",
                            "texto" => "Lo sentimos, su archivo es muy grande."
                        ]
                    ];
                }
        
                if (!in_array($imageFileType, ["jpg", "png", "jpeg", "webp"])) {
                    return [
                        "confirmacion" => false,
                        "error" => [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps, ha ocurrido un error",
                            "texto" => "Lo sentimos, solo recibimos imágenes con tipo JPG, JPEG, PNG & WEBP."
                        ]
                    ];
                }
        
                if (move_uploaded_file($Imagen["tmp_name"], $rutaDestino)) {
                    return ["confirmacion" => true];
                } else {
                    return [
                        "confirmacion" => false,
                        "error" => [
                            "tipo" => "simple",
                            "icono" => "error",
                            "titulo" => "Opps, ha ocurrido un error",
                            "texto" => "No se pudo mover el archivo."
                        ]
                    ];
                }
            }
        }
        
        #Funcion para Actualizar la imagen en el servidor
        protected function actualizarImagen($imagen, $nombre_imagen) {
            $nuevoNombre = $this->renombrarFotos(basename($imagen['name']));
            $rutaTemporal = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_Hidralec/app/imagenes_productos/temp_' . $nuevoNombre;
        
            if (move_uploaded_file($imagen["tmp_name"], $rutaTemporal)) {
                $this->eliminarImagen($nombre_imagen);
                rename($rutaTemporal, $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_Hidralec/app/imagenes_productos/' . $nuevoNombre);
                return ["confirmacion" => true, "nombre_imagen" => $nuevoNombre];
            } else {
                return [
                    "confirmacion" => false,
                    "error" => [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps, ha ocurrido un error",
                        "texto" => "No se pudo mover el archivo."
                    ]
                ];
            }
        }
       
        #Funcion para eliminara una imagen en el servidor
        protected function eliminarImagen($nombre_imagen) {
            $ruta = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto_Hidralec/app/imagenes_productos/' . $nombre_imagen;
            if (file_exists($ruta)) {
                unlink($ruta);
                return true;
            } else {
                return false;
            }
        }
        
        #Funcion para verificar si el producto existe en la base de datos antes de ser registrado o actualizado.
        protected function VerificarExistencia($tabla, $datos) {
            $consulta = "SELECT * FROM $tabla WHERE ";
        
            $condiciones = [];
            foreach ($datos as $clave) {
                $condiciones[] = $clave['campos_nombre'] . " = " . $clave['campos_marcador'];
            }
            $consulta .= implode(" AND ", $condiciones);
        
            $sql = $this->conectarBD()->prepare($consulta);
            foreach ($datos as $clave) {
                $sql->bindParam($clave['campos_marcador'], $clave['campos_valor']);
            }
        
            if ($sql->execute()) {
                if ($sql->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                // Manejo de errores
                $errorInfo = $sql->errorInfo();
                echo "Error en la ejecución de la consulta: " . $errorInfo[2];
                return false;
            }
        }

        #Funcion para crear innerJoins complejos
        protected function innerJoinTablas($Tablas) {
            $consulta = "SELECT ";
        
            // Creación de la lista de campos
            $i = 0;
            foreach ($Tablas as $clave) {
                foreach ($clave['Campos'] as $campo) {
                    if ($i > 0) {
                        $consulta .= ", ";
                    }
                    $consulta .= $clave["Nombre_tabla"] . "." . $campo;
                    $i++;
                }
            }
        
            $consulta .= " FROM ";
        
            // Construcción de las uniones
            $i = 0;
            foreach ($Tablas as $clave) {
                if ($i == 0) {
                    $consulta .= $clave['Nombre_tabla'];
                } else {
                    $consulta .= " INNER JOIN " . $clave['Nombre_tabla'] . " ON ";
                    $j = 0;
                    foreach ($clave['Parametros_viculantes'] as $parametros_viculantes) {
                        if ($j > 0) {
                            $consulta .= " AND ";
                        }
                        $consulta .= $parametros_viculantes[0] . "." . $parametros_viculantes[1] . " = " . $clave['Nombre_tabla'] . "." . $parametros_viculantes[1];
                        $j++;
                    }
                }
                $i++;
            }
        
            // Construcción de la cláusula WHERE
            $firstCondition = true;
            foreach ($Tablas as $datos) {
                if (isset($datos['Condicion']) && !empty($datos['Condicion'])) {
                    if ($firstCondition) {
                        $consulta .= " WHERE ";
                        $firstCondition = false;
                    } else {
                        $consulta .= " AND ";
                    }
                    if (!empty($datos['Condicion']['Condicion_tipo'])) {
                        if ($datos['Condicion']['Condicion_tipo'] == "Tiempo") {
                            $consulta .= "DATE(" . $datos['Nombre_tabla'] . "." . $datos['Condicion']['Condicion_nombre'] . ") = :" . $datos['Condicion']['Condicion_marcador'];
                        } elseif ($datos['Condicion']['Condicion_tipo'] == "Buscador") {
                            $consulta .= $datos['Nombre_tabla'] . "." . $datos['Condicion']['Condicion_nombre'] . " LIKE :" . $datos['Condicion']['Condicion_marcador'];
                        } else {
                            $consulta .= $datos['Nombre_tabla'] . "." . $datos['Condicion']['Condicion_nombre'] . " = :" . $datos['Condicion']['Condicion_marcador'];
                        }
                    }
                } elseif (isset($datos['Condicion1']) && !empty($datos['Condicion1']) && isset($datos['Condicion2']) && !empty($datos['Condicion2'])) {
                    if ($firstCondition) {
                        $consulta .= " WHERE ";
                        $firstCondition = false;
                    } else {
                        $consulta .= " AND ";
                    }
                    if (!empty($datos['Condicion1']['Condicion_tipo'])) {
                        if ($datos['Condicion1']['Condicion_tipo'] == "Tiempo") {
                            $consulta .= "DATE(" . $datos['Nombre_tabla'] . "." . $datos['Condicion1']['Condicion_nombre'] . ") BETWEEN :" . $datos['Condicion1']['Condicion_marcador'] . " AND :" . $datos['Condicion2']['Condicion_marcador'];
                        } else {
                            $consulta .= $datos['Nombre_tabla'] . "." . $datos['Condicion1']['Condicion_nombre'] . " BETWEEN :" . $datos['Condicion1']['Condicion_marcador'] . " AND :" . $datos['Condicion2']['Condicion_marcador'];
                        }
                    }
                } elseif (isset($datos['Buscador']) && !empty($datos['Buscador'])) {
                    if ($firstCondition) {
                        $consulta .= " WHERE ";
                        $firstCondition = false;
                    } else {
                        $consulta .= " AND ";
                    }
                    $consulta .= "(";
                    $k = 0;
                    foreach ($Tablas as $tabla) {
                        foreach ($tabla['Campos'] as $campo) {
                            if ($k > 0) {
                                $consulta .= " OR ";
                            }
                            $consulta .= $tabla['Nombre_tabla'] . "." . $campo . " LIKE :" . $datos['Buscador']['Buscador_marcador'];
                            $k++;
                        }
                    }
                    $consulta .= ")";
                }
            }
        
            //echo $consulta;
            $sql = $this->conectarBD()->prepare($consulta);
        
            // Vinculación de parámetros
            foreach ($Tablas as $datos) {
                if (isset($datos['Condicion']) && !empty($datos['Condicion'])) {
                    $sql->bindParam(':' . $datos['Condicion']['Condicion_marcador'], $datos['Condicion']['Condicion_valor']);
                }
                if (isset($datos['Condicion1']) && !empty($datos['Condicion1'])) {
                    $sql->bindParam(':' . $datos['Condicion1']['Condicion_marcador'], $datos['Condicion1']['Condicion_valor']);
                }
                if (isset($datos['Condicion2']) && !empty($datos['Condicion2'])) {
                    $sql->bindParam(':' . $datos['Condicion2']['Condicion_marcador'], $datos['Condicion2']['Condicion_valor']);
                }
                if (isset($datos['Buscador']) && !empty($datos['Buscador'])) {
                    $sql->bindValue(":" . $datos['Buscador']['Buscador_marcador'], "%" . $datos['Buscador']['Buscador_valor'] . "%");
                }
            }
        
            $sql->execute();
            return $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
    }        