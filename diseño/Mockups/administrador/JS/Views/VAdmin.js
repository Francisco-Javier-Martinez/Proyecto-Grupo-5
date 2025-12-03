

export class VAdmin{
    constructor(){
        console.log("Vista: Constructor ejecutado...");
        // this.cuadroTemas = document.querySelector(".temas-box");
        this.cuadroTemas = document.querySelector(".splide__list");
        this.cuadroTemasSeleccionados = document.getElementById("seleccionados");
        this.alerta = document.getElementById("alert");
        this.contadorSeleccionados = 0;
        this.temasSeleccionados = new Set(); 
    }

    // mostrarTemas(temas){
    //     temas.forEach(tema => {
    //         let tema_item = document.createElement("div");
    //         tema_item.className = "tema-item";
    //         tema_item.innerHTML = `${tema.nombre}`;
    //         this.cuadroTemas.appendChild(tema_item);
    //     });
    // }

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
        
        // Marcar visualmente
        elemento.style.border = "5px solid #5e94b9ff";
        
        // Crear elemento seleccionado
        let tema_div = document.createElement("div");
        tema_div.className = "tema-item";
        tema_div.textContent = tema.nombre;
        tema_div.dataset.id = tema.idTema;
        
        // Botón para eliminar
        tema_div.addEventListener("click", () => {
            this.eliminarTema(tema.idTema, elemento, tema_div);
        });
        
        this.cuadroTemasSeleccionados.appendChild(tema_div);
        
        // Actualizar contadores
        this.temasSeleccionados.add(tema.idTema);
        this.contadorSeleccionados++;
        this.actualizarContador();
    }
    
    eliminarTema(idTema, elemento, divSeleccionado) {
        // Quitar borde
        elemento.style.border = "none";
        
        // Eliminar de la lista
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
        var splide = new Splide( '.splide', {
            type : 'loop',
            perPage : 4,
            focus : 'center',
            wheel : true,
            } );

            splide.mount();

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
    
}

