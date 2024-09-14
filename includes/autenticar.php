<?php session_start();
$nombre=$_POST['nombre'];
$contrasena=sha1($_POST['contrasena']);
include('conexion.php');
$sql="SELECT nombre_usuario,tipo_usuario_id from usuarios where nombre_usuario='$nombre' 
and contrasena='$contrasena'";


$result = $con->query($sql);


if ($result->num_rows > 0) {
    $datos = $result->fetch_assoc();
    $_SESSION['nombre']=$datos['nombre_usuario'];
    $_SESSION['nivel']=$datos['tipo_usuario_id'];
    header("location:../inicio.php");
}
else
{?>
  Error usuario o Conatraseña no valido 
  <meta http-equiv="refresh" content="1; url=../login.html">
<?php
}

?>
