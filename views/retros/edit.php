<?php

require_once __DIR__ . '/../../models/RetroItem.php';


if (!isset($db)) {

    require_once __DIR__ . '/../../config/database.php';

    $database = new Database();
    $db = $database->connect();
}


$retroModel = new RetroItem($db);

$id = $_GET['id'];
$sprint_id = $_GET['sprint_id'];

$item = $retroModel->getById($id);

?>

<h2>Editar Item</h2>

<a href="index.php?page=retros&sprint_id=<?= $sprint_id ?>">
    ← Volver
</a>

<br><br>

<form method="POST"
      action="/taller_base_datos_monolitico/controllers/RetroController.php">

    <input
        type="hidden"
        name="edit_id"
        value="<?= $id ?>"
    >

    <input
        type="hidden"
        name="sprint_id"
        value="<?= $sprint_id ?>"
    >

    <select name="categoria" required>

        <option value="logro"
            <?= $item['categoria'] == 'logro' ? 'selected' : '' ?>>
            Logro
        </option>

        <option value="impedimento"
            <?= $item['categoria'] == 'impedimento' ? 'selected' : '' ?>>
            Impedimento
        </option>

        <option value="accion"
            <?= $item['categoria'] == 'accion' ? 'selected' : '' ?>>
            Acción
        </option>

    </select>

    <br><br>

    <textarea
        name="descripcion"
        required><?= $item['descripcion'] ?></textarea>

    <br><br>

    <button type="submit">
        Actualizar
    </button>

</form>