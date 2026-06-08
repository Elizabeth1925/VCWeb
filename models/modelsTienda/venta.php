<?php
require_once "config/conexionTienda.php";
class VentaModel{
    public static function guardarVenta($datos){
        $conexion = Conexion::conectar();
        $stmt = $conexion->prepare(
            "INSERT INTO ventas(
                id_usu_per,
                fec_ven,
                tot_ven
            )
            VALUES(
                :usuario,
                :fecha,
                :total
            )"
        );
        $stmt->bindParam(":usuario",$datos["usuario"]);
        $stmt->bindParam(":fecha",$datos["fecha"]);
        $stmt->bindParam(":total",$datos["total"]);
        $stmt->execute();
        return $conexion->lastInsertId();
    }
    public static function guardarDetalle($datos){
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO detalle(
                id_ven_per,
                id_pro_per,
                can_det,
                sub_det
            )
            VALUES(
                :venta,
                :producto,
                :cantidad,
                :subtotal
            )"
        );
        $stmt->bindParam(":venta",$datos["venta"]);
        $stmt->bindParam(":producto",$datos["producto"]);
        $stmt->bindParam(":cantidad",$datos["cantidad"]);
        $stmt->bindParam(":subtotal",$datos["subtotal"]);
        return $stmt->execute();
    }
      public static function siguienteFactura(){

    $stmt = Conexion::conectar()->prepare(
        "SELECT IFNULL(MAX(id_ven),0)+1 AS siguiente
         FROM ventas"
    );

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}