<?php

require_once '../models/RetroItem.php';

$retroModel = new RetroItem($db);

$id = $_GET['id'] ?? null;
$sprint_id = $_GET['sprint_id'] ?? null;

if (!$id) {
    echo "<p>Aporte no válido.</p>";
    return;
}
$item = $retroModel->getById($id);
?>
<h2>Editar Aporte</h2>
<form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
    <input type="hidden" name="edit_id" value="<?= $id ?>">
    <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
    <textarea name="descripcion" required>
<?= htmlspecialchars($item['descripcion']) ?>
    </textarea>
    <br><br>
    <select name="tipo de aporte" required>
        <option value="logro" <?= $item['categoria']=='logro'?'selected':'' ?>>Logro</option>
        <option value="impedimento" <?= $item['categoria']=='impedimento'?'selected':'' ?>>Impedimento</option>
        <option value="accion" <?= $item['categoria']=='accion'?'selected':'' ?>>Acción</option>
        <option value="comentario" <?= $item['categoria']=='comentario'?'selected':'' ?>>Comentario</option>
        <option value="otro" <?= $item['categoria']=='otro'?'selected':'' ?>>Otro</option>
    </select>
    <br><br>
    <button type="submit">Actualizar</button>
</form>
<br>