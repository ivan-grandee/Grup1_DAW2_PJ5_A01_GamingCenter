<?php

require_once(__DIR__ . '/../includes/proteger.php');
require_once(__DIR__ . '/../validaciones/validar_ocupacion.php');
require_once(__DIR__ . '/../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../vistas/salas.php');
    exit();
}
// aqui estan todas las variables 
$modulId = $_POST['modul_id'] ?? '';
$numJugadores = $_POST['num_jugadores'] ?? '';



if (!is_scalar($modulId) || filter_var($modulId, FILTER_VALIDATE_INT) === false || $modulId < 1) {
    header('Location: ../vistas/salas.php?error=modulo');
    exit();
}

$sql = 'SELECT capacitat, id FROM moduls WHERE id = :modul_id';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':modul_id', $modulId, PDO::PARAM_INT);
$stmt->execute();
$modul = $stmt->fetch();

if (!$modul) {
    header('Location: ../vistas/salas.php?error=modulo');
    exit();
}

$error = validarDatosOcupacion($modulId, $numJugadores, $modul['capacitat']);
if ($error !== '') {
    header('Location: ../vistas/salas.php?error=datos');
    exit();
}

$sql = 'SELECT id FROM ocupacions WHERE modul_id  = :modul_id AND data_fi IS NULL';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':modul_id', $modulId, PDO::PARAM_INT);
$stmt->execute();
$ocupacion = $stmt->fetch();

if ($ocupacion) {
    header('Location: ../vistas/salas.php?error=ocupado');
    exit();
}

$gamemasterId = $_SESSION['gamemaster_id'];

$sql = 'INSERT INTO ocupacions (modul_id, gamemaster_id, num_jugadors, data_inici, data_fi)
        VALUES (:modul_id, :gamemaster_id, :num_jugadors, NOW(), NULL)';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':modul_id', $modulId, PDO::PARAM_INT);
$stmt->bindParam(':gamemaster_id', $gamemasterId, PDO::PARAM_INT);
$stmt->bindParam(':num_jugadors', $numJugadores, PDO::PARAM_INT);
$stmt->execute();

header('Location: ../vistas/salas.php?ok=ocupado');
exit();