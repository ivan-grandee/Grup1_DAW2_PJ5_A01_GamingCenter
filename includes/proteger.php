<?php

// Activo la sesión para poder leer $_SESSION
session_start();

// Si NO existe el id del gamemaster en la sesión, se redirige al usuario al login
if (!isset($_SESSION['gamemaster_id'])) {

    header('Location: ../vistas/login.php');
    exit();
}