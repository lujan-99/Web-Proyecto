<!DOCTYPE html>
<html lang="en">
<?php

include('includes/inicio.php');

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/inicio.css">
</head>

<body>
    <div id="cabeza">
        <div id="logo-usuario">
            <img src="img/pagina/logo.jpg" alt="logo" id="logo">
            <div id="nombre-usuario"><?php echo $_SESSION['nombre'] ?> : <?php echo $_SESSION['nivel']?></div>
        </div>
        <div>
            <div>Fecha</div>
            <a href="includes/cerrar.php">
                <div id="cerrar-sesion">Boton de cierre</div>
            </a>

        </div>
    </div>
    <div id="nav">
        <div class="opcion-menu">Inicio</div>
        <div class="opcion-menu">Clientes</div>
        <div class="opcion-menu">Suscripciones</div>
        <div class="opcion-menu">Pagos</div>
        <div class="opcion-menu">Configuracion</div>
    </div>
    <div style="display: flex; flex-direction: row;">
        <div id="info-gym">
            <div id="info-usuarios">
                <div class="datos-usuarios">
                    <img src="img/iconos/usuarios.png" alt="usuarios" class="iconos">
                    <div style="margin: 15px;">
                        <span class="letra-especial">
                            <?php echo $row2['total_clientes_activos'] ?>
                        </span><br>
                        Usuarios Activos
                    </div>
                </div>
                <div class="datos-usuarios">
                    <img src="img/iconos/usuarios-nuevos.png" alt="usuarios" class="iconos">
                    <div style="margin: 15px;">
                        <span class="letra-especial">
                            <?php echo $row1['total_inscripciones'] ?>
                        </span><br>
                        Usuarios Nuevos
                    </div>
                </div>
            </div>
            <div id="info-ganancias">
                Ganancias
                <span class="letra-especial" style="color: black;">
                    <?php echo $ganancias?> Bs.
                </span><br>
                <img src="img/iconos/dinero.png" alt="usuarios" class="iconos">
            </div>


        </div>
        
        <div style="width: 50%; justify-content: center; align-items: center;">
            <div style="color:red">
                Vencecn este mes
            </div>
            <?php
                if ($result_vencimientos->num_rows > 0) {
                    ?>
            <table border='1'>
                <tr>
                    <th><a href="read.php?ordenar=nombres">Id</a></th>
                    <th><a href="read.php?ordenar=apellidos">Nombre</a></th>
                    <th><a href="read.php?ordenar=sexo">Fecha de Fin</a></th>
                </tr>
                <?php
                            while ($row4 = $result_vencimientos->fetch_assoc()) {
                            ?>
                <tr>
                    <td>
                        <?php echo $row4["id"]; ?>
                    </td>
                    <td>
                        <?php echo $row4["nombre"] . $row4["apellidos"]; ?>
                    </td>
                    <td>
                        <?php echo $row4["fecha_fin"]; ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php
                    } else {
                        echo "0 resultados";
                    }
                    mysqli_close($con);
                    ?>
        </div>
    </div>
</body>

</html>