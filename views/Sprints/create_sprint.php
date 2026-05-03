<h2>Crear Nuevo Sprint</h2>

<form method="POST" action="/taller_base_datos_monolitico/controllers/retroController.php">

    <label>Nombre del Sprint</label>
    <input type="text" name="nombre" required>

    <label>Fecha inicio</label>
    <input type="date" name="fecha_inicio" required>

    <label>Fecha fin</label>
    <input type="date" name="fecha_fin" required>

    <button type="submit">Guardar Sprint</button>
</form>

<br>
<a href="/taller_base_datos_monolitico/public/index.php">← Volver</a>