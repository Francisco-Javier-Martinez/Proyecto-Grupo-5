export class VInicio{
    constructor(){
        this.cajaAvatares = document.getElementById("avatares");
        this.avatarSeleccionado = null;
        this.inputNombre = document.getElementById("jugadorNombre");
        this.form = document.getElementById("inicioForm");
        this.cargarAvatares();

        // Escuchar el envío del formulario para validar antes de enviar
        if(this.form){
            this.form.addEventListener("submit", (e) => {
                e.preventDefault();
                this.validarYContinuar();
            });
        }
    }

    cargarAvatares(){
        const avatares = [
            { nombre: "zorro.png", ruta: "./Avatares/zorro.png" },
            { nombre: "rastrollo.png", ruta: "./Avatares/rastrollo.png" },
            { nombre: "spiderman.png", ruta: "./Avatares/spiderman.png" },
            { nombre: "cheft.png", ruta: "./Avatares/cheft.png" },
            { nombre: "doreamon.png", ruta: "./Avatares/doreamon.png" }
        ];
        
        avatares.forEach(avatar => {
            let imagen = document.createElement("img");
            imagen.src = avatar.ruta;
            
            // **IMPORTANTE:** Usar setAttribute para asegurar que se guarde
            imagen.setAttribute("data-nombre", avatar.nombre);
            
            // También puedes usar dataset directamente
            // imagen.dataset.nombre = avatar.nombre;
            
            imagen.alt = avatar.nombre;
            imagen.style.width = "100px";
            imagen.style.cursor = "pointer";
            imagen.style.margin = "10px";
            
            imagen.addEventListener("click", () => {
                // Si ya hay un avatar seleccionado, le quitamos el borde
                if(this.avatarSeleccionado && this.avatarSeleccionado !== imagen){
                    this.avatarSeleccionado.style.border = "none";
                }
            
                // Si el avatar clickeado no es el que ya estaba seleccionado
                if(this.avatarSeleccionado !== imagen){
                    imagen.style.border = "5px solid green";
                    imagen.style.borderRadius = "10px";
                    this.avatarSeleccionado = imagen;
                } else {
                    // Si clickeamos el mismo avatar, lo deseleccionamos
                    imagen.style.border = "none";
                    this.avatarSeleccionado = null;
                }
            });
            
            this.cajaAvatares.appendChild(imagen);
        });    
    }

    validarYContinuar(){
        console.log("=== VALIDAR Y CONTINUAR ===");
        
        // Validar nombre
        if(!this.inputNombre.value || this.inputNombre.value.trim() === ""){
            alert("¡Coloca algún nombre!");
            return;
        }
        if(this.inputNombre.value.length < 5){
            alert("¡Mínimo 5 caracteres!");
            return;
        }
        
        // Validar avatar seleccionado
        if(!this.avatarSeleccionado){
            alert("¡Selecciona un avatar!");
            return;
        }
        
        // Rellenar avatar hidden y enviar el formulario
        const avatarInput = document.getElementById('avatarInput');
        if(avatarInput && this.avatarSeleccionado){
            // Usar dataset.nombre - DEBERÍA ser "zorro.png", "spiderman.png", etc.
            avatarInput.value = this.avatarSeleccionado.dataset.nombre;
            console.log("Valor asignado a avatarInput:", avatarInput.value);
        }
        
        if(this.form){
            localStorage.setItem("nombreJugador", this.inputNombre.value.trim());
            
            // Guardar solo el nombre del archivo
            const nombreAvatar = this.avatarSeleccionado.dataset.nombre;
            localStorage.setItem("avatarJugador", nombreAvatar);
            console.log("Guardado en localStorage - avatarJugador:", nombreAvatar);
            
            this.form.submit();
        } else {
            // Fallback
            window.location.href = "./index.php?controller=Juego&action=iniciarJuego";
        }
    }

    
}