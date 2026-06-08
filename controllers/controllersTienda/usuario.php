<?php
require_once "models/modelsTienda/usuario.php";
class UsuarioController {
    public static function login(){
        if(isset($_POST["usuario"])){
            $usuario = $_POST["usuario"];
            $clave = $_POST["clave"];
            $respuesta = UsuarioModel::login($usuario,$clave);
            if($respuesta){
                $_SESSION["id"] = $respuesta["id_usu"];
                $_SESSION["usuario"] = $respuesta["nom_usu"];
                $_SESSION["apellido"] = $respuesta["ape_usu"];
                $_SESSION["rol"] = $respuesta["rol_usu"];
               if($respuesta["rol_usu"] == "administrador"){
                    header("Location:index.php?option=Productos");
                }else{
                    header("Location:index.php?option=Nosotros");
                }
                exit();
            }else{
                echo "<p style='color:red'>Usuario o contraseña incorrectos</p>";
            }
        }
    }
}