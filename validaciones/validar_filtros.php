<?php
// Valida si el id esta vacio, si es constante, si es un numero y si es mas grande que 0
function validarIdFiltro($id)
{
    return $id === '' || (is_scalar($id) && filter_var($id, FILTER_VALIDATE_INT) !== false && $id > 0);
}