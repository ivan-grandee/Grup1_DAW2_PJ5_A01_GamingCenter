<?php

session_start();

if (isset($_SESSION['gamemaster_id'])) {
    header('Location: ./vistas/salas.php');
} else {
    header('Location: ./vistas/login.php');  
}
exit();