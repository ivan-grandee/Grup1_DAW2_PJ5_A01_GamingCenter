function validarJugadores() {
    var mensaje = this.parentNode.querySelector('.error-jugadores');
    var cantidad = Number(this.value);
    var capacidad = Number(this.max);

    if (this.value.trim() === '' || isNaN(cantidad) || cantidad < 1 || Math.floor(cantidad) !== cantidad) {
        mensaje.textContent = 'Indica un número entero de jugadores mayor que cero.';
        return false;
    }

    if (cantidad > capacidad) {
        mensaje.textContent = 'El número de jugadores supera la capacidad del módulo.';
        return false;
    }

    mensaje.textContent = '';
    return true;
}

function validarFormularioOcupacion(evento) {
    var objetoJugadores = this.querySelector('input[name="num_jugadores"]');

    if (!validarJugadores.call(objetoJugadores)) {
        evento.preventDefault();
    }
}

var objetosFormularioOcupacion = document.querySelectorAll('.form-ocupacion');
for (var i = 0; i < objetosFormularioOcupacion.length; i++) {
    var objetoFormularioOcupacion = objetosFormularioOcupacion[i];
    var objetoJugadores = objetoFormularioOcupacion.querySelector('input[name="num_jugadores"]');

    objetoJugadores.onblur = validarJugadores;
    objetoFormularioOcupacion.onsubmit = validarFormularioOcupacion;
}