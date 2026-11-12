var objetoUsername = document.getElementById("username");
var objetoPassword = document.getElementById("password");

function validarUsername() {
    if (objetoUsername.value == "") {
        document.getElementById("error-username").innerHTML = "Escribe tu nombre de usuario.";
    } else {
        document.getElementById("error-username").innerHTML = "";
    }
}

function validarPassword() {
    if (objetoPassword.value == "") {
        document.getElementById("error-password").innerHTML = "Escribe tu contraseña.";
    } else {
        document.getElementById("error-password").innerHTML = "";
    }
}

objetoUsername.onblur = validarUsername;
objetoPassword.onblur = validarPassword;
