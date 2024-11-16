<?php
// Obtener ID del cliente por GET
$id_cliente = $_GET['id'];
include('conexion.php');

// Obtener los datos del cliente por su ID
$sql = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes FROM clientes WHERE ci = '$id_cliente'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Si se encuentra el cliente
    $cliente = $result->fetch_assoc();
?>

    <h2 style="color: white;">Detalles del Cliente</h2>

    <!-- Formulario para mostrar los detalles (solo lectura) -->
    <form id="form-detalles-cliente">
    <!-- ID oculto -->
    <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $cliente['id_cliente']; ?>"> <!-- Añadir id="id_cliente" -->

    <!-- Nombre -->
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" readonly>
    <br>

    <!-- Teléfono -->
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>" readonly>
    <br>

    <!-- CI -->
    <label for="ci">CI:</label>
    <input type="text" id="ci" name="ci" value="<?php echo $cliente['ci']; ?>" readonly>
    <br>

    <!-- Fecha de Registro -->
    <label for="fecha_registro">Fecha de Registro:</label>
    <input type="text" id="fecha_registro" name="fecha_registro" value="<?php echo $cliente['fecha_registro']; ?>" readonly>
    <br>

    <!-- Días Restantes -->
    <label for="dias_restantes">Días Restantes:</label>
    <input type="number" id="dias_restantes" name="dias_restantes" value="<?php echo $cliente['dias_restantes']; ?>" readonly>
    <br>
</form>


    <!-- Botón independiente para nueva inscripción -->
    <button type="button" onclick="nuevaInscripcionCliente()" id="buscar-largo2">
        Nueva Inscripción
    </button>
    <button class= "cancelar" onclick= "cargar('pantalla_inscripciones.php')"> Cancelar </button>

<?php
} else {
    // Si no se encuentra ningún cliente con ese CI
    echo "<h2 style='color: white;'>No existe ningún cliente con ese CI.</h2>";
}
$con->close();
?>
