<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuartob";
$mysql = new mysqli($servername, $username, $password, $dbname);
$conn=mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>