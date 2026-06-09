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

            $nombreProducto =
                $_SESSION["factura"][$indice]["nombre"];

            unset($_SESSION["factura"][$indice]);

            $_SESSION["factura"] =
                array_values($_SESSION["factura"]);

            $_SESSION["mensaje"] =
                "El producto <strong>".$nombreProducto."</strong> fue eliminado de la factura.";

            header("Location:index.php?option=Nosotros");
            exit();
        }
    }

    public static function vaciar(){

        if(isset($_POST["vaciar"])){

            $cantidad =
                isset($_SESSION["factura"])
                ? count($_SESSION["factura"])
                : 0;

            unset($_SESSION["factura"]);

            $_SESSION["mensaje"] =
                "Se vaciaron <strong>".$cantidad."</strong> producto(s) de la factura.";

            header("Location:index.php?option=Nosotros");
            exit();
        }
    }

}