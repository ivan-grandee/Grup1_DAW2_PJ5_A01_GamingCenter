<?php

function validarCamposLogin($username, $password)
{
    if (!is_string($username) || !is_string($password) || trim($username) === '' || $password === '') {
        return 'Incorrecto: Escriba bien la contraseña y el usuario';
    }

    return '';
}