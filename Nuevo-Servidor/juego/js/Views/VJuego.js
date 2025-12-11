export class VJuego {
    constructor() {
        console.log("Vista: Constructor ejecutado...");

        // Selectores
        this.contenedorPreguntas = document.querySelector(".pregunta-section");
        if (this.contenedorPreguntas) {
            this.contenedorRespuestas = this.contenedorPreguntas.querySelector(".respuestas");
        } else {
            this.contenedorRespuestas = null;
            console.error("Error: No se encontró .pregunta-section en el DOM");
        }
        
        // Array de colores para las respuestas
        this.colores = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'];
        this.cargarTimer();

        if(localStorage.getItem('contadorPreguntas')!== null){
            this.contadorPreguntas = parseInt(localStorage.getItem('contadorPreguntas'));
        }else{
            this.contadorPreguntas = 0;
            localStorage.setItem('contadorPreguntas', this.contadorPreguntas.toString());
        }

        const urlParams = new URLSearchParams(window.location.search);
        this.tema = urlParams.get('tema');

        this.respuestaCorrecta = null;
    }

    reiniciarJuego(){
        localStorage.removeItem('contadorPreguntas');                                                                                                                                                                       
    }

    cargarTimer(){
        const timerElement = document.querySelector('.timer');
        let totalSeconds = 30; // Tiempo total en segundos
        timerElement.textContent = `00:${totalSeconds < 10 ? '0' : ''}${totalSeconds}`;
        const countdown = setInterval(() => {
            totalSeconds--;
            timerElement.textContent = `00:${totalSeconds < 10 ? '0' : ''}${totalSeconds}`;
            if (totalSeconds <= 0) {
                clearInterval(countdown);
                // Si el tiempo se agota, redirigir al feedback
                window.location.href = `../juego/feeckback.html?tema=${this.tema}&correcta=${this.respuestaCorrecta}`;
            }
        }, 1000);
    }

    mostrarPreguntas(arrayPreguntas) {
        //Manda al ranking si no hay mas preguntas por responder
        if (this.contadorPreguntas >= arrayPreguntas.length) {
            window.location.href = "../juego/ranking.html";
            return;
        }

        // Toma la primera pregunta para mostrar
        if (arrayPreguntas.length > 0) {
            const pregunta = arrayPreguntas[this.contadorPreguntas];
            localStorage.setItem('respuestaExplicacion', pregunta.explicacion);
            // Crea elementos para la pregunta
            const titulo = `<h2>${pregunta.titulo || 'Sin título'}</h2>`;
            const imagen = pregunta.imagen && pregunta.imagen !== "" ? 
                `<img src="images/${pregunta.imagen}" alt="${pregunta.titulo}" class="imagen-pregunta">` : 
                '<div class="cuadro-imagen">[Imagen de la pregunta]</div>';
            
            // Agrega el título, la imagen y el cuadro de respuestas
            this.contenedorPreguntas.innerHTML = `
                ${titulo}
                <div class="imagen-pregunta-container">
                    ${imagen}
                </div>
                <div class="respuestas">
                    
                </div>
            `;

            this.contenedorRespuestas = this.contenedorPreguntas.querySelector(".respuestas");

            //Muestra las respuestas de esta pregunta
            if (pregunta.respuestas && pregunta.respuestas.length > 0) {
                this.mostrarRespuestas(pregunta.respuestas);
                
            } else {
                if (this.contenedorRespuestas) {
                    this.contenedorRespuestas.innerHTML = '<p>No hay respuestas disponibles</p>';
                }
            }
        } else {
            this.contenedorPreguntas.innerHTML = '<p>No hay preguntas disponibles</p>';
        }
    }

    mostrarError(mensaje){
        console.error(mensaje);
    }

    mostrarRespuestas(respuestasArray) {
        // Limpia el contenedor de respuestas
        if (!this.contenedorRespuestas) {
            
            // Intenta encontrar el contenedor de nuevo
            this.contenedorRespuestas = document.querySelector(".respuestas");
            
            if (!this.contenedorRespuestas) {
                // Crea el contenedor si no existe
                this.contenedorRespuestas = document.createElement("div");
                this.contenedorRespuestas.className = "respuestas";
                document.querySelector(".pregunta-container")?.appendChild(this.contenedorRespuestas);
            }
        }
        
        this.contenedorRespuestas.innerHTML = '';
        
        // Barajar las respuestas 
        const respuestasMezcladas = [...respuestasArray]; 
        
        for (let i = respuestasMezcladas.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [respuestasMezcladas[i], respuestasMezcladas[j]] = [respuestasMezcladas[j], respuestasMezcladas[i]];
        }

        // Crea un botón por cada respuesta
        respuestasMezcladas.forEach((respuesta, index) => {
            
            const boton = document.createElement("button");
            
            // Configura el botón
            boton.className = "respuesta";
            boton.textContent = `${respuesta.nLetra}) ${respuesta.texto}`;
            
            // Usa data attributes para almacenar información
            boton.dataset.esCorrecta = respuesta.es_correcta ? "1" : "0";
            boton.dataset.nLetra = respuesta.nLetra;
            boton.dataset.texto = respuesta.texto;

            if(respuesta.es_correcta=="1"){
                this.respuestaCorrecta = respuesta.nLetra;
            }
            
            boton.style.cssText = `
                background-color: ${this.colores[index % this.colores.length]};
            `;
            
            // Event listener
            boton.addEventListener("click", (event) => {
                this.accionRespuestas(event);
            });
            
            // Agrega al contenedor
            this.contenedorRespuestas.appendChild(boton);
        });
    }

    accionRespuestas(event) {
        const boton = event.currentTarget;
        const esCorrecta = boton.dataset.esCorrecta === "1";
        
        localStorage.setItem('respuestaCorrecta', esCorrecta);
        localStorage.setItem('respuestaTexto', boton.textContent);
        localStorage.setItem('respuestanLetra', boton.dataset.nLetra);

        const todosLosBotones = document.querySelectorAll(".respuesta");
        
        todosLosBotones.forEach(btn => {
            btn.disabled = true;
            btn.style.opacity = "0.7";
        });
        
        // Mostrar si es correcta o no
        if (esCorrecta) {
            boton.style.backgroundColor = "green";
            boton.style.color = "white";
        } else {
            boton.style.backgroundColor = "red";
            boton.style.color = "white";
            
            // Encuentra y marca la respuesta correcta
            const botonCorrecto = document.querySelector('.respuesta[data-es-correcta="1"]');
            if (botonCorrecto) {
                botonCorrecto.style.backgroundColor = "green";
                botonCorrecto.style.color = "white";
            }
        }

        this.contadorPreguntas++;
        localStorage.setItem('contadorPreguntas', this.contadorPreguntas.toString());
        
        // Pasa a la siguiente pregunta
        setTimeout(() => {
            window.location.href = `../juego/feeckback.html?tema=${this.tema}&correcta=${this.respuestaCorrecta}`;
        }, 1000);
    }
}