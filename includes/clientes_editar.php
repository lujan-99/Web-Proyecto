<?php
// Obtener ID del cliente por GET
$id_cliente = $_GET['id'];
include('conexion.php');

// Obtener los datos del cliente por su ID
$sql = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes FROM clientes WHERE id_cliente = $id_cliente";
$result = $con->query($sql);
$cliente = $result->fetch_assoc();
?>


    <h2  style="color: white;" >Editar Cliente</h2>

    <!-- Formulario de edición -->
    <form action="javascript:editarCliente()" method="POST"  id="form-editar">
        <!-- ID oculto -->
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">

        <!-- Nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
        <br>

        <!-- Teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>" required>
        <br>

        <!-- CI -->
        <label for="ci">CI:</label>
        <input type="text" id="ci" name="ci" value="<?php echo $cliente['ci']; ?>" required>
        <br>

        <!-- Fecha de Registro (solo lectura) -->
        <label for="fecha_registro">Fecha de Registro:</label>
        <input type="text" id="fecha_registro" name="fecha_registro" value="<?php echo $cliente['fecha_registro']; ?>" readonly>
        <br>

        <!-- Días Restantes -->
        <label for="dias_restantes">Días Restantes:</label>
        <input type="number" id="dias_restantes" name="dias_restantes" value="<?php echo $cliente['dias_restantes']; ?>" required>
        <br>

        <!-- Botón para enviar -->
        <input type="submit" value="Actualizar Cliente">
    </form>

