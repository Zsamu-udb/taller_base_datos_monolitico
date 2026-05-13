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

/* RETROSPECTIVAS :p*/
if ($page === 'retros') {

    require '../views/retros/index.php';
    require '../views/layout/footer.php';

    exit();
}

/* EDITAR RETRO :P*/
if ($page === 'edit-retro') {

    require '../views/retros/edit.php';
    require '../views/layout/footer.php';

    exit();
}

/* OBTENER SPRINTS :p*/
$result = $sprintModel->getAll();

?>

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

        <strong>
            <?= $row['nombre'] ?>
        </strong>

        (<?= $row['fecha_inicio'] ?> - <?= $row['fecha_fin'] ?>)

        <a href="?page=retros&sprint_id=<?= $row['id'] ?>">
            Ver retrospectiva
         </a>

        <!-- ELIMINAR -->
        <a href="../controllers/SprintController.php?action=eliminar&id=<?php echo $sprint['id']; ?>" 
        onclick="return confirm('¿Seguro que quieres eliminar este sprint?')" 
        class="btn-eliminar">
        Eliminar
        </a>
            <input
                type="hidden"
                name="delete_id"
                value="<?= $sprint['id'] ?>"
            >


    </li>

<?php endwhile; ?>

</ul>

<?php require '../views/layout/footer.php'; ?>