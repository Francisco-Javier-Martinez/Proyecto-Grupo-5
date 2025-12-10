export const Vista = {

    mostrarError(idElemento, mensajeError) {
        const elemento = document.getElementById(idElemento);
        if(elemento){
            elemento.textContent = mensajeError;
        }
    },

    limpiarErrores() {
        document.querySelectorAll(".error-msg").forEach(elemento => {
            elemento.textContent = "";
        });
    },

    confirmarBorrado(mensaje = "¿Estás seguro que quieres eliminar este tema?") {
        return confirm(mensaje);
    }
};
