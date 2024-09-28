<div class="contenedor_clientes">
    <div class="lado_izquierdo_clientes">
        <div class="busqueda_container_clientes" id="busqueda_container_clientes">
            <input type="text" id="buscar_ci_clientes" placeholder="Introduce el CI">
            <button onclick="buscarCliente()">Buscar</button>
        </div>
        <div id="info_cliente">
            <!-- Información adicional del cliente si es necesario -->
        </div>
    </div>

    <div class="lado_derecho_clientes" id="lado_derecho_clientes">
        <div class="filtros_clientes" id="filtros_clientes">
            <div class="filtro_cuadro_clientes" onclick="flitroCliente(1)" id="filtro_1">Filtrar por Activos</div>
            <div class="filtro_cuadro_clientes" onclick="flitroCliente(2)" id="filtro_2">Filtrar por Inactivos</div>
            <div class="filtro_cuadro_clientes" onclick="flitroCliente(3)" id="filtro_3">Filtrar por Próximos a Vencer</div>
            <div class="filtro_cuadro_clientes" onclick="flitroCliente(4)" id="filtro_4">Todos</div>
        </div>
        
        <div id="tabla_clientes_contenedor">
            <?php
            // Consulta para obtener todos los clientes
            $sql_clientes = "SELECT id_cliente, nombre, telefono, ci, fecha_registro, dias_restantes FROM clientes";
            $result_clientes = $con->query($sql_clientes);

            if ($result_clientes->num_rows > 0) {
            ?>
                <table id="tabla_clientes">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>CI</th>
                            <th>Fecha de Registro</th>
                            <th>Días Restantes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_clientes->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row["nombre"]; ?></td>
                                <td><?php echo $row["telefono"]; ?></td>
                                <td><?php echo $row["ci"]; ?></td>
                                <td><?php echo $row["fecha_registro"]; ?></td>
                                <td><?php echo $row["dias_restantes"]; ?></td>
                                <td class="acciones">
                                    <button class="accion_boton" onclick="cargarFormularioEdicion(<?php echo $row['id_cliente']; ?>)">
                                        <img class="sin_nada" src="img/pagina/editar.png" alt="Editar" style="width: 24px; height: 24px;">
                                    </button>
                                    <button class="accion_boton" onclick="eliminarUsuario(<?php echo $row['id_cliente']; ?>)">
                                        <img class="sin_nada" src="img/pagina/eliminar.png" alt="Eliminar" style="width: 24px; height: 24px;">
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "<div id='no_clientes_msg' style='color:red; font-size: 24px;'>No hay clientes registrados.</div>";
            }
            mysqli_close($con);
            ?>
        </div>
    </div>
</div>
