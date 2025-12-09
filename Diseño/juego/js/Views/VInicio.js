export class VInicio{
    constructor(){
        this.cajaAvatares = document.getElementById("avatares");
        this.avatarSeleccionado = null;
        this.inputNombre = document.getElementById("jugadorNombre");
        this.cargarAvatares();
        this.botonIniciar = document.getElementById("entrar");
        
        this.botonIniciar.addEventListener("click", () => {
            this.validarYContinuar();
        });
    }

    validarYContinuar(){
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
        // Continua
        window.location.href = "./seleccionJuego.html";
    }

    cargarAvatares(){
        let avatares = ["./Avatares/alien.png","./Avatares/bombero.png","./Avatares/caballero.png","./Avatares/cuidadora.png"];
        avatares.forEach(avatar => {
            let imagen = document.createElement("img");
            imagen.src = avatar;
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
}