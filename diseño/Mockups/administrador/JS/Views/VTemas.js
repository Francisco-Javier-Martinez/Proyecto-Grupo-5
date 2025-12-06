export class VTemas{
    constructor(titulo){
        console.log("Vista: Constructor ejecutado...");
        
        this.titulo = decodeURIComponent(titulo);
        this.inputTitulo = document.getElementById('nombreTema'); 
        
        if (this.inputTitulo) {
            this.inputTitulo.value = this.titulo;
        }
    }
    
    comprobarFormulario(){
        console.log("Vista: Comprobando formulario...");
        
    }

    mostrarError(error){
        console.error("Error: ",error);
    }
}

