<div class="contenedor_clientes">
    <div class="lado_izquierdo_clientes">
        <div class="busqueda_container_clientes" id="busqueda_container_clientes">
            <input type="text" id="buscar_ci_clientes" placeholder="Introduce el CI" oninput="escribirTecla(event)">
            <button onclick="buscarCliente()">Buscar</button>
            
        </div>
        <div id="edicion" style="width: 80%; display: flex; flex-direction: column; align-items: flex-end;">
            
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
            
        </div>
        <script>
    mostrarClientes();
</script>
    </div>
</div>
