<?php include('conexion.php'); ?>
<div class="container_nuevo_suscripcion">
    <div class="row_nuevo_suscripcion">
        <h2 style="color: white;">Buscar CLiente</h2>
        <div id="Info_Renovacion">
        <button class= "cancelar" onclick= "cargar('pantalla_inscripciones.php')"> Cancelar </button>
        <button id="buscar-largo" onclick="buscarClienteRenovacion()">Buscar:</button>
        <input style=" width: 95%; height: 30px;" type="text" id="buscar_id" name="buscar" oninput="autocompletarClienteRenovacion(event)"><br>
        <div id="edicion"></div>
        </div>
        <!-- Reemplazado el formulario por un checkbox -->
        
    </div>
    <div class="row_nuevo_suscripcion">
        <?php
        $sql = "SELECT id_plan, nombre_plan, descripcion, precio, duracion, imagen FROM planes_suscripcion WHERE estado_plan = 'activo'";
        $result = $con->query($sql);

        echo '<select name="plan_suscripcion" id="plan_suscripcion" onchange="planSeleccionado();">';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id_plan'] . '">' . $row['nombre_plan'] . ' - Bs' . $row['precio'] . '</option>';
        }
        echo '</select>';

        $con->close();
        ?>
        <div id="detalle_plan">
        </div>
    </div>
    <div class="row_nuevo_suscripcion" id="img-plan">
    </div>
</div>
