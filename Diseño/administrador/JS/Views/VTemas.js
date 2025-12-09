export class VTemas{
    constructor(titulo){
        console.log("Vista: Constructor ejecutado...");
        
        this.titulo = decodeURIComponent(titulo);
        this.inputTitulo = document.getElementById('nombreTema'); 
        this.inputDescripcion = document.getElementById('descripcionTema'); 
        
        if (this.inputTitulo) {
            this.inputTitulo.value = this.titulo;
        }

        this.botonEnviar = document.querySelector('.save-btn');

        this.botonEnviar.addEventListener("click", (e) =>{
            e.preventDefault();
            if(this.inputDescripcion.value == null || this.inputDescripcion.value == ""){
                this.mostrarAlert("Introduzca datos en descripción");
            }
        });
    }

    mostrarError(error){
        console.error("Error: ",error);
    }

    mostrarAlert(mensaje){
        //Agrega el mensaje
        this.alerta.textContent = mensaje;
        //Pone clase mostrar
        this.alerta.classList.add('mostrar');
        //Oculta después de 3s
        setTimeout(() => {
            this.alerta.classList.remove('mostrar');
        }, 3000);
    }
}

