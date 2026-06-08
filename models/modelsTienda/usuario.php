<?php
require_once "config/conexionTienda.php";
class UsuarioModel {
    public static function login($usuario, $clave){
        $stmt = Conexion::conectar()->prepare(
            "SELECT * FROM usuarios
             WHERE nom_usu = :usuario
             AND cla_usu = :clave"
        );
        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":clave", $clave);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}