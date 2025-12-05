export class VFeedback {
    constructor() {
        console.log("Vista: Constructor ejecutado...");
        const urlParams = new URLSearchParams(window.location.search);
        this.tema = urlParams.get('tema');
        this.cuadroFeedback();   
    }

    // feeckback.js - En tu página feeckback.html
    cuadroFeedback() {
        const cuadroFeedback = document.getElementById("correctoFalso");
        const botonSiguiente = document.getElementById("siguientePregunta");
        const esCorrecta = localStorage.getItem('respuestaCorrecta') === 'true';
        const respuestaTexto = localStorage.getItem('respuestaTexto');
        
        // Limpiar localStorage
        localStorage.removeItem('respuestaCorrecta');
        localStorage.removeItem('respuestaTexto');
        
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
        
        botonSiguiente.addEventListener("click", () =>{
            window.location.href = `./seleccion_Preguntas.html?tema=${this.tema}`;
        })
        
    };
}