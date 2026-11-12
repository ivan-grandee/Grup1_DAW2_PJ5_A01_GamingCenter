<?php
//valida los dstos de ocupacion de los modulos
function validarDatosOcupacion($modulId, $numJugadores, $capacidad)
{   // valida si se ha itroducido un array de datos, no es un numero o es mas pequeño de 1
    if (is_array($modulId) || !preg_match('/^[0-9]+$/', $modulId) || $modulId < 1) {
        return 'Selecciona un módulo válido.';
    }
    // valida si se ha itroducido un array de datos, no es un numero o es mas pequeño de 1
    if (is_array($numJugadores) || !preg_match('/^[0-9]+$/', $numJugadores) || $numJugadores < 1) {
        return 'El número de jugadores debe ser un entero mayor que cero.';
    }
    // Si el numero de jugadores es mas alto que la capacidad da error
    if ($numJugadores > $capacidad) {
        return 'El módulo no tiene capacidad para tantos jugadores.';
    }

    return '';
}

function validarIdOcupacion($ocupacionId)
{   // si se ha itroducido un array de datos, no es un numero o es mas que 0
    return !is_array($ocupacionId) && preg_match('/^[0-9]+$/', $ocupacionId) && $ocupacionId > 0;
}
