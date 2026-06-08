<?php
require_once "models/modelsTienda/producto.php";
class ProductoController{
    public static function listar(){
        return ProductoModel::listar();
    }
   public static function guardar(){


   

    if(
        isset($_POST["nombre"])
        && !isset($_POST["editarProducto"])
    ){


    
        $datos = array(
            "nombre"=>$_POST["nombre"],
            "descripcion"=>$_POST["descripcion"],
            "precio"=>$_POST["precio"],
            "imagen"=>$_POST["imagen"]
        );

        ProductoModel::guardar($datos);

        header("Location:index.php?option=Productos");
        exit();
    }
}
    public static function eliminar(){
    if(isset($_GET["id"])){
        ProductoModel::eliminar($_GET["id"]);
        header("Location:index.php?option=Productos");
        exit();
    }
    }

    public static function actualizar(){
    if(isset($_POST["editarProducto"])){
        $datos = array(
            "id"=>$_POST["id"],
            "nombre"=>$_POST["nombre"],
            "descripcion"=>$_POST["descripcion"],
            "precio"=>$_POST["precio"],
            "imagen"=>$_POST["imagen"]
        );
        ProductoModel::actualizar($datos);
        header("Location:index.php?option=Productos");
        exit();
    }
    }

    public static function buscarPorId($id){
    return ProductoModel::buscarPorId($id);
    }
}