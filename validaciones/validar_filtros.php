<?php

function validarIdFiltro($id)
{
    return $id === '' || (is_scalar($id) && filter_var($id, FILTER_VALIDATE_INT) !== false && $id > 0);
}