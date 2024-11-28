<?php  
    namespace app\models;

    class viewsModel{

        protected function mostrarVista($vista) {
            $contenido = ["view" => "404", "usuario" => ""];
        
            $lista_vistas_cliente = ["contacto", "home", "login", "producto", "productos", "servicios","CerrarSesion","Pedido", "pedido1","politicaPriv","miPerfil"];
            $lista_vistas_Admin = ["delUpProductos", "Admin", "newProducto","consultarVentas"];
        
            if (in_array($vista, $lista_vistas_cliente)) {
                if (file_exists("./app/view/content/" . $vista . "-view.php")) {
                    $contenido["view"] = $vista;
                    $contenido["usuario"] = "Cliente";
                }
            } elseif (in_array($vista, $lista_vistas_Admin)) {
                if (file_exists("./app/view/content/" . $vista . "-view.php")) {
                    $contenido["view"] = $vista;
                    $contenido["usuario"] = "Admin";
                }
            }
        
            return $contenido;
        }
        

    }