<?php

require_once(__DIR__ . '/../includes/proteger.php');
require_once(__DIR__ . '/../includes/funciones.php');
require_once(__DIR__ . '/../config/conexion.php');
//aqui fem el select de les sales per poder tindreles en la taula 
$sql = 'SELECT id, nom, tipus FROM sales ORDER BY id';
$stmt = $conn->prepare($sql);
$stmt->execute();
$salas = $stmt->fetchAll();

$mensajes = array(
    'ocupado' => 'El modulo ya esta ocupado ',
    'permiso' => 'Este modulo ha sido registrado por otro game master, no se puede editar',
    'datos' => 'Revisa el módulo y el número de jugadores.',
    'modulo' => 'El módulo indicado no existe',
    'ocupacion' => 'La ocupación indicada no es válida.'
);
$mensaje = '';
if (isset($_GET['ok']) && $_GET['ok'] === 'ocupado') {
    $mensaje = 'El módulo se ha marcado como ocupado.';
} elseif (isset($_GET['ok']) && $_GET['ok'] === 'liberado') {
    $mensaje = 'El módulo se ha liberado.';
} elseif (isset($_GET['error']) && isset($mensajes[$_GET['error']])) {
    $mensaje = $mensajes[$_GET['error']];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salas | Gaming Center</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <h1>Estado de las salas</h1>
        <p>Sesión: <?php echo escapar($_SESSION['nombre']); ?> (<?php echo escapar($_SESSION['username']); ?>)</p>
        <nav>
            <a href="salas.php">Salas</a> |
            <a href="historico.php">Histórico de ocupaciones</a> |
            <a href="../procesos/logout.php">Cerrar sesión</a>
        </nav>
    </header>
    <?php if ($mensaje !== '') { ?>
    <p role="status"><?php echo escapar($mensaje); ?></p>
    <?php } ?>

    <?php foreach ($salas as $sala) { ?>
        <section>
            <h2><?php echo escapar($sala['nom']); ?>: <?php echo escapar($sala['tipus']); ?></h2>

            <!-- Aqui trobem el select amb les taules y la seva capacitat-->
            <?php
            $salaId = $sala['id'];
            $sql = 'SELECT id, nom, tipus, capacitat FROM moduls WHERE sala_id = :sala_id ORDER BY id';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':sala_id', $salaId, PDO::PARAM_INT);
            $stmt->execute();
            $modulos = $stmt->fetchAll();

            $capacidadTotal = 0;
            $modulosOcupados = 0;
            ?>

            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Módulo</th>
                        <th>Tipo</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modulos as $modulo) { ?>


                        <!-- Aqui fem el select per la ocupabilitat de les sales aqui trobem que cada estat de la sala es guarda a $ocuapacions y depres si es true mostre ocupat y si no lliure... -->
                        <?php
                        $moduloId = $modulo['id'];
                        $capacidadTotal = $capacidadTotal + $modulo['capacitat'];
                        $sql = 'SELECT id, num_jugadors, gamemaster_id FROM ocupacions WHERE modul_id = :modul_id AND data_fi IS NULL';
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':modul_id', $moduloId, PDO::PARAM_INT);
                        $stmt->execute();
                        $ocupacion = $stmt->fetch();

                        //Aquest es el select per saber qui ha ocupat la sala de el gaming center
                        if ($ocupacion) {
                            $gamemasterId = $ocupacion['gamemaster_id'];
                            $sql = 'SELECT username FROM gamemasters WHERE id = :gamemaster_id';
                            $modulosOcupados = $modulosOcupados + 1;
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':gamemaster_id', $gamemasterId, PDO::PARAM_INT);
                            $stmt->execute();
                            $gamemaster = $stmt->fetch();
                        }
                        ?>

                        <tr>
                            <td><?php echo escapar($modulo['nom']); ?></td>
                            <td><?php echo escapar($modulo['tipus']); ?></td>
                            <td><?php echo escapar($modulo['capacitat']); ?></td>

                            <td>
                                <?php if ($ocupacion) { ?>
                                    Ocupado por <?php echo escapar($gamemaster['username']); ?> (<?php echo escapar($ocupacion['num_jugadors']); ?> jugadores)
                                <?php } else { ?>
                                    Libre
                                <?php } ?>
                            </td>

                            <td>
                                <?php if ($ocupacion) { ?>
                                    <?php if ((int) $ocupacion['gamemaster_id'] === (int) $_SESSION['gamemaster_id']) { ?>
                                        <form action="../procesos/liberar.php" method="post">
                                            <input type="hidden" name="ocupacion_id" value="<?php echo escapar($ocupacion['id']); ?>">
                                            <button type="submit">Liberar módulo</button>
                                        </form>
                                    <?php } else { ?>
                                        No puedes liberar la ocupación de otro gamemaster.
                                    <?php } ?>
                                <?php } else { ?>
                                    <form class="form-ocupacion" action="../procesos/ocupar.php" method="post" novalidate>
                                        <input type="hidden" name="modul_id" value="<?php echo escapar($modulo['id']); ?>">
                                        <label for="jugadores-<?php echo escapar($modulo['id']); ?>">Jugadores:</label>
                                        <input type="number" id="jugadores-<?php echo escapar($modulo['id']); ?>" name="num_jugadores" min="1" max="<?php echo escapar($modulo['capacitat']); ?>" required>
                                        <span class="error-jugadores" role="alert" aria-live="polite"></span>
                                        <button type="submit">Ocupar</button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
                <p>
                    <!-- muestra las salas que quedan libres y los modulos libres  -->
                Capacidad total: <?php echo escapar($capacidadTotal); ?> puestos/mandos.
                Módulos ocupados: <?php echo escapar($modulosOcupados); ?> de <?php echo escapar(count($modulos)); ?>.
                </p>
        </section>
        
    <?php } ?>
<script src="../js/validar_ocupacion.js" defer></script>
</body>
</html>