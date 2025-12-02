export class VJuego {
    constructor() {
        console.log("Vista: Constructor ejecutado...");
        
        // Selectores
        this.contenedorPreguntas = document.querySelector(".pregunta-section");
        this.contenedorRespuestas = this.contenedorPreguntas.querySelector(".respuestas");
        
        // Array de colores para las respuestas
        this.colores = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4'];
    }

    mostrarPreguntas(preguntasCompletas) {
        // Toma solo la PRIMERA pregunta para mostrar
        if (preguntasCompletas.length > 0) {
            const pregunta = preguntasCompletas[0];
            
            // Crea elementos para la pregunta
            const titulo = `<h2>${pregunta.titulo || 'Sin título'}</h2>`;
            const imagenHTML = pregunta.imagen && pregunta.imagen !== "" ? 
                `<img src="images/${pregunta.imagen}" alt="${pregunta.titulo}" class="imagen-pregunta">` : 
                '<div class="cuadro-imagen">[Imagen de la pregunta]</div>';
            
            // Agrega el título y la imagen
            this.contenedorPreguntas.innerHTML = `
                ${titulo}
                <div class="imagen-pregunta-container">
                    ${imagenHTML}
                </div>
                <div class="respuestas">
                    <!-- Las respuestas se insertarán aquí -->
                </div>
            `;

            this.contenedorRespuestas = this.contenedorPreguntas.querySelector(".respuestas");
            
            // Ahora muestra las respuestas de ESTA pregunta
            if (pregunta.respuestas && pregunta.respuestas.length > 0) {;
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
        
        // Crea un botón por cada respuesta
        respuestasArray.forEach((respuesta, index) => {
            
            const boton = document.createElement("button");
            
            // Configura el botón
            boton.className = "respuesta";
            boton.textContent = `${respuesta.nLetra}) ${respuesta.texto}`;
            
            // Usa data attributes para almacenar información
            boton.dataset.esCorrecta = respuesta.es_correcta ? "1" : "0";
            boton.dataset.nLetra = respuesta.nLetra;
            boton.dataset.texto = respuesta.texto;
            
            // Estilos INLINE para asegurar que se vean
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
        
        // CORREGIDO: usa 'boton' en lugar de 'this'
        localStorage.setItem('respuestaCorrecta', esCorrecta);
        localStorage.setItem('respuestaTexto', boton.textContent);
        localStorage.setItem('respuestanLetra', boton.dataset.nLetra);

        // CORREGIDO: obtén TODOS los botones de respuesta
        const todosLosBotones = document.querySelectorAll(".respuesta");
        
        // Deshabilita todos los botones
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
        
        // Pasa a la siguiente pregunta
        setTimeout(() => {
            window.location.href = "../juego/feeckback.html";
        }, 1000);
    }

}