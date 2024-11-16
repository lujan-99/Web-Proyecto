<?php
include("../includes/inicio.php");
?>
<div id="info-gym">
    <div id="info-usuarios">
        <div class="datos-usuarios">
            <img src="img/iconos/usuarios.png" alt="usuarios" class="iconos">
            <div style="margin: 15px;">
                <span class="letra-especial">
                    <?php echo $row2['total_clientes_activos']; ?>
                </span><br>
                Usuarios Activos
            </div>
        </div>
        <div class="datos-usuarios">
            <img src="img/iconos/usuarios-nuevos.png" alt="usuarios" class="iconos">
            <div style="margin: 15px;">
                <span class="letra-especial">
                    <?php echo $row1['total_inscripciones']; ?>
                </span><br>
                Usuarios Totales
            </div>
        </div>
    </div>
    <?php
//session_start(); // Asegúrate de que la sesión esté iniciada

// Verificar si el usuario es 'root'
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'root') {
    ?>

<div id="info-ganancias">
        Ganancias Totales
        <span class="letra-especial" style="color: black;">
            <?php echo $ganancias; ?> Bs.
        </span><br>
        <img src="img/iconos/dinero.png" alt="dinero" class="iconos">
    </div>
<?php
}
?>
    
</div>

<div style="width: 50%; display: flex; flex-direction: column; align-items: center;">
    <div style="color:red; margin: 20px; font-size: 40px;">
        Vencen este mes
    </div>
    
    <?php if ($result_vencimientos->num_rows > 0) { ?>
        <ul style="list-style: none; padding: 0; width: 100%;">
            <?php while ($row4 = $result_vencimientos->fetch_assoc()) { ?>
                <li style="margin-bottom: 10px;">
                    <div class="usuarios-vencimiento">
                        <img src="img/iconos/peligro.png" alt="Peligro" style="width: 48px; padding:15px;">
                        <div class="info">
                            <div class="renovacion-nombre"><?php echo $row4["nombre"]; ?></div>
                            <div class="renovacion-fecha">Días Restantes: <?php echo $row4["dias_restantes"]; ?></div>
                        </div>
                        <a href="editar.php?id=<?php echo $row4["id_cliente"]; ?>" class="boton-renovacion">Renovar</a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <div style='color: rgb(8, 230, 219); font-size: 24px;'>No hay vencimientos este mes.</div>
        <img src='img/iconos/bien.png' style='width: 320px; padding:15px;'>
    <?php } ?>
    
    <?php mysqli_close($con); ?>
</div>
