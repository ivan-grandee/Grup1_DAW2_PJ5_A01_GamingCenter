<?php
session_start();

require_once(__DIR__ . '/../includes/funciones.php');
    
if (isset($_SESSION['gamemaster_id'])) {
    header('Location: salas.php');
    exit();
}

$mensaje = '';
if (isset($_GET['error']) && $_GET['error'] === 'campos') {
    $mensaje = 'Escribe el usuario y la contraseña.';
} elseif (isset($_GET['error']) && $_GET['error'] === 'credenciales') {
    $mensaje = 'El usuario o la contraseña no son correctos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Login </title>
</head>
<body>

    <h1>Gaming Center</h1>
    <h2>Iniciar sesión</h2>

<form id="form-login" action="../procesos/login.php" method="post" novalidate>
    <label for="username">Usuario:</label>
    <input type="text" id="username" name="username" required>
    <span id="error-username" role="alert"></span>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    <span id="error-password" role="alert"></span>

    <?php if ($mensaje !== '') { ?>
        <p role="alert"><?php echo escapar($mensaje); ?></p>
    <?php } ?>

    <button type="submit">Entrar</button>
</form>
<!-- con el defer ejecuta antes la pagina antes de ejecutar el script -->
<script src="../js/validar_login.js" defer></script>
</body>

</html>