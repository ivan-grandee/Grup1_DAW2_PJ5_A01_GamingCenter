<?php

require_once(__DIR__ . '/../includes/proteger.php');
require_once(__DIR__ . '/../validaciones/validar_ocupacion.php');
require_once(__DIR__ . '/../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../vistas/salas.php');
    exit();
}

$ocupacionId = $_POST['ocupacion_id'] ?? '';
if (!validarIdOcupacion($ocupacionId)) {
    header('Location: ../vistas/salas.php?error=ocupacion');
    exit();
}

$gamemasterId = $_SESSION['gamemaster_id'];

$sql = 'UPDATE ocupacions
        SET data_fi = NOW()
        WHERE id = :id
          AND gamemaster_id = :gamemaster_id
          AND data_fi IS NULL';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $ocupacionId, PDO::PARAM_INT);
$stmt->bindParam(':gamemaster_id', $gamemasterId, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() === 1) {
    header('Location: ../vistas/salas.php?ok=liberado');
} else {
    header('Location: ../vistas/salas.php?error=permiso');
}
exit();