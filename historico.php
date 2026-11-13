<?php

// Protección de sesión, funciones auxiliares, validación de filtros y conexión a la BD
require_once(__DIR__ . '/../includes/proteger.php');
require_once(__DIR__ . '/../includes/funciones.php');
require_once(__DIR__ . '/../validaciones/validar_filtros.php');
require_once(__DIR__ . '/../config/conexion.php');

// Se recogen los filtros de la URL (vacíos si no existen)
$salaId = $_GET['sala_id'] ?? '';
$modulId = $_GET['modul_id'] ?? '';
$mensaje = '';

// Si algún filtro no es válido, se muestra un error y se ignoran ambos
if (!validarIdFiltro($salaId) || !validarIdFiltro($modulId)) {
    $mensaje = 'Los filtros indicados no son válidos.';
    $salaId = '';
    $modulId = '';
}

// Listado de salas para el desplegable del filtro
$sql = 'SELECT id, nom FROM sales ORDER BY id';
$stmt = $conn->prepare($sql);
$stmt->execute();
$salas = $stmt->fetchAll();

// Listado de módulos para el desplegable del filtro
$sql = 'SELECT id, nom FROM moduls ORDER BY id';
$stmt = $conn->prepare($sql);
$stmt->execute();
$modulos = $stmt->fetchAll();

// Consulta base: ocupaciones con su módulo, sala y gamemaster
$sql = 'SELECT o.id, s.nom AS sala_nom, m.nom AS modul_nom, m.tipus,
               o.num_jugadors, o.data_inici, o.data_fi, g.username
        FROM ocupacions o
        INNER JOIN moduls m ON m.id = o.modul_id
        INNER JOIN sales s ON s.id = m.sala_id
        INNER JOIN gamemasters g ON g.id = o.gamemaster_id';

// Se añade el WHERE solo con los filtros que se hayan indicado
$condiciones = array();
if ($salaId !== '') {
    $condiciones[] = 's.id = :sala_id';
}
if ($modulId !== '') {
    $condiciones[] = 'm.id = :modul_id';
}
if (count($condiciones) > 0) {
    $sql .= ' WHERE ' . implode(' AND ', $condiciones);
}
$sql .= ' ORDER BY o.data_inici DESC';

// Se ejecuta la consulta con parámetros (evita inyección SQL)
$stmt = $conn->prepare($sql);
if ($salaId !== '') {
    $stmt->bindParam(':sala_id', $salaId, PDO::PARAM_INT);
}
if ($modulId !== '') {
    $stmt->bindParam(':modul_id', $modulId, PDO::PARAM_INT);
}
$stmt->execute();
$ocupaciones = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico | Gaming Center</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Histórico de ocupaciones</h1>
        <p>Sesión: <?php echo escapar($_SESSION['username']); ?></p>
        <nav>
            <a href="./salas.php">Volver a salas</a> |
            <a href="../procesos/logout.php">Cerrar sesión</a>
        </nav>
    </header>

    <!-- Formulario de filtros (método GET) -->
    <form action="historico.php" method="GET">
        <label for="sala_id">Sala:</label>
        <select id="sala_id" name="sala_id">
            <option value="">Todas</option>
            <?php foreach ($salas as $sala) { ?>
                <!-- Se marca como seleccionada la sala del filtro actual -->
                <option value="<?php echo escapar($sala['id']); ?>" <?php if ((string) $salaId === (string) $sala['id']) { echo 'selected'; } ?>>
                    <?php echo escapar($sala['nom']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="modul_id">Módulo:</label>
        <select id="modul_id" name="modul_id">
            <option value="">Todos</option>
            <?php foreach ($modulos as $modulo) { ?>
                <option value="<?php echo escapar($modulo['id']); ?>" <?php if ((string) $modulId === (string) $modulo['id']) { echo 'selected'; } ?>>
                    <?php echo escapar($modulo['nom']); ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit">Filtrar</button>
        <a href="historico.php">Limpiar filtros</a>
    </form>

    <!-- Mensaje de error si los filtros no eran válidos -->
    <?php if ($mensaje !== '') { ?>
        <p role="alert"><?php echo escapar($mensaje); ?></p>
    <?php } ?>

    <p>Ocupaciones encontradas: <?php echo count($ocupaciones); ?></p>

    <!-- Tabla de resultados -->
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Sala</th>
                <th>Módulo</th>
                <th>Tipo</th>
                <th>Jugadores</th>
                <th>Gamemaster</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ocupaciones as $ocupacion) { ?>
                <tr>
                    <td><?php echo escapar($ocupacion['sala_nom']); ?></td>
                    <td><?php echo escapar($ocupacion['modul_nom']); ?></td>
                    <td><?php echo escapar($ocupacion['tipus']); ?></td>
                    <td><?php echo escapar($ocupacion['num_jugadors']); ?></td>
                    <td><?php echo escapar($ocupacion['username']); ?></td>
                    <td><?php echo escapar($ocupacion['data_inici']); ?></td>
                    <!-- Si no tiene fecha de fin, la ocupación sigue en curso -->
                    <td>
                        <?php if ($ocupacion['data_fi'] === null) { ?>
                            En curso
                        <?php } else { ?>
                            <?php echo escapar($ocupacion['data_fi']); ?>
                        <?php } ?>
                    </td>
                    <td>
                        <?php if ($ocupacion['data_fi'] === null) { ?>
                            Ocupado
                        <?php } else { ?>
                            Finalizada
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>

            <!-- Fila informativa si no hay resultados -->
            <?php if (count($ocupaciones) === 0) { ?>
                <tr>
                    <td colspan="8">No hay ocupaciones para los filtros seleccionados.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>