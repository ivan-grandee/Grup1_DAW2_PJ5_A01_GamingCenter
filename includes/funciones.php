<?php

// Evitamos que el texto de la base de datos se interprete como etiquetas HTML.
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

// Cambiamos solo el nombre que se ve en pantalla; la base de datos sigue igual.
function nombreSalaPokemon($nombre)
{
    $nombres = array(
        'Sala 1' => 'Sala Pikachu',
        'Sala 2' => 'Sala Bulbasaur',
        'Sala 3' => 'Sala Charmander',
        'Sala 4' => 'Sala Squirtle',
        'Sala 5' => 'Sala Gengar',
        'Sala 6' => 'Sala Eevee',
        'Sala 7' => 'Sala Snorlax',
        'Sala 8' => 'Sala Mewtwo',
        'Sala 9' => 'Sala Rayquaza'
    );
    // Si alguien añade una sala con otro nombre, la mostramos tal como está.
    return $nombres[$nombre] ?? $nombre;
}
// Esta etiqueta acompaña al nombre de cada sala en su cabecera.
function tipoSalaPokemon($nombre)
{
    $tipos = array(
        'Sala 1' => 'Eléctrico',
        'Sala 2' => 'Planta',
        'Sala 3' => 'Fuego',
        'Sala 4' => 'Agua',
        'Sala 5' => 'Fantasma',
        'Sala 6' => 'Normal',
        'Sala 7' => 'Normal',
        'Sala 8' => 'Psíquico',
        'Sala 9' => 'Dragón'
    );
    // Las salas que no están en la lista llevan esta etiqueta general.
    return $tipos[$nombre] ?? 'Entrenamiento';
}
