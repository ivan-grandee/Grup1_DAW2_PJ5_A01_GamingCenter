<?php

// Valida los datos de ocupacion
function validarDatosOcupacion($modulId, $numJugadores, $capacidad)
{   // valida si es constante, si es un numero y si es mas pequeño que 1
    if (!is_scalar($modulId) || filter_var($modulId, FILTER_VALIDATE_INT) === false || $modulId < 1) {
        return 'Selecciona un módulo válido.';
    }
    // valida si es constante, si es un numero y si es mas pequeño que 1
    if (!is_scalar($numJugadores) || filter_var($numJugadores, FILTER_VALIDATE_INT) === false || $numJugadores < 1) {
        return 'El número de jugadores debe ser un entero mayor que cero.';
    }
    // Si el numero de jugadores es mayor al de la capacidad de la sala da error
    if ($numJugadores > $capacidad) {
        return 'El módulo no tiene capacidad para tantos jugadores.';
    }

    return '';
}

// valida si es constante, si es un numero y si es mas grande que 0
function validarIdOcupacion($ocupacionId)
{
    return is_scalar($ocupacionId) && filter_var($ocupacionId, FILTER_VALIDATE_INT) !== false && $ocupacionId > 0;
}