<?php
include('conexion.php');

// Obtener los datos del formulario
$id_plan = $_POST['id_plan'];
$nombre_plan = $_POST['nombre_plan'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$duracion = $_POST['duracion'];

// Manejar la imagen si se subió una nueva
if (!empty($_FILES['imagen']['name'])) {
    $imagen = $_FILES['imagen']['name'];
    $ruta_imagen = "ruta/imagenes/" . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);

    // Actualizar el plan con imagen
    $sql = "UPDATE planes_suscripcion 
            SET nombre_plan = '$nombre_plan', descripcion = '$descripcion', precio = '$precio', duracion = '$duracion', imagen = '$ruta_imagen'
            WHERE id_plan = $id_plan";
} else {
    // Actualizar el plan sin cambiar la imagen
    $sql = "UPDATE planes_suscripcion 
            SET nombre_plan = '$nombre_plan', descripcion = '$descripcion', precio = '$precio', duracion = '$duracion'
            WHERE id_plan = $id_plan";
}

if ($con->query($sql) === TRUE) {
    echo "Plan actualizado correctamente";
} else {
    echo "Error al actualizar el plan: " . $con->error;
}

$con->close();
?>
