<?php

include "conexion.php";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;

$offset = ($page - 1) * $rows;

$where = "";

if(isset($_REQUEST['cedula']) && !empty(trim($_REQUEST['cedula']))){
    
    $cedula = trim($_REQUEST['cedula']);
    $cedula = $conn->real_escape_string($cedula);

    $where = " WHERE ced_est LIKE '%$cedula%'";
}

/* TOTAL DE REGISTROS */
$sqlTotal = "SELECT COUNT(*) as total FROM estudiantes $where";
$resTotal = $conn->query($sqlTotal);
$rowTotal = $resTotal->fetch_assoc();
$total = $rowTotal['total'];

/* CONSULTA CON LIMIT */
$sql = "SELECT * FROM estudiantes $where LIMIT $offset, $rows";

$respuesta = $conn->query($sql);

$resultado = array();
$resultado["total"] = $total;
$resultado["rows"] = array();

while($fila = $respuesta->fetch_assoc()){
    $resultado["rows"][] = $fila;
}

echo json_encode($resultado);

?>