export class VInicio {
    constructor() {
        this.cajaAvatares = document.getElementById("avatares");
        this.avatarSeleccionado = null;
        this.inputNombre = document.getElementById("jugadorNombre");

        this.botonIniciar = document.getElementById("entrar");
        this.botonIniciar.addEventListener("click", () => {
            this.validarYContinuar();
        });
    }

    /**
     * Recibe avatares desde el controlador
     * Formato esperado:
     * [
     *   { idPersonaje: 1, nombre: "alien", imagen: "data:image/png;base64,..." },
     *   ...
     * ]
     */
    mostrarAvatares(avatares) {
        this.cajaAvatares.innerHTML = ""; // Limpia contenedor

        avatares.forEach(avatar => {
            let imagen = document.createElement("img");
            imagen.src = avatar.imagen;
            imagen.dataset.idAvatar = avatar.idPersonaje;
            imagen.dataset.nombreAvatar = avatar.nombre;

            imagen.style.width = "100px";
            imagen.style.cursor = "pointer";
            imagen.style.margin = "10px";

            imagen.addEventListener("click", () => {

                // Quitar borde del avatar seleccionado previamente
                if (this.avatarSeleccionado && this.avatarSeleccionado !== imagen) {
                    this.avatarSeleccionado.style.border = "none";
                }

                // Seleccionar o deseleccionar
                if (this.avatarSeleccionado !== imagen) {
                    imagen.style.border = "5px solid green";
                    imagen.style.borderRadius = "10px";
                    this.avatarSeleccionado = imagen;
                } else {
                    imagen.style.border = "none";
                    this.avatarSeleccionado = null;
                }
            });

            this.cajaAvatares.appendChild(imagen);
        });
    }

    validarYContinuar() {
        // Validar nombre
        if (!this.inputNombre.value || this.inputNombre.value.trim() === "") {
            alert("¡Coloca algún nombre!");
            return;
        }
        if (this.inputNombre.value.length < 5) {
            alert("¡Mínimo 5 caracteres!");
            return;
        }

        // Validar avatar seleccionado
        if (!this.avatarSeleccionado) {
            alert("¡Selecciona un avatar!");
            return;
        }

        // Guardar datos en localStorage para usarlos en otras pantallas
        localStorage.setItem("jugadorNombre", this.inputNombre.value);
        localStorage.setItem("avatarId", this.avatarSeleccionado.dataset.idAvatar);
        localStorage.setItem("imagenAvatar", this.avatarSeleccionado.dataset.nombreAvatar);
        localStorage.setItem("avatarImagen", this.avatarSeleccionado.src);

        // Continuar al siguiente HTML
        window.location.href = "./index.php?controller=Juego&action=iniciarJuego";;
    }

}
