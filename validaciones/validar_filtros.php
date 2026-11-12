<?php
// Valida si el id esta vacio, contiene un array, no son numeros y es 0
function validarIdFiltro($id)
{
    return $id === '' || (!is_array($id) && preg_match('/^[0-9]+$/', $id) && $id > 0);
}