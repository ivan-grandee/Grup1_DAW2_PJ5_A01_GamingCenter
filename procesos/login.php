<?php
session_start();

require_once(__DIR__ . '/../validaciones/validar_login.php');
require_once(__DIR__ . '/../config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../vistas/login.php');
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$error = validarCamposLogin($username,$password);

if ($error !== '') {
    header('Location: ../vistas/login.php?error=campos');
    exit();
}

$username = trim($username);


$sql = "SELECT id,username, nom, cognom, password FROM gamemasters WHERE username = :username"; 
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
$gamemaster = $stmt->fetch();

if ($gamemaster && password_verify($password, $gamemaster['password'])) {  

    $_SESSION['gamemaster_id'] = $gamemaster['id'];
    $_SESSION['username'] = $gamemaster['username'];
    $_SESSION['nombre'] = $gamemaster['nom'] . ' ' . $gamemaster['cognom'];

header('Location: ../vistas/salas.php');
exit();

}

header('Location: ../vistas/login.php?error=credenciales');
exit();