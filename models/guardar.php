<?php
include "conexion.php";
$cedula = $_POST["ced_est"];
$nombre = $_POST["nom_est"];
$apellido = $_POST["ape_est"];
$telefono = $_POST["tel_est"];
$direccion = $_POST["dir_est"];
$SqlInsert = "INSERT INTO estudiantes (ced_est, nom_est, ape_est, tel_est, dir_est) VALUES ('$cedula', '$nombre', '$apellido', '$telefono', '$direccion')";
if ($conn->query($SqlInsert) === TRUE) {
    echo json_encode(array("success" => true, "message" => "Estudiante registrado correctamente"));
} else {
    echo json_encode(array("errorMsg" => "Error al registrar el estudiante: " . $conn->error));
}
?>