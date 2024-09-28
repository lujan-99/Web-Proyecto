<?php include('conexion.php'); ?>
            <div class="container_nuevo_suscripcion">
                <div class="row_nuevo_suscripcion">
                    <h2 style="color: white;">Nuevo Cliente</h2>
                    <form action="javascript:crearCliente()" method="POST" id="form-nuevo">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" required><br>

    <label for="ci">CI:</label>
    <input type="text" id="ci" name="ci" required><br>

    <input type="submit" value="Insertar Cliente">
</form>
                </div>
                <div class="row_nuevo_suscripcion">
                    <?php
                    
                    $sql = "SELECT id_plan, nombre_plan, descripcion, precio, duracion, imagen FROM planes_suscripcion WHERE estado_plan = 'activo'";
                    $result = $con->query($sql);

                    echo '<select name="plan_suscripcion" id="plan_suscripcion" onchange="planSeleccionado();">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_plan'] . '">' . $row['nombre_plan'] . ' - $' . $row['precio'] . '</option>';
                    }
                    echo '</select>';

                    $con->close();
                    ?>
                    <div id="detalle_plan">

                    </div>
                </div>
                <div class="row_nuevo_suscripcion" id="img-plan">
                    
                </div>
                