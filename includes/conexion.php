<?php
$con = new mysqli("localhost", "root", "", "gimnasio");
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}
?>
