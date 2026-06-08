<?php
class Conexion {
    public static function conectar() {
        $conexion = new PDO(
            "mysql:host=localhost;dbname=tienda",
            "root",
            ""
        );
        $conexion->exec("SET NAMES utf8");
        return $conexion;
    }
}