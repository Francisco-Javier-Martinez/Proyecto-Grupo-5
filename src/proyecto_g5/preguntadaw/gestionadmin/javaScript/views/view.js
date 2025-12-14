// javaScript/views/view.js
export const Vista = {
    mostrarError(idElemento, mensaje) {
        const elemento = document.getElementById(idElemento);
        if (elemento) {
            elemento.textContent = mensaje;
            elemento.style.display = "block";
        }
    },
    limpiarErrores() {
        document.querySelectorAll(".error").forEach(el => {
            el.textContent = "";
            el.style.display = "none";
        });
    },
    confirmarBorrado() {
        return confirm("¿Estás seguro de que deseas eliminar este tema?");
    }
};
