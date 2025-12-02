// feeckback.js - En tu página feeckback.html
document.addEventListener('DOMContentLoaded', function() {
    const cuadroFeedback = document.getElementById("correctoFalso");
    
    // Recuperar datos de localStorage
    const esCorrecta = localStorage.getItem('respuestaCorrecta') === 'true';
    const respuestaTexto = localStorage.getItem('respuestaTexto');
    
    // Limpiar localStorage después de usar (opcional)
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
    
    // // Redirigir automáticamente después de 3 segundos
    // setTimeout(() => {
    //     window.location.href = "seleccion_Preguntas.html";
    // }, 3000);
});