<?php

// Esta funcion valida si estan rellenados los campos de username y pasword
function validarCamposLogin($username, $password)
{
    // Error si alguno es un array, o si el usuario (sin espacios) está vacío, o si la contraseña está vacía
    if (is_array($username) || is_array($password) || empty(trim($username)) || empty($password)) {
        return 'Escribe el usuario y la contraseña.';
    }

    // Si no hay ningún problema, devuelvo texto vacío
    return '';
}