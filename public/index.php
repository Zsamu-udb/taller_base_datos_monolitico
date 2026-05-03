<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../models/Sprint.php';


$db = (new Database())->connect();
$sprintModel = new Sprint($db);

$page = $_GET['page'] ?? 'home';

/* ===== RUTAS ===== */

if ($page === 'create-sprint') {
    require '../views/layout/header.php';
    require '../views/Sprints/create_sprint.php';
    require '../views/layout/footer.php';
    exit();
}

if ($page === 'retros') {
    require '../views/layout/header.php';
    require '../views/retros/index.php';
    require '../views/layout/footer.php';
    exit();
}

if ($page === 'edit-retro') {
    require '../views/layout/header.php';
    require '../views/retros/edit.php';
    require '../views/layout/footer.php';
    exit();

}
if ($page === 'create-sprint') {
    require '../views/layout/header.php';
    require '../views/Sprints/create_sprint.php';
    require '../views/layout/footer.php';
    exit();
}

if ($page === 'edit-sprint') {

    $result = $sprintModel->getAll();
    $total = $result->rowCount();

    require '../views/layout/header.php';

    if ($total == 0) {
        echo "<div class='sin-sprints'>";
        echo "<h3>Aún no hay ningún sprint creado</h3>";
        echo "</div>";
    } else {
        require '../views/Sprints/edit_sprint.php';
    }

    require '../views/layout/footer.php';
    exit();
}

if ($page === 'delete-sprint') {

    require '../views/layout/header.php';

    $result = $sprintModel->getAll();
    $total = $result->rowCount();

    if ($total == 0) {
        echo "<div class='sin-sprints'>";
        echo "<h3>Aún no hay ningún sprint creado</h3>";
        echo "<p>No puedes eliminar porque no existen sprints.</p>";
        echo "</div>";
    } else {
        echo "<div class='sin-sprints'>";
        echo "<h3>Sección eliminar sprint</h3>";
        echo "<p>Aquí irá la lógica para eliminar.</p>";
        echo "</div>";
    }

    require '../views/layout/footer.php';
    exit();
}

require '../views/layout/header.php';

$result = $sprintModel->getAll();
$total = $result->rowCount();
?>

<h1 class="titulo-principal">Gestión de Sprints</h1>
<form method="GET" action="index.php" class="menu-gestion">

    <select name="page" required onchange="this.form.submit()">
        <option value="create-sprint">Crear Sprint</option>
        <option value="edit-sprint">Editar Sprint</option>
        <option value="delete-sprint">Eliminar Sprint</option>
    </select>

</form>
<?php if ($total == 0): ?>

    <div class="sin-sprints">
        <h3>No hay sprints creados aún</h3>
        <p>Crea tu primer sprint para comenzar.</p>
    </div>

<?php else: ?>

    <div class="contenedor-sprints">
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            
            <div class="card-sprint">
                <h3><?= htmlspecialchars($row['nombre']) ?></h3>
                
                <p>
                    <strong>Inicio:</strong> <?= $row['fecha_inicio'] ?><br>
                    <strong>Fin:</strong> <?= $row['fecha_fin'] ?>
                </p>

                <a href="?page=retros&sprint_id=<?= $row['id'] ?>" class="btn-ver">
                    Ver retrospectiva
                </a>
            </div>

        <?php endwhile; ?>
    </div>

<?php endif; ?>

<div class="menu-principal">
    <a href="?page=create-sprint" class="btn-crear">
        Crear Sprint
    </a>
</div>



<?php require '../views/layout/footer.php'; ?>