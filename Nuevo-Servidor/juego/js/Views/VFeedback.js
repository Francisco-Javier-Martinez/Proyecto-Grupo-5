export class VFeedback {
    constructor() {
        console.log("Vista: Constructor ejecutado...");
        const urlParams = new URLSearchParams(window.location.search);
        this.tema = urlParams.get('tema');
        this.respuestaCorrecta = urlParams.get('correcta');
        this.cuadroFeedback();   
    }

    // feeckback.js - En tu página feeckback.html
    cuadroFeedback() {
        const cuadroFeedback = document.getElementById("correctoFalso");
        const botonSiguiente = document.getElementById("siguientePregunta");
        const cuadroExplicacion = document.getElementById("porquePregunta");
        const esCorrecta = localStorage.getItem('respuestaCorrecta') === 'true';
        const respuestaTexto = localStorage.getItem('respuestaTexto');
        const respuestaLetra = localStorage.getItem('respuestanLetra');
        const respuestaExplicacion = localStorage.getItem('respuestaExplicacion');
        
        // Limpiar localStorage
        localStorage.removeItem('respuestaCorrecta');
        localStorage.removeItem('respuestaTexto');
        localStorage.removeItem('respuestaLetra');
        localStorage.removeItem('respuestaExplicacion');
        
        // Aplicar estilos según si fue correctas
        if (cuadroFeedback) {
            if (esCorrecta) {
                cuadroFeedback.style.backgroundColor = "green";
                cuadroFeedback.style.color = "white";
                cuadroFeedback.innerHTML = `
                    <h2>✓ CORRECTO</h2>
                    <h3>+200 PUNTOS</h3>
                `;
            } else {
                cuadroFeedback.style.backgroundColor = "red";
                cuadroFeedback.style.color = "white";
                cuadroFeedback.innerHTML = `
                    <h2>X INCORRECTO</h2>
                    <h3>+0 PUNTOS</h3>
                `;
            }
        }

        cuadroExplicacion.innerHTML = `<h3>Respuesta correcta: ${this.respuestaCorrecta.toUpperCase()}</h3>
            <h4>${respuestaExplicacion}</h4>`;
        cuadroExplicacion.style.fontSize = "1.3rem";
        
        botonSiguiente.addEventListener("click", () =>{
            window.location.href = `./seleccion_Preguntas.html?tema=${this.tema}`;
        })
        
    };
}