<?php
class EnlacesPaginas{
    public static function EnlacesPaginasModel($enlacesModel){
       if(
            $enlacesModel == "Inicio" ||
            $enlacesModel == "Nosotros" ||
            $enlacesModel == "Servicios" ||
            $enlacesModel == "Contactos"
        ){
            $module = "views/".$enlacesModel.".php";
        }elseif(
            $enlacesModel == "Productos" ||
            $enlacesModel == "Compras"
        ){
            $module = "views/viewsTienda/".$enlacesModel.".php";
        }else{
            $module = "views/Inicio.php";
        }
        return $module;
    }
}
?>