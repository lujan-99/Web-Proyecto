<?php
include('../includes/conexion.php');

// Recuperar los datos del formulario
$nombre_plan = $_POST['nombre_plan'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$duracion = $_POST['duracion'];

// Manejo del archivo de imagen
$imagen = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];

// Guardar la imagen en una carpeta del servidor
$directorio = "../img/pagina/";
$ruta_imagen = $directorio . basename($imagen);
move_uploaded_file($imagen_temp, $ruta_imagen);

// Insertar el nuevo plan en la base de datos
$sql_insert = "INSERT INTO planes_suscripcion (nombre_plan, descripcion, precio, duracion, estado_plan, imagen) 
            VALUES ('$nombre_plan', '$descripcion', '$precio', '$duracion', 'activo', '$imagen')";

if ($con->query($sql_insert) === TRUE) {
    echo "Plan creado exitosamente";
} else {
    echo "Error: " . $con->error;
}

$con->close();
?>
