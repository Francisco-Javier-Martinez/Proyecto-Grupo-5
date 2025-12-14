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

    //validar nombre y avatar seleccionado
    validarYContinuar() {
        console.log('VInicio: validarYContinuar llamado');
        // Validar nombre
        if (!this.inputNombre.value || this.inputNombre.value.trim() === "") {
            alert("¡Coloca algún nombre!");
            return;
        }
        if (this.inputNombre.value.length <= 2) {
            alert("¡Mínimo 3 caracteres!");
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

            // Redirigir a index.php usando parámetros cortos (?c= & ac=)
            const params = new URLSearchParams({
                nombre: this.inputNombre.value.trim(),
                idAvatar: this.avatarSeleccionado.dataset.idAvatar
            });

            console.log('VInicio: redirigiendo con params', params.toString());

            
            try {
                window.location.href = `./index.php?controller=Jugador&action=guardarJugador&${params.toString()}`;
            } catch (e) {
                console.error('VInicio: error al redirigir', e);
                alert('Error al redirigir: ' + e.message);
            }
    }

}
