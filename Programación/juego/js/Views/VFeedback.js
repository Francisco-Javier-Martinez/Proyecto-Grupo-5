export class VFeedback {
    constructor() {
        
        try {
            // Obtener parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            this.tema = urlParams.get('tema');
            this.respuestaCorrecta = urlParams.get('correcta');
            
            // Inicializar puntos del jugador desde localStorage
            const puntosGuardados = localStorage.getItem('puntosJugador');
            this.puntosJugador = puntosGuardados ? parseInt(puntosGuardados) : 0;
            
            // Mostrar todo el localStorage para depuración
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                const value = localStorage.getItem(key);
                console.log(`${key}: ${value}`);
            }
            
            // Cargar el feedback
            this.cuadroFeedback();   
            
        } catch (error) {
            console.error(" Error en constructor VFeedback:", error);
        }
    }

    cuadroFeedback() {
        try {
            // Obtener elementos del DOM
            const cuadroFeedback = document.getElementById("correctoFalso");
            const botonSiguiente = document.getElementById("siguientePregunta");
            const cuadroExplicacion = document.getElementById("porquePregunta");
            const elementoPuntos = document.getElementById("puntosActuales");
            
            
            // Obtener datos de localStorage
            const esCorrecta = localStorage.getItem('respuestaCorrecta') === 'true';
            const respuestaTexto = localStorage.getItem('respuestaTexto') || '';
            const respuestaLetra = localStorage.getItem('respuestanLetra') || '';
            const respuestaExplicacion = localStorage.getItem('respuestaExplicacion') || 'Sin explicación disponible';
            const puntosObtenidos = parseInt(localStorage.getItem('puntosObtenidos')) || 0;
            
            console.log("esCorrecta:", esCorrecta);
            console.log("respuestaTexto:", respuestaTexto);
            console.log("respuestaLetra:", respuestaLetra);
            console.log("respuestaExplicacion:", respuestaExplicacion);
            console.log("puntosObtenidos:", puntosObtenidos);
            
            // Actualizar puntos totales si la respuesta fue correcta
            if (esCorrecta) {
                this.puntosJugador += puntosObtenidos;
                localStorage.setItem('puntosJugador', this.puntosJugador.toString());
            }
            
            // Mostrar puntos actuales en el header
            if (elementoPuntos) {
                elementoPuntos.textContent = this.puntosJugador;
            } else {
                // Si no existe el elemento, crearlo temporalmente
                const header = document.querySelector('header');
                if (header) {
                    const puntosDiv = document.createElement('div');
                    puntosDiv.className = 'puntuacion-temp';
                    puntosDiv.innerHTML = `Puntos: ${this.puntosJugador}`;
                    puntosDiv.style.color = 'red';
                    puntosDiv.style.fontSize = '20px';
                    header.appendChild(puntosDiv);
                }
            }
            
            // Configurar cuadro de feedback (verde/rojo)
            if (cuadroFeedback) {
                if (esCorrecta) {
                    cuadroFeedback.style.backgroundColor = "green";
                    cuadroFeedback.style.color = "white";
                    cuadroFeedback.innerHTML = `
                        <h2>✓ CORRECTO</h2>
                        <h3>+${puntosObtenidos} PUNTOS</h3>
                    `;
                } else {
                    cuadroFeedback.style.backgroundColor = "red";
                    cuadroFeedback.style.color = "white";
                    cuadroFeedback.innerHTML = `
                        <h2>✗ INCORRECTO</h2>
                        <h3>+0 PUNTOS</h3>
                    `;
                }
            } else {
                console.error("No se pudo configurar cuadroFeedback");
            }
            
            // Configurar cuadro de explicación
            if (cuadroExplicacion) {
                const respuestaMostrar = this.respuestaCorrecta || respuestaLetra;
                cuadroExplicacion.innerHTML = `
                    <h3>Respuesta correcta: ${respuestaMostrar ? respuestaMostrar.toUpperCase() : 'No disponible'}</h3>
                    <h4>${respuestaExplicacion}</h4>
                `;
                cuadroExplicacion.style.fontSize = "1.3rem";
                console.log("Explicación configurada:", respuestaExplicacion);
            }
            
            // Configurar botón "Siguiente Pregunta"
            if (botonSiguiente) {
                botonSiguiente.addEventListener("click", () => {
                    console.log("Botón siguiente clickeado");
                    this.limpiarDatosTemporales();
                    
                    // Verificar si hay más preguntas
                    const contadorPreguntas = parseInt(localStorage.getItem('contadorPreguntas') || '0');
                    const totalPreguntas = parseInt(localStorage.getItem('totalPreguntas') || '0');
                    
                    console.log("Contador preguntas:", contadorPreguntas, "Total preguntas:", totalPreguntas);
                    
                    if (contadorPreguntas >= totalPreguntas && totalPreguntas > 0) {
                        // Redirigir al ranking si no hay más preguntas
                        window.location.href = "../juego/ranking.html";
                    } else {
                        // Redirigir a la siguiente pregunta
                        window.location.href = `./seleccion_Preguntas.html?tema=${this.tema}`;
                    }
                });
            }
            
            // Actualizar nombre del jugador en el header
            const nombreJugador = localStorage.getItem('nombreJugador') || 'Jugador';
            const nombreCuadro = document.querySelector('header div p');
            if (nombreCuadro) {
                nombreCuadro.textContent = nombreJugador;
            }

            const imagenJugador = localStorage.getItem('imagenJugador');
            const imagenCuadro = document.querySelector('header div img'); 
            if (imagenCuadro) {
                if (imagenCuadro) {
                    imagenCuadro.src = `./Avatares/${imagenJugador}`;
                }
            }
            
        } catch (error) {
            console.error(" Error en cuadroFeedback:", error);
            
            // Mostrar mensaje de error en la página
            const main = document.querySelector('main');
            if (main) {
                main.innerHTML = `
                    <div style="color: red; padding: 20px; text-align: center;">
                        <h2> Error al cargar el feedback</h2>
                        <p>${error.message}</p>
                        <p>Abre la consola del navegador (F12) para más detalles.</p>
                        <button onclick="location.reload()">Reintentar</button>
                    </div>
                `;
            }
        }
    }
    
    limpiarDatosTemporales() {
        // Limpiar datos temporales 
        localStorage.removeItem('respuestaCorrecta');
        localStorage.removeItem('respuestaTexto');
        localStorage.removeItem('respuestanLetra');
        localStorage.removeItem('respuestaExplicacion');
        localStorage.removeItem('puntosObtenidos');
        localStorage.removeItem('puntosPregunta');
    }
}