<?php
require_once "models/modelsTienda/venta.php";
class VentaController
{
    public static function finalizarCompra()
    {
        if (isset($_POST["finalizarCompra"])) {
            if (empty($_SESSION["factura"])) {
                return;
            }
            $total = 0;
            foreach ($_SESSION["factura"] as $item) {
                $total += $item["subtotal"];
            }
            $datosVenta = array(
                "usuario" => $_SESSION["id"],
                "fecha" => date("Y-m-d"),
                "total" => $total
            );
            $idVenta = VentaModel::guardarVenta($datosVenta);
            foreach ($_SESSION["factura"] as $item) {
                $detalle = array(
                    "venta" => $idVenta,
                    "producto" => $item["id"],
                    "cantidad" => $item["cantidad"],
                    "subtotal" => $item["subtotal"]
                );
                VentaModel::guardarDetalle($detalle);
            }
            $_SESSION["ultimaFactura"] = $idVenta;
            $_SESSION["facturaImpresion"] = $_SESSION["factura"];
            $_SESSION["compraFinalizada"] = true;
            $_SESSION["factura"] = [];
            header("Location:index.php?option=Nosotros");
            exit();
        }
    }
    public static function obtenerSiguienteFactura()
    {
        return VentaModel::siguienteFactura();
    }
}
