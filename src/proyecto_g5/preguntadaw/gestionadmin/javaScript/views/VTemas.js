export class VTemas{
    constructor(){
        console.log("Vista: Constructor ejecutado...");
        
        this.inputTitulo = document.getElementById('nombreTema'); 
        this.inputDescripcion = document.getElementById('descripcionTema');
        this.alerta = document.getElementById("alert");
        this.inputAbreviatura = document.getElementById('abreviaturaTema');
        this.formulario = document.querySelector('form'); 

        this.botonEliminar = document.getElementById('delete-btn');

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

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
            e.stopPropagation(); // evita que se clicke el <a>

            const url = btn.dataset.url;

            if (window.confirm("¿Seguro que deseas eliminar esta pregunta?")) {
                window.location.href = url;
            }
        });
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

    alertEliminarPregunta() {
        
    }

}



