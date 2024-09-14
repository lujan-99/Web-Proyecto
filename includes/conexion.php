<?php
$con = new mysqli("localhost", "root", "", "gimnasio");
if ($con->connect_error)
    die("conexion fallada" . $con->connect_error);
?>
