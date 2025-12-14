// javaScript/controllers/controller.js
import { Modelo } from "../models/model.js";
import { Vista } from "../views/view.js";

document.addEventListener("DOMContentLoaded", () => {

    /* ================= LOGIN ================= */
    const formulario = document.querySelector("form");
    if (formulario) {
        formulario.addEventListener("submit", (e) => {
            e.preventDefault();
            Vista.limpiarErrores();

            const email = document.getElementById("email");
            const password = document.getElementById("password");

            let valido = true;
            if (!Modelo.validarCorreo(email.value)) {
                Vista.mostrarError("error-email", "Email no válido");
                valido = false;
            }

            if (valido) {
                formulario.submit(); // PHP gestiona login
            }
        });
    }

    /* ================= CREAR TEMA ================= */
    const botonCrear = document.querySelector(".botonanadir");
    if (botonCrear) {
        botonCrear.addEventListener("click", async (e) => {
            e.preventDefault();
            Vista.limpiarErrores();

            const nombre = document.getElementById("nombre-tema").value.trim();
            const descripcion = document.getElementById("descripcion-tema").value.trim();
            const abreviatura = document.getElementById("abreviatura").value.trim();
            const publico = document.getElementById("publico")?.checked ? 1 : 0;

            let valido = true;
            if (!Modelo.validarNombreTema(nombre)) {
                Vista.mostrarError("error-nombre", "Mínimo 2 caracteres");
                valido = false;
            }
            if (!Modelo.validarDescripcionTema(descripcion)) {
                Vista.mostrarError("error-descripcion", "Mínimo 10 caracteres");
                valido = false;
            }
            if (!valido) return;

            const datos = new FormData();
            datos.append("nombreTema", nombre);
            datos.append("abreviatura", abreviatura);
            datos.append("descripcion", descripcion);
            if (publico) datos.append("publico", 1);

            const respuesta = await fetch("index.php?controller=Temas&action=introducirTemas", {
                method: "POST",
                body: datos
            });

            if (respuesta.redirected) {
                window.location.href = respuesta.url;
            } else {
                alert("Error al crear el tema");
            }
        });
    }

    /* ================= BORRAR TEMA ================= */
    document.querySelectorAll(".icono-borrar").forEach(boton => {
        boton.addEventListener("click", async (e) => {
            e.preventDefault();
            e.stopPropagation();

            const enlace = boton.closest(".enlace-tarjeta");
            const idTema = enlace.dataset.idtema;

            if (!Vista.confirmarBorrado()) return;

            const respuesta = await fetch(`index.php?controller=Temas&action=eliminarTema&idTema=${idTema}`, { method: "GET" });

            if (respuesta.ok) {
                enlace.remove();
            } else {
                alert("Error al eliminar");
            }
        });
    });
});
