import { MJuego } from './Models/MJuego.js';
import { VJuego } from './Views/VJuego.js';
import { CJuego } from './Controllers/CJuego.js';
import { VFeedback } from './Views/VFeedback.js';
import { VInicio } from './Views/VInicio.js';

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    let page = document.body.id;
    const urlParams = new URLSearchParams(window.location.search);
    const tema = parseInt(urlParams.get('tema'));

    console.log("Página actual:", page);

    switch (page) {

        // -----------------------------------------
        // PANTALLA DEL JUEGO
        // -----------------------------------------
        case 'seleccionPreguntas':
            const modeloJuego = new MJuego();
            const vistaJuego = new VJuego();
            const controladorJuego = new CJuego(modeloJuego, vistaJuego, tema);
            
            vistaJuego.reiniciarJuego();
            break;


        // -----------------------------------------
        // FEEDBACK
        // -----------------------------------------
        case 'feedback':
            const vistaFeedback = new VFeedback();
            break;


        // -----------------------------------------
        // INICIO JUGADOR (AVATARES)
        // -----------------------------------------
        case 'inicioJugador':
            const modeloInicio = new MJuego();
            const vistaInicio = new VInicio();
            const controladorInicio = new CJuego(modeloInicio, vistaInicio);

            // Aquí pedimos los avatares al backend
            controladorInicio.cargarAvatares();
            break;
    }

    console.log('Aplicación MVC inicializada');
});
