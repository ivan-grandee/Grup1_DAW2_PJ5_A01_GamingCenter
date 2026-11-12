<?php 
//funcion que hace que cada variable pase por la validacion de que no puede ser caracter html se leera en texto plano
function escapar($valor){ 
//convertir tanto las comillas dobles (") como las comillas simples (') en sus respectivas entidades HTML
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>