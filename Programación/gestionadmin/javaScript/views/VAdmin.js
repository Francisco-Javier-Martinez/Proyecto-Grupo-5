export class VAdmin{
    constructor(){
        console.log("Vista: Constructor ejecutado...");
        // this.cuadroTemas = document.querySelector(".temas-box");
        this.cuadroTemas = document.querySelector(".splide__list");
        this.cuadroTemasSeleccionados = document.getElementById("seleccionados");
        this.alerta = document.getElementById("alert");
        this.contadorSeleccionados = 0;
        this.temasSeleccionados = new Set();
        this.tituloJuego = document.getElementById("tituloJuego");
        this.btnCrearJuego = document.getElementById("crearJuego");
        this.checkJuegoPublico = document.getElementById("checkbox-publico");
        this.form = document.getElementById("formCrearJuego");
        this.temasInput = document.getElementById("temasSeleccionadosInput");
        this.configurarFormulario();
    }

    configurarFormulario() {
        // Manejar envío del formulario
        this.form.addEventListener("submit", (e) => this.validarYEnviar(e));
    }

    validarYEnviar(e) {
        // Validaciones
        if (this.tituloJuego.value.trim() === "") {
            e.preventDefault();
            this.mostrarAlert("El título del juego es obligatorio", "error");
            return;
        }
        
        if (this.contadorSeleccionados !== 4) {
            e.preventDefault();
            this.mostrarAlert("Debes seleccionar exactamente 4 temas", "error");
            return;
        }
        
        // Actualizar input oculto con los temas seleccionados
        this.temasInput.value = Array.from(this.temasSeleccionados).join(',');
        
        // Continuar con el envío normal (PHP procesará)
        console.log("Enviando formulario con temas:", this.temasInput.value);
    }
    

    temaAccion(){
        this.style.backgroundColor = "blue";
    }

    mostrarTemas(temas){
        temas.forEach(tema => {
            //Creamos un elemento li para agregar a la lista del slide
            let tema_item = document.createElement("li");
            tema_item.className = "splide__slide tema-item";
            tema_item.textContent = tema.nombre;
            tema_item.dataset.id = tema.idTema; //ID para identificar
            
            //Añadimos acción al elemento
            tema_item.addEventListener("click", () => this.accionTema(tema, tema_item));
            //Añadimos el elemento al campo de los temas
            this.cuadroTemas.appendChild(tema_item);
        });
        this.actualizarContador();
        this.cargarSlide();
    }
    
    accionTema(tema, elemento) {
        //Verifica que tengas menos de 4 temas
        if (this.contadorSeleccionados >= 4) {
            this.mostrarAlert("¡Ya tienes 4 temas!");
            return;
        }
        
        // Evitar seleccionar el mismo tema dos veces
        if (this.temasSeleccionados.has(tema.idTema)) {
            this.mostrarAlert("¡Este tema ya está seleccionado!");
            return;
        }
        
        //Para identificar los seleccionados
        elemento.style.background = "linear-gradient(135deg, #6ab0de, #4a90e2)";
        
        //Crear elemento seleccionado
        let tema_div = document.createElement("div");
        tema_div.className = "tema-item";
        tema_div.textContent = tema.nombre;
        tema_div.dataset.id = tema.idTema;
        
        //Botón para eliminar
        tema_div.addEventListener("click", () => {
            this.eliminarTema(tema.idTema, elemento, tema_div);
        });
        
        this.cuadroTemasSeleccionados.appendChild(tema_div);
        
        //Actualizamos contadores
        this.temasSeleccionados.add(tema.idTema);
        this.contadorSeleccionados++;
        this.actualizarContador();
    }
    
    eliminarTema(idTema, elemento, divSeleccionado) {
        //Le quitamos el borde
        elemento.style.background = "#57277B";
        
        //Lo quitamos de la lista
        divSeleccionado.remove();
        this.temasSeleccionados.delete(idTema);
        this.contadorSeleccionados--;
        this.actualizarContador();
    }
    
    actualizarContador() {
        // El contador sube o baja
        const contador = document.getElementById('contador-temas');
        if (contador) {
            contador.textContent = `${this.contadorSeleccionados}`;
        }
    }

    mostrarError(error){
        console.error("Error: ",error);
    }
    
    cargarSlide(){
        //Creación del carrusel 
        var splide = new Splide( '.splide', {
            type : 'loop',
            perPage : 3,    
            rewind : true,
            wheel : true,
            pagination: false
        } ); 
        splide.mount();
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
    
    comprobarJuegos(juegos){
        this.btnCrearJuego.addEventListener("click", (e) =>{
            e.preventDefault(); 
            juegos.forEach(juego => {
                if(this.tituloJuego.value == juego.descripcion){
                    this.mostrarAlert("¡El juego ya existe!");
                }
                //Función para crear el juego, php debe tener constancia del id del Usuario
                //this.controlador.crearJuego(this.tituloJuego.value,this.checkJuegoPublico,this.temasSeleccionados,idUsuario);
            });
        })
    }
}

