
<?php
require_once '../models/RetroItem.php';

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
<h2 class="section-title">Retrospectiva del Sprint</h2>
<a class="btn-secondary" href="index.php">← Volver</a>
<div class="card">
    <h3>Nuevo Aporte</h3>
    <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
        <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
        <div class="form-group">
            <label>Categoría</label>
            <select name="categoria" required>
                <option value="logro">Logro</option>
                <option value="impedimento">Impedimento</option>
                <option value="accion">Acción</option>
            </select>
        </div>
        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion" placeholder="Escribe aquí..." required></textarea>
        </div>
        <button class="btn-primary" type="submit">Guardar</button>
    </form>
</div>
<div class="card">
    <h3> Acciones del Sprint Anterior</h3>
    <ul class="simple-list">
        <?php while ($row = $prevActions->fetch(PDO::FETCH_ASSOC)): ?>
            <li><?= $row['descripcion'] ?></li>
        <?php endwhile; ?>
    </ul>
</div>
<div class="categories-grid">
    <div class="card">
        <h3>✔ Logros</h3>
        <ul class="item-list">
            <?php foreach ($logros as $item): ?>
                <li class="retro-item">
                    <span><?= $item['descripcion'] ?></span>
                    <div class="item-actions">
                        <form method="GET" action="/taller_base_datos_monolitico/public/index.php">
                            <input type="hidden" name="page" value="edit-retro">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                            <button type="submit"></button>
                        </form>
                        <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
                            <input type="hidden" name="delete_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                            <button type="submit">🗑</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="card">
        <h3>⚠ Impedimentos</h3>
        <ul class="item-list">
            <?php foreach ($impedimentos as $item): ?>
                <li class="retro-item">
                    <span><?= $item['descripcion'] ?></span>
                    <div class="item-actions">
                        <form method="GET" action="/taller_base_datos_monolitico/public/index.php">
                            <input type="hidden" name="page" value="edit-retro">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                            <button type="submit">✏</button>
                        </form>
                        <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
                            <input type="hidden" name="delete_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                            <button type="submit">🗑</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="card">
        <h3> Acciones</h3>
        <ul class="item-list">
            <?php foreach ($acciones as $item): ?>
                <li class="retro-item">
                    <span><?= $item['descripcion'] ?></span>
                    <div class="item-actions">
                        <?php if ($item['cumplida']): ?>
                            <span class="status-ok">✔ Cumplida</span>
                        <?php else: ?>
                            <span class="status-pending"> Pendiente</span>
                            <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
                                <input type="hidden" name="cumplir_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                                <button type="submit">✔</button>
                            </form>
                        <?php endif; ?>
                        <form method="GET" action="/taller_base_datos_monolitico/public/index.php">
                            <input type="hidden" name="page" value="edit-retro">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                            <button type="submit">✏</button>
                        </form>
                        <form method="POST" action="/taller_base_datos_monolitico/controllers/RetroController.php">
                            <input type="hidden" name="delete_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="sprint_id" value="<?= $sprint_id ?>">
                            <button type="submit">🗑</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>