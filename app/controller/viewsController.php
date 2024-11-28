<?php 
namespace app\controller;

use app\models\viewsModel;

class viewsController extends viewsModel {

    public function traerVista($vista) {
        
        if ($vista != "") {
            $respuesta = $this->mostrarVista($vista);
        }else{
            $respuesta = "home";
        }
        return $respuesta;
    }

}
?>
