<?php
class FacturaController{
    public static function agregar(){
        if(isset($_POST["agregar"])){
            $producto = array(
                "id" => $_POST["id"],
                "nombre" => $_POST["nombre"],
                "precio" => $_POST["precio"],
                "cantidad" => $_POST["cantidad"],
                "subtotal" => $_POST["precio"] * $_POST["cantidad"]
            );
            $_SESSION["factura"][] = $producto;
            header("Location:index.php?option=Nosotros");
            exit();
        }
    }

    public static function eliminar(){
        if(isset($_GET["eliminar"])){
            $indice = $_GET["eliminar"];
            unset($_SESSION["factura"][$indice]);
            $_SESSION["factura"] = array_values($_SESSION["factura"]);
            header("Location:index.php?option=Nosotros");
            exit();
        }
    }

    public static function vaciar(){
        if(isset($_POST["vaciar"])){
            unset($_SESSION["factura"]);
            header("Location:index.php?option=Nosotros");
            exit();
        }
    }

}
