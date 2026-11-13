var objetoFormulario = document.getElementById('form-login');
var objetoUsername = document.getElementById('username');
var objetoPassword = document.getElementById('password');

function validarUsername() {
    var mensaje = document.getElementById('error-username');

    if (this.value.trim() === '') {
        mensaje.textContent = 'Escribe tu nombre de usuario.';
        return false;
    }

    mensaje.textContent = '';
    return true;
}

function validarPassword() {
    var mensaje = document.getElementById('error-password');

    if (this.value === '') {
        mensaje.textContent = 'Escribe tu contraseña.';
        return false;
    }

    mensaje.textContent = '';
    return true;
}

function validarFormularioLogin(evento) {
    var usernameValido = validarUsername.call(objetoUsername);
    var passwordValido = validarPassword.call(objetoPassword);

    if (!usernameValido || !passwordValido) {
        evento.preventDefault();
    }
}

objetoUsername.onblur = validarUsername;
objetoPassword.onblur = validarPassword;
objetoFormulario.onsubmit = validarFormularioLogin;