<?php

require_once(__DIR__ . '/../includes/proteger.php');
require_once(__DIR__ . '/../includes/funciones.php');
require_once(__DIR__ . '/../validaciones/validar_filtros.php');
require_once(__DIR__ . '/../config/conexion.php');

$salaId = $_GET['sala_id'] ?? '';
$modulId = $_GET['modul_id'] ?? '';
$mensaje = '';

if (!validarIdFiltro($salaId) || !validarIdFiltro($modulId)) {
    $mensaje = 'Los filtros indicados no son válidos.';
    $salaId = '';
    $modulId = '';
}