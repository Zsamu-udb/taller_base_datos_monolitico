<?php

require_once __DIR__ . '/../../models/RetroItem.php';

if (!isset($db)) {

    require_once __DIR__ . '/../../config/database.php';

    $database = new Database();
    $db = $database->connect();
}

$retroModel = new RetroItem($db);

$sprint_id = $_GET['sprint_id'];

$result = $retroModel->getBySprint($sprint_id);

$prevActions = $retroModel->getPreviousActions($sprint_id);

$logros = [];
$impedimentos = [];
$acciones = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

    switch ($row['categoria']) {

        case 'logro':
            $logros[] = $row;
            break;

        case 'impedimento':
            $impedimentos[] = $row;
            break;

        case 'accion':
            $acciones[] = $row;
            break;
    }
}

?>

<h2>Retrospectiva del Sprint</h2>

<a href="index.php">
    ← Volver
</a>

<br><br>

<!-- ESTO ES EL FORMULARIO -->
<form method="POST"
      action="/taller_base_datos_monolitico/controllers/RetroController.php">

    <input
        type="hidden"
        name="sprint_id"
        value="<?= $sprint_id ?>"
    >

    <select name="categoria" required>

        <option value="logro">
            Logro
        </option>

        <option value="impedimento">
            Impedimento
        </option>

        <option value="accion">
            Acción
        </option>

    </select>

    <br><br>

    <textarea
        name="descripcion"
        placeholder="Escribe aquí..."
        required></textarea>

    <br><br>

    <button type="submit">
        Guardar
    </button>

</form>

<hr>

<!-- AQUI LA PARTE DE ACCIONES ANTERIORES -->
<h3>🔁 Acciones del Sprint Anterior</h3>

<ul>

<?php while ($row = $prevActions->fetch(PDO::FETCH_ASSOC)): ?>

    <li>
        <?= $row['descripcion'] ?>
    </li>

<?php endwhile; ?>

</ul>

<hr>

<!-- AQUI LOS LOGROS -->
<h3>✔ Logros</h3>

<ul>

<?php foreach ($logros as $item): ?>

    <li>

        <?= $item['descripcion'] ?>

        <!-- POS EL EDITAR -->
        <form method="GET"
              action="/taller_base_datos_monolitico/public/index.php"
              style="display:inline;">

            <input type="hidden" name="page" value="edit-retro">

            <input type="hidden"
                   name="id"
                   value="<?= $item['id'] ?>">

            <input type="hidden"
                   name="sprint_id"
                   value="<?= $sprint_id ?>">

            <button>
                ✏
            </button>

        </form>

        <!-- POS EL ELIMINAR -->
        <form method="POST"
              action="/taller_base_datos_monolitico/controllers/RetroController.php"
              style="display:inline;">

            <input type="hidden"
                   name="delete_id"
                   value="<?= $item['id'] ?>">

            <input type="hidden"
                   name="sprint_id"
                   value="<?= $sprint_id ?>">

            <button>
                🗑
            </button>

        </form>

    </li>

<?php endforeach; ?>

</ul>

<!-- AQUI LOS IMPEDIMENTOS -->
<h3>⚠ Impedimentos</h3>

<ul>

<?php foreach ($impedimentos as $item): ?>

    <li>

        <?= $item['descripcion'] ?>

        <!-- EDITAR JEJE -->
        <form method="GET"
              action="/taller_base_datos_monolitico/public/index.php"
              style="display:inline;">

            <input type="hidden" name="page" value="edit-retro">

            <input type="hidden"
                   name="id"
                   value="<?= $item['id'] ?>">

            <input type="hidden"
                   name="sprint_id"
                   value="<?= $sprint_id ?>">

            <button>
                ✏
            </button>

        </form>

        <!-- ELIMINAR JEJE -->
        <form method="POST"
              action="/taller_base_datos_monolitico/controllers/RetroController.php"
              style="display:inline;">

            <input type="hidden"
                   name="delete_id"
                   value="<?= $item['id'] ?>">

            <input type="hidden"
                   name="sprint_id"
                   value="<?= $sprint_id ?>">

            <button>
                🗑
            </button>

        </form>

    </li>

<?php endforeach; ?>

</ul>

<!-- AQUI VAN TODAS LAS ACCIONES JEJE -->
<h3>📌 Acciones</h3>

<ul>

<?php foreach ($acciones as $item): ?>

    <li>

        <?= $item['descripcion'] ?>

        <?php if ($item['cumplida']): ?>

            ✔ Cumplida

        <?php else: ?>

            ❌ Pendiente

            <!-- AQUÍ EL MARCAR JEJE-->
            <form method="POST"
                  action="/taller_base_datos_monolitico/controllers/RetroController.php"
                  style="display:inline;">

                <input type="hidden"
                       name="cumplir_id"
                       value="<?= $item['id'] ?>">

                <input type="hidden"
                       name="sprint_id"
                       value="<?= $sprint_id ?>">

                <button>
                    ✔
                </button>

            </form>

        <?php endif; ?>

        <!-- AQUÍ EL EDITAR EDITAR -->
        <form method="GET"
              action="/taller_base_datos_monolitico/public/index.php"
              style="display:inline;">

            <input type="hidden" name="page" value="edit-retro">

            <input type="hidden"
                   name="id"
                   value="<?= $item['id'] ?>">

            <input type="hidden"
                   name="sprint_id"
                   value="<?= $sprint_id ?>">

            <button>
                ✏
            </button>

        </form>

        <!-- AQUÍ EL ELIMINAR :3-->
        <form method="POST"
              action="/taller_base_datos_monolitico/controllers/RetroController.php"
              style="display:inline;">

            <input type="hidden"
                   name="delete_id"
                   value="<?= $item['id'] ?>">

            <input type="hidden"
                   name="sprint_id"
                   value="<?= $sprint_id ?>">

            <button>
                🗑
            </button>

        </form>

    </li>

<?php endforeach; ?>

</ul>