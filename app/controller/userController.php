<?php         
    namespace app\controller;

    use app\models\mainModel;

    class userController extends mainModel{

        #Funcion para registrar nuevos usuarios desde el formulario
        public function registrarUsuario() { 

            # Verificando el nombre_completo
            if (isset($_POST['nombre_completo']) && $_POST['nombre_completo'] != "") {
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 ]{3,40}", $_POST['nombre_completo']) == false) {
                    $nombre_completo = $this->limpiarCadena($_POST['nombre_completo']);
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Nombre Completo no cumple con lo pedido"
                        ];
                    return $error;
                    
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El campo Nombre Completo está vacío"
                ];
                return $error;
                
            }

            # Verificando el correo
            if (isset($_POST['correo']) && $_POST['correo'] != "") {
                if($this->mascaraCorreo(email: $_POST['correo']) == true) {
                    $correo = $_POST['correo'];
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Correo no cumple con lo pedido"
                        ];
                    return $error;
                    
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El campo Correo está vacío"
                ];
                return $error;
                
            }


            # Verificando el usuario
            if (isset($_POST['usuario']) && $_POST['usuario'] != "") {
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 ]{3,40}", $_POST['usuario']) == false) {
                    $usuario = $this->limpiarCadena($_POST['usuario']);
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Usuario no cumple con lo pedido"
                        ];
                    return $error;
                    
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El campo Usuario está vacío"
                ];
                return $error;
                
            }
            
           # Verificando el contraseña
           if (isset($_POST['contraseña']) && $_POST['contraseña'] != "") {
                if($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 ]{3,40}", $_POST['contraseña']) == false) {
                    $contraseña = $this->limpiarCadena($_POST['contraseña']);
                    $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT, ["cost"=>10]);
                } else {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "error",
                        "titulo" => "Opps a ocurrido un error",
                        "texto" => "El campo Contraseña no cumple con lo pedido"
                        ];
                    return $error;
                    
                }
            } else {
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El campo Contraseña está vacío"
                ];
                return $error;
                
            }

            /*Array para verificar si el usuario y el correo existe*/
            $prueba_de_existencia = [
                [
                    "campos_nombre" => "Usuario_Usuario",
                    "campos_marcador" => ":usuario",
                    "campos_valor" => $usuario
                ],
                [
                    "campos_nombre" => "Correo_Usuario",
                    "campos_marcador" => ":correo",
                    "campos_valor" => $correo
                ]
            ];
            
            #Funcion que verifica si el cliente que se ya esta registrado
            if($this->VerificarExistencia('usuario',$prueba_de_existencia) == false){
                #Array para mandarlo a guardar los datos del usuario
                $datos = [
                    [
                        "campos_nombre" => "Usuario_Usuario",
                        "campos_marcador" => ":usuario",
                        "campos_valor" => $usuario
                    ],
                    [
                        "campos_nombre" => "Correo_Usuario",
                        "campos_marcador" => ":corre",
                        "campos_valor" => $correo
                    ],
                    [
                        "campos_nombre" => "Password_Usuario",
                        "campos_marcador" => ":contrasena",
                        "campos_valor" => $contraseña_encriptada
                    ],
                    [
                        "campos_nombre" => "Nombre_Usuario",
                        "campos_marcador" => ":nombre",
                        "campos_valor" => $nombre_completo
                    ],
                ];

                $ValidarRegistro = $this->guardarDatos('usuario',$datos);
                if ($ValidarRegistro->rowCount() > 0) {
                    $error = [
                        "tipo" => "simple",
                        "icono" => "success",
                        "titulo" => "Perfecto",
                        "texto" => "se ha registrado el usuario"
                    ];
                    return $error;
                    
                }
            }else{
                $error = [
                    "tipo" => "simple",
                    "icono" => "error",
                    "titulo" => "Opps a ocurrido un error",
                    "texto" => "El usuario ya se encuentra registrado"
                ];
                return $error;
                
            }

        }

        #Funcion para el inicio de secion
        public function loginUsuario() {
        
            $correo = null;
            $usuario = null;
        
            // Verifica si es un correo o el usuario
            if (isset($_POST['Usuario_Correo']) && $_POST['Usuario_Correo'] != "") {
                if ($this->mascaraCorreo($_POST['Usuario_Correo']) == true) {
                    $correo = [
                        "campos_nombre" => "Correo_Usuario",
                        "campos_marcador" => ":correo",
                        "campos_valor" => $_POST['Usuario_Correo']
                    ];
                } else {
                    $usuario = $this->limpiarCadena($_POST['Usuario_Correo']);
                    $usuario = [
                        "campos_nombre" => "Usuario_Usuario",
                        "campos_marcador" => ":usuario",
                        "campos_valor" => $usuario
                    ];
                }
            }else {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Opps a ocurrido un error",
                        text: "El Campo Usuario o Correo esta vacio",
                        confirmButtonText: "Aceptar"
                    });
                    </script>';
                
            }
        
            // Verificando la contraseña
            if (isset($_POST['password']) && $_POST['password'] != "") {
                if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚÑñ0-9 ]{3,40}", $_POST['password']) == false) {
                    $contraseña = $this->limpiarCadena($_POST['password']);
                } else {
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Opps a ocurrido un error",
                            text: "La contraseña no cumple con lo pedido",
                            confirmButtonText: "Aceptar"
                        });
                        </script>'; 
                }
            } else {
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Opps a ocurrido un error",
                        text: "El Campo Contraseña esta Vacio",
                        confirmButtonText: "Aceptar"
                    });
                    </script>';    
                    exit();
            }
        
            if ($correo || $usuario) {
                $campo = $correo ? 'Correo_Usuario' : 'Usuario_Usuario';
                $valor = $correo ? $correo : $usuario;
                
                $existeUsuario = $this->verificarExistencia('usuario', [$valor]);
                if ($existeUsuario == true) {
                    $datos = [
                        "campos" => [],
                        "modo" => [
                            "campos_nombre" => $campo,
                            "campos_marcador" => "valor",
                            "campos_valor" => $_POST['Usuario_Correo']
                        ]
                    ];
                    
                    $existeUsuario = $this->seleccionarDatos('usuario', $datos);
                    if ($existeUsuario->rowCount() == 1) {
                        $usuarioData = $existeUsuario->fetch(\PDO::FETCH_ASSOC);
                        if (password_verify($contraseña, $usuarioData['Password_Usuario'])) {
                            // Iniciar sesión
                            $_SESSION['ID'] = $usuarioData['ID_Usuario'];
                            $_SESSION['Nombre'] = $usuarioData['Nombre_Usuario'];
                            $_SESSION['Usuario'] = $usuarioData['Usuario_Usuario'];
                            $_SESSION['Permisos'] = $usuarioData['Permisos_Usuario'];
                            $_SESSION['Correo'] = $usuarioData['Correo_Usuario'];
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
                            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                            echo '<script>
                                Swal.fire({
                                    icon: "success",
                                    title: "Bienvenida",
                                    text: "Disfruta de la mejor experiencia '.$_SESSION['Nombre'].'",
                                    confirmButtonText: "Aceptar"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "home";
                                    }
                                });
                            </script>';
                        } else {
                            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                            echo '<script>
                                    Swal.fire({
                                        icon: "error",
                                        title: "Opps, ha ocurrido un error",
                                        text: "Usuario o contraseña inválida",
                                        confirmButtonText: "Aceptar"
                                    });
                                  </script>';
                                  
                        }
                    }
                } else {
                    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
                    echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Opps, ha ocurrido un error",
                                text: "El usuario no existe",
                                confirmButtonText: "Aceptar"
                            });
                          </script>';
                          
                }
            }           
        }

        #Funcion para destruir la sesion
        public function destruirSession(){
            session_destroy();
        }

        
        #Funcion para mostrar las compras de un usuario en especifico 
        public function Compras(){
                $tablas = [
                    [
                        "Nombre_tabla" => "usuario",
                        "Campos" => ["Nombre_Usuario","ID_Usuario"],
                        "Condicion" => [
                            "Condicion_tipo" => "nada",
                            "Condicion_nombre" => "ID_Usuario",
                            "Condicion_marcador" => "ID_usuario",
                            "Condicion_valor" => $_SESSION['ID']
                        ]
                    ],
                    [
                        "Nombre_tabla" => "ventas",
                        "Campos" => ["Monto_total", "Fecha", "ID_Ventas"],
                        "Parametros_viculantes" => [["usuario", "ID_Usuario"]]
                    ],
                    [
                        "Nombre_tabla" => "estado_venta",
                        "Campos" => ["Estado"],
                        "Parametros_viculantes" => [["ventas", "ID_Estado_Venta"]],
                        "Condicion" => [
                            "Condicion_tipo" => "nada",
                            "Condicion_nombre" => "ID_Estado_Venta",
                            "Condicion_marcador" => "ID_est_venta",
                            "Condicion_valor" => 3
                        ]
                    ]
                ];
            
                $pedidos = $this->innerJoinTablas($tablas);
            
                $tabla = '<table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">ID_Venta</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>';
            
                        $ventas = [];
        
                        foreach ($pedidos as $venta) {
                            if (!in_array($venta['ID_Ventas'], $ventas)) {
                                $ventas[] = $venta['ID_Ventas'];
                                $tabla .= '<tr>
                                    <td>' . htmlspecialchars($venta['Nombre_Usuario']) . '</td>
                                    <td>' . htmlspecialchars($venta['ID_Ventas']) . '</td>
                                    <td>' . htmlspecialchars($venta['Monto_total']) . '</td>
                                    <td>' . htmlspecialchars($venta['Fecha']) . '</td>
                                    <td>' . htmlspecialchars($venta['Estado']) . '</td>
                                </tr>';
                            }
                        }
                        
            
                $tabla .= '</tbody></table>';
                echo $tabla;
        }

    }

