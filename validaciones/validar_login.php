<?php
// Valida los campos del login
function validarCamposLogin($username, $password)
{   // Comprueba si es un string y si esta vacio
    if (!is_string($username) || !is_string($password) || trim($username) === '' || $password === '') {
        return 'Incorrecto: Escriba bien la contraseÃ±a y el usuario';
    }

    return '';
}