<?php
include "conexion.php";
$cedula = $_GET["ced_est"];
$SqlDelete = "DELETE FROM estudiantes WHERE ced_est='$cedula'";
if ($conn->query($SqlDelete) === TRUE) {
    echo json_encode(array("success" => true, "message" => "Estudiante eliminado correctamente"));
} else {
    echo json_encode(array("errorMsg" => "Error al eliminar el estudiante: " . $conn->error));
}
?>