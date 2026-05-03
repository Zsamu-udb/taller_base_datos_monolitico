<?php

require_once '../models/RetroItem.php';

$retroModel = new RetroItem($db);

$sprint_id = $_GET['sprint_id'] ?? null;
if (!$sprint_id) {
    echo "<p>Sprint no válido.!!!</p>";
    return;
}
$prevActions = null;
if ($sprint_id > 1) {
    $prevActions = $retroModel->getPreviousActions($sprint_id);
}
?>
<h2>SPRINT <?= $sprint_id ?></h2>
<hr>
<?php if ($sprint_id > 1 && $prevActions): ?>
<h3>Compromisos del sprint anterior</h3>
<ul>
<?php while ($row = $prevActions->fetch(PDO::FETCH_ASSOC)): ?>
    <li>
        <?= htmlspecialchars($row['descripcion']) ?>
        <?php if ($row['cumplida'] === null): ?>
            <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
                <input type="hidden" name="cumplir_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                <button>✔</button>
            </form>
            <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
                <input type="hidden" name="no_cumplir_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                <button>✖</button>
            </form>
        <?php elseif ($row['cumplida'] == 1): ?>
            ✔ Cumplida
        <?php else: ?>
            ✖ No cumplida
        <?php endif; ?>
    </li>
<?php endwhile; ?>
</ul>
<hr>
<?php endif; ?>
<h3>Registrar nuevo aporte</h3>
<form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
    <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
    <textarea name="descripcion" placeholder="Ingrese su nuevo aporte..." required></textarea>
    <br><br>
    <label>Tipo de aporte</label>
    <select name="categoria" required>
        <option value="">Tipo de aporte</option>
        <option value="logro">Logro</option>
        <option value="impedimento">Impedimento</option>
        <option value="accion">Acción</option>
        <option value="comentario">Comentario</option>
        <option value="otro">Otro</option>
    </select>
    <br><br>
    <label>Fecha ingreso del aporte</label>
    <input type="date" name="fecha_ingreso_nuevo_aporte" required>
    <br><br>
    <button type="submit">Guardar aporte</button>
    <br><br>
    
</form>
<br>
<?php if (!isset($_GET['ver'])): ?>
    <a href="?page=retros&sprint_id=<?= $sprint_id ?>&ver=1">
        <button type="button" > Ver todos los aportes </button>
        <br> <br>
        
        <a href="<?= dirname($_SERVER['PHP_SELF']) ?>/index.php">
             <button type="button">Volver</button>
        </a>
        
    </a>
<?php else: ?>
    <a href="?page=retros&sprint_id=<?= $sprint_id ?>">
        <button type="button" > Ocultar aportes </button>
    </a>
<?php endif; ?>
<br><br>
<?php
if (isset($_GET['ver'])) {
    $result = $retroModel->getBySprint($sprint_id);
    $logros = [];
    $impedimentos = [];
    $acciones = [];
    $comentarios = [];
    $otros = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        switch ($row['categoria']) {
            case 'logro': $logros[] = $row; break;
            case 'impedimento': $impedimentos[] = $row; break;
            case 'accion': $acciones[] = $row; break;
            case 'comentario': $comentarios[] = $row; break;
            case 'otro': $otros[] = $row; break;
        }
    }
?>
<hr>
<h3>Aportes del Sprint</h3>
<h4>Logros</h4>
<ul>
<?php foreach ($logros as $item): ?>
    <li>
        <?= htmlspecialchars($item['descripcion']) ?>

        <a href="?page=edit-retro&id=<?= $item['id'] ?>&sprint_id=<?= $sprint_id ?>">Editar</a>
    </li>
<?php endforeach; ?>
</ul>
<h4>Impedimentos</h4>
<ul>
<?php foreach ($impedimentos as $item): ?>
    <li>
        <?= htmlspecialchars($item['descripcion']) ?>
        <a href="?page=edit-retro&id=<?= $item['id'] ?>&sprint_id=<?= $sprint_id ?>">Editar</a>
    </li>
<?php endforeach; ?>
</ul>
<h4>Acciones</h4>
<ul>
<?php foreach ($acciones as $item): ?>
    <li>
        <?= htmlspecialchars($item['descripcion']) ?>
        <?php if (!empty($item['cumplida'])): ?>
            ✔
        <?php else: ?>
            ❌
        <?php endif; ?>
        <a href="?page=edit-retro&id=<?= $item['id'] ?>&sprint_id=<?= $sprint_id ?>">Editar</a>
    </li>
<?php endforeach; ?>
</ul>
<h4>Comentarios</h4>
<ul>
<?php foreach ($comentarios as $item): ?>
    <li>
        <?= htmlspecialchars($item['descripcion']) ?>
        <a href="?page=edit-retro&id=<?= $item['id'] ?>&sprint_id=<?= $sprint_id ?>">Editar</a>
    </li>
<?php endforeach; ?>
</ul>
<h4>Otros</h4>
<ul>
<?php foreach ($otros as $item): ?>
    <li>
        <?= htmlspecialchars($item['descripcion']) ?>
        <a href="?page=edit-retro&id=<?= $item['id'] ?>&sprint_id=<?= $sprint_id ?>">Editar</a>
    </li>
<?php endforeach; ?>
</ul>
    <a href="<?= dirname($_SERVER['PHP_SELF']) ?>/index.php">
     <button type="button">Volver</button>
     </a>
<?php } ?>