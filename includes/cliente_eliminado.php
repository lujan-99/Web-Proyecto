<?php
include("conexion.php");


$id=$_GET['id'];

$sql= "DELETE FROM  clientes where id_cliente=$id";
//echo $sql;
$result = $con->query($sql);  
if(!$result){
    die("Error al eliminar datos: " . $con->error);
}
?>
<div style='color: red; font-family: Wild Wolf; font-size: 40px; padding-top: 40px; text-align: center;' >Se elimino con exito</div>
<img src='img/iconos/bien-rojo.png' style='width: 320px; padding:15px;'>
