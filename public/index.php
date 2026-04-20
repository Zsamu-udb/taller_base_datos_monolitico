<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../models/Sprint.php';
require '../views/layout/header.php';

$db = (new Database())->connect();
$sprintModel = new Sprint($db);

$page = $_GET['page'] ?? null;

if ($page === 'retros') {
    require '../views/retros/index.php';
    require '../views/layout/footer.php';
    exit();
}

if ($page === 'edit-retro') {
    require '../views/retros/edit.php';
    require '../views/layout/footer.php';
    exit();
}

$result = $sprintModel->getAll();
?>

<h1>Lista de Sprints</h1>

<ul>
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <li>
            <strong><?= $row['nombre'] ?></strong>
            (<?= $row['fecha_inicio'] ?> - <?= $row['fecha_fin'] ?>)

            <a href="?page=retros&sprint_id=<?= $row['id'] ?>">
                Ver retrospectiva
            </a>
        </li>
    <?php endwhile; ?>
</ul>
<?php require '../views/layout/footer.php'; ?>