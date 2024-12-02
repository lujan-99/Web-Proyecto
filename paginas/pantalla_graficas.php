<div style="display: flex; flex-direction: column; align-items: center; gap: 20px; width: 100%; max-width: 900px; margin: 0 auto;">

    <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
            <h2 style="color: #333333; margin: 0;">Gráfica 1</h2>
            <select id="select-grafica-1" onchange="updateImageSrc('select-grafica-1', 'img-grafica-1', 'graficas/grafica1.php')">
                <option value="nochance">Todos</option>
                <option value="1">Del mes</option>
                <option value="2">De la semana</option>
                <option value="3">Del dia</option>
            </select>
        </div>
        <img id="img-grafica-1" src="graficas/grafica1.php" alt="Gráfica 1" style="width: 100%; height: auto;">
    </div>

    <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
            <h2 style="color: #333333; margin: 0;">Gráfica 2</h2>
            <select id="select-grafica-2" onchange="updateImageSrc('select-grafica-2', 'img-grafica-2', 'graficas/grafica2.php')">
                <option value="nochance">Suscripciones generales</option>
                <option value="1">Suscripciones solo clientes activos</option>
                <option value="2">Suscripciones Activas</option>
            </select>
        </div>
        <img id="img-grafica-2" src="graficas/grafica2.php" alt="Gráfica 2" style="width: 100%; height: auto;">
    </div>

    <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
            <h2 style="color: #333333; margin: 0;">Gráfica 3</h2>
            <select id="select-grafica-3" onchange="updateImageSrc('select-grafica-3', 'img-grafica-3', 'graficas/grafica3.php')">
                <option value="nochance">Avtivos Inactivos</option>
                <option value="1">Proximos a vencer</option>
                <option value="2">Con dias activos</option>
                <!-- <option value="opcion3">Opción 3</option> -->
            </select>
        </div>
        <img id="img-grafica-3" src="graficas/grafica3.php" alt="Gráfica 3" style="width: 100%; height: auto;">
    </div>

    <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
            <h2 style="color: #333333; margin: 0;">Gráfica 4</h2>
            <!-- <select id="select-grafica-4" onchange="updateImageSrc('select-grafica-4', 'img-grafica-4', 'graficas/grafica4.php')">
                <option value="">Todos</option>
                <option value="root">Root</option>
                <option value="Juan">Juan</option>
                <option value="Daniel">Daniel</option>
                <option value="Maria">Maria</option>
            </select> -->
        </div>
        <img id="img-grafica-4" src="graficas/grafica4.php" alt="Gráfica 4" style="width: 100%; height: auto;">
    </div>

    <!-- <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
            <h2 style="color: #333333; margin: 0;">Gráfica 5</h2>
            <select id="select-grafica-5" onchange="updateImageSrc('select-grafica-5', 'img-grafica-5')">
                <option value="nochance">Sin selección</option>
                <option value="opcion1">Opción 1</option>
                <option value="opcion2">Opción 2</option>
                <option value="opcion3">Opción 3</option>
            </select>
        </div>
        <img id="img-grafica-5" src="graficas/grafica5.php" alt="Gráfica 5" style="width: 100%; height: auto;">
    </div> -->

</div>
