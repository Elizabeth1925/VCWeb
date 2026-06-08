<?php
class Controller{
    public function Plantilla(){
        include "views/template.php";
    }
 public function EnlacesPaginasController(){
     if(isset($_GET["option"])){
         $enlacesController = $_GET["option"];
     }else{
         $enlacesController = "Inicio.php";
     }
     $respuesta = EnlacesPaginas::EnlacesPaginasModel($enlacesController);
     include $respuesta;
 }   
}
?>