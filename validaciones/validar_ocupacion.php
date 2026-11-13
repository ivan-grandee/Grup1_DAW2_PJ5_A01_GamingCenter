<?php
function validarDatosOcupacion($modulId, $numJugadores, $capacidad)
{
    if (!is_scalar($modulId) || filter_var($modulId, FILTER_VALIDATE_INT) === false || $modulId < 1) {
        return 'Selecciona un módulo válido.';
    }

    if (!is_scalar($numJugadores) || filter_var($numJugadores, FILTER_VALIDATE_INT) === false || $numJugadores < 1) {
        return 'El número de jugadores debe ser un entero mayor que cero.';
    }

    if ($numJugadores > $capacidad) {
        return 'El módulo no tiene capacidad para tantos jugadores.';
    }

    return '';
}

function validarIdOcupacion($ocupacionId)
{
    return is_scalar($ocupacionId) && filter_var($ocupacionId, FILTER_VALIDATE_INT) !== false && $ocupacionId > 0;
}