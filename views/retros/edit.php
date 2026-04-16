<?php
require_once '../models/RetroItem.php';

$retroModel = new RetroItem($db);

$id = $_GET['id'];
$sprint_id = $_GET['sprint_id'];

$item = $retroModel->getById($id);
?>

<h2>Editar Item</h2>

<form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
    <input type="hidden" name="edit_id" value="<?= $id ?>">
    <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">

    <select name="categoria">
        <option value="logro" <?= $item['categoria']=='logro'?'selected':'' ?>>Logro</option>
        <option value="impedimento" <?= $item['categoria']=='impedimento'?'selected':'' ?>>Impedimento</option>
        <option value="accion" <?= $item['categoria']=='accion'?'selected':'' ?>>Acción</option>
    </select>

    <textarea name="descripcion"><?= $item['descripcion'] ?></textarea>

    <button>Actualizar</button>
</form>