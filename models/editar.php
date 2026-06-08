<?php
include "conexion.php";
$cedula = $_POST["ced_est"];
$nombre = $_POST["nom_est"];
$apellido = $_POST["ape_est"];   
$telefono = $_POST["tel_est"];
$direccion = $_POST["dir_est"];
$SqlUpdate = "UPDATE estudiantes SET nom_est='$nombre', 
                                     ape_est='$apellido', 
                                     tel_est='$telefono', 
                                     dir_est='$direccion' 
              WHERE ced_est='$cedula'";
if ($conn->query($SqlUpdate) === TRUE) {
    echo json_encode(array("success" => true, "message" => "Estudiante actualizado correctamente"));
} else {
    echo json_encode(array("errorMsg" => "Error al actualizar el estudiante: " . $conn->error));
}
?>