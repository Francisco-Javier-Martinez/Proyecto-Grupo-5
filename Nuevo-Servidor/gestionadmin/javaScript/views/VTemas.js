export class VTemas{
    constructor(){
        console.log("Vista: Constructor ejecutado...");
        
        this.inputTitulo = document.getElementById('nombreTema'); 
        this.inputDescripcion = document.getElementById('descripcionTema');
        this.alerta = document.getElementById("alert");
        this.inputAbreviatura = document.getElementById('abreviaturaTema');
        this.formulario = document.querySelector('form'); 

        this.botonEnviar = document.querySelector('.save-btn');

        this.botonEnviar.addEventListener("click", (e) =>{
            e.preventDefault();
            if(this.inputTitulo.value == null || this.inputTitulo.value == ""){
                this.mostrarAlert("¡Introduzca datos en titulo!");
            }else{
                if(this.inputDescripcion.value == null || this.inputDescripcion.value == ""){
                    this.mostrarAlert("¡Introduzca datos en descripción!");
                    window.location.href();
                }else{
                    if(this.inputAbreviatura.value == "" || this.inputAbreviatura.value == null){
                        this.mostrarAlert("¡Introduzca datos en abreviatura!");
                    }else{
                        this.formulario.submit();
                    }
                }
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

