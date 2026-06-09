<?php
class Controller{
    public function Plantilla(){
        include "views/template.php";
    }
 public function EnlacesPaginasController(){

    if(isset($_GET["option"])){
        $enlacesController = $_GET["option"];
    }else{
        $enlacesController = "Inicio";
    }

    // PROTEGER PRODUCTOS (solo admin)
    if($enlacesController == "Productos"){

        if(!isset($_SESSION["usuario"])){

            header("Location:index.php?option=Nosotros");
            exit();

        }

        if($_SESSION["rol"] != "administrador"){

            header("Location:index.php?option=Nosotros");
            exit();

        }

    }

    $respuesta = EnlacesPaginas::EnlacesPaginasModel($enlacesController);

    include $respuesta;
}
}
?>