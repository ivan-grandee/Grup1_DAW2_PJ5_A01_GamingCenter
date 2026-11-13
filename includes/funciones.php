<?php

// Previene la ejecucion de scripts u otrsos elementos de codigo
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); // convierte elementos html en texto plano
}