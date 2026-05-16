<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../models/Sprint.php';

$database = new Database();
$db = $database->connect();

$sprintModel = new Sprint($db);

require '../views/layout/header.php';

$page = $_GET['page'] ?? 'home';

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    
<h2>Lista de Sprints</h2>

<!-- AQUÍ CREAMOS EL SPRINT -->
<h3>Crear Sprint</h3>

<form method="POST"
      action="/taller_base_datos_monolitico/controllers/SprintController.php">

    <input
        type="text"
        name="nombre"
        placeholder="Nombre del sprint"
        required
    >

    <input
        type="date"
        name="fecha_inicio"
        required
    >

    <input
        type="date"
        name="fecha_fin"
        required
    >

    <button type="submit">
        Crear Sprint
    </button>

</form>

<hr>

<ul>

<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>

    <li>
            <strong><?= $row['nombre'] ?></strong>

    (<?= $row['fecha_inicio'] ?> - <?= $row['fecha_fin'] ?>)

    <a href="?page=retros&sprint_id=<?= $row['id'] ?>">
        Ver retrospectiva
    </a>

    <form
        method="POST"
        action="/taller_base_datos_monolitico/controllers/SprintController.php"
        style="display:inline;"
    >

        <input
            type="hidden"
            name="delete_sprint_id"
            value="<?= $row['id'] ?>"
        >

        <button type="submit">
            Eliminar
        </button>

    </form>
    </li>

<?php endwhile; ?>

</ul>

<?php require '../views/layout/footer.php'; ?>

</body>
</html>