<?php

require_once '../models/RetroItem.php';

$retroModel = new RetroItem($db);

$id = $_GET['id'];
$sprint_id = $_GET['sprint_id'];

$item = $retroModel->getById($id);
?>
<h2 class="section-title">Editar Aporte</h2>
<div class="card">
    <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
        <input type="hidden" name="edit_id" value="<?= $id ?>">
        <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
        <div class="form-group">
            <label>Tipo de aporte</label>
            <select name="categoria">
                <option value="logro" <?= $item['categoria']=='logro'?'selected':'' ?>>Logro</option>
                <option value="impedimento" <?= $item['categoria']=='impedimento'?'selected':'' ?>>Impedimento</option>
                <option value="accion" <?= $item['categoria']=='accion'?'selected':'' ?>>Acción</option>
                <option value="comentario" <?= $item['categoria']=='comentario'?'selected':'' ?>>Comentario</option>
                <option value="otro" <?= $item['categoria']=='otro'?'selected':'' ?>>Otro</option>
            </select>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion"><?= $item['descripcion'] ?></textarea>
        </div>
        <button class="btn-primary">Actualizar</button>
    </form>
</div>