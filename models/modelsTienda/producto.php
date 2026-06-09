<?php
require_once "config/conexionTienda.php";
class ProductoModel{
    public static function listar($soloActivos = false){
        if($soloActivos){
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM productos WHERE est_pro='Activo'"
            );
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM productos"
            );
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function guardar($datos){
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO productos(nom_pro,des_pro,pre_pro,ima_pro)
             VALUES(:nombre,:descripcion,:precio,:imagen)"
        );
        $stmt->bindParam(":nombre",$datos["nombre"]);
        $stmt->bindParam(":descripcion",$datos["descripcion"]);
        $stmt->bindParam(":precio",$datos["precio"]);
        $stmt->bindParam(":imagen",$datos["imagen"]);
        return $stmt->execute();
    }

    public static function eliminar($id){
        $stmt = Conexion::conectar()->prepare(
            "UPDATE productos SET est_pro='Inactivo' WHERE id_pro=:id"
        );
        $stmt->bindParam(":id",$id);
        return $stmt->execute();
    }

    public static function cambiarEstado($id, $estado){
        $stmt = Conexion::conectar()->prepare(
            "UPDATE productos SET est_pro=:estado WHERE id_pro=:id"
        );
        $stmt->bindParam(":estado",$estado);
        $stmt->bindParam(":id",$id);
        return $stmt->execute();
    }

    public static function buscarPorId($id){
    $stmt = Conexion::conectar()->prepare(
        "SELECT * FROM productos
         WHERE id_pro = :id"
    );
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function actualizar($datos){
    $stmt = Conexion::conectar()->prepare(
        "UPDATE productos
        SET nom_pro=:nombre,
            des_pro=:descripcion,
            pre_pro=:precio,
            ima_pro=:imagen
        WHERE id_pro=:id"
    );
    $stmt->bindParam(":nombre",$datos["nombre"]);
    $stmt->bindParam(":descripcion",$datos["descripcion"]);
    $stmt->bindParam(":precio",$datos["precio"]);
    $stmt->bindParam(":imagen",$datos["imagen"]);
    $stmt->bindParam(":id",$datos["id"]);
    return $stmt->execute();
    }
}