import { Modelo } from "./model.js";
import { Vista } from "./view.js";

document.addEventListener("DOMContentLoaded", () => {

    // ------------------- FORMULARIOS -------------------
    const formularioPrincipal = document.querySelector("form");
    if (formularioPrincipal) {
        formularioPrincipal.addEventListener("submit", (evento) => {
            Vista.limpiarErrores();
            evento.preventDefault();

            // ---------- FORMULARIO DE CÓDIGO ----------
            const inputCodigo = document.getElementById("codigo");

            if (inputCodigo) {
                if (!Modelo.validarCodigo(inputCodigo.value.trim())) {
                    Vista.mostrarError(
                        "infoCodigo",
                        "Código incorrecto. Máximo 5 números y debe coincidir."
                    );
                    return;
                }
                window.location.href = "./modificarContraseña.html";
                return;
            }

            // ---------- FORMULARIO DE NUEVA CONTRASEÑA ----------
            const inputClaveNueva = document.getElementById("contraseña");
            const inputClaveConfirmar = document.getElementById("contraseña1");

            if (inputClaveNueva && inputClaveConfirmar) {
                let formularioValido = true;

                if (!Modelo.validarClave(inputClaveNueva.value)) {
                    Vista.mostrarError(
                        "error-contraseña",
                        "9-15 caracteres, mayúscula, minúscula, número y símbolo."
                    );
                    formularioValido = false;
                }

                if (!Modelo.validarClave(inputClaveConfirmar.value)) {
                    Vista.mostrarError(
                        "error-contraseña1",
                        "9-15 caracteres, mayúscula, minúscula, número y símbolo."
                    );
                    formularioValido = false;
                }

                if (!Modelo.clavesCoinciden(inputClaveNueva.value, inputClaveConfirmar.value)) {
                    Vista.mostrarError(
                        "error-match",
                        "Las contraseñas no coinciden."
                    );
                    formularioValido = false;
                }

                if (formularioValido) {
                    alert("Contraseña cambiada exitosamente");
                    window.location.href = "../panelAdministrador.html";
                }
                return;
            }

            // ---------- FORMULARIO DE LOGIN ----------
            const inputCorreo = document.getElementById("email");
            const inputPassword = document.getElementById("password");

            if (inputCorreo && inputPassword) {
                let loginValido = true;

                // Crear mensajes de error si no existen
                if (!document.getElementById("error-email")) {
                    const parrafoErrorCorreo = document.createElement("p");
                    parrafoErrorCorreo.id = "error-email";
                    parrafoErrorCorreo.className = "error-msg";
                    inputCorreo.insertAdjacentElement("afterend", parrafoErrorCorreo);
                }

                if (!document.getElementById("error-password-login")) {
                    const parrafoErrorPassword = document.createElement("p");
                    parrafoErrorPassword.id = "error-password-login";
                    parrafoErrorPassword.className = "error-msg";
                    inputPassword.insertAdjacentElement("afterend", parrafoErrorPassword);
                }

                if (!Modelo.validarCorreo(inputCorreo.value)) {
                    Vista.mostrarError(
                        "error-email",
                        "Introduce un email válido."
                    );
                    loginValido = false;
                }

                if (!Modelo.validarClave(inputPassword.value)) {
                    Vista.mostrarError(
                        "error-password-login",
                        "9-15 caracteres, mayúscula, minúscula, número y símbolo."
                    );
                    loginValido = false;
                }

                if (loginValido) {
                    window.location.href = "../panelAdministrador.html";
                }
            }
        });
    }

    // ------------------- CREAR TEMA -------------------
    const botonCrearTema = document.querySelector(".botonanadir");
    const inputNombre = document.getElementById("nombre-tema");
    const inputDescripcion = document.getElementById("descripcion-tema");

    if (botonCrearTema) {
        botonCrearTema.addEventListener("click", (evento) => {
            evento.preventDefault();
            Vista.limpiarErrores();

            const nombre = inputNombre.value.trim();
            const descripcion = inputDescripcion.value.trim();
            let valido = true;

            if (!Modelo.validarNombreTema(nombre)) {
                Vista.mostrarError("error-nombre", "El nombre debe tener al menos 2 caracteres.");
                valido = false;
            }

            if (!Modelo.nombreTemaDisponible(nombre)) {
                Vista.mostrarError("error-nombre", "El nombre del tema ya existe.");
                valido = false;
            }

            if (!Modelo.validarDescripcionTema(descripcion)) {
                Vista.mostrarError("error-descripcion", "La descripción debe tener mínimo 10 caracteres.");
                valido = false;
            }

            if (valido) {
                Modelo.agregarTema(nombre);
                alert("Tema creado correctamente");
                window.location.href = "../creación_Preguntas.html";
            }
        });
    }

    // ------------------- BORRAR TEMAS -------------------
    const botonesBorrar = document.querySelectorAll('img[alt="Icono Borrar"]');

    botonesBorrar.forEach(boton => {
        boton.addEventListener("click", (evento) => {
            evento.preventDefault();

            if (Vista.confirmarBorrado()) {
                const enlace = boton.closest("a");
                if (enlace) {
                    window.location.href = enlace.href;
                }
            }
        });
    });

});
