import { MJuego } from './Models/MJuego.js';
import { VJuego } from './Views/VJuego.js';
import { CJuego } from './Controllers/CJuego.js';
import { VFeedback } from './Views/VFeedback.js';
import { VInicio } from './Views/VInicio.js';
import { VelegirJuego } from './Views/vElegirJuego.js';

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    let page = document.body.id;
    const urlParams = new URLSearchParams(window.location.search);
    const tema = parseInt(urlParams.get('tema'));
    console.log(tema);
    switch(page){
        case 'seleccionPreguntas':
            const modelo = new MJuego();
            const vista = new VJuego();
            const controlador = new CJuego(modelo, vista, tema);
            vista.reiniciarJuego();
            break;
        case 'feedback':
            const vistaFeedback = new VFeedback();
            break;
        case 'elegirJuego':
            const vistaElegirJuego = new VelegirJuego();
            break;
        case 'inicioJugador':
            console.log("HOLA");
            const modeloInicio = new MJuego();
            const vistaInicio = new VInicio();
            const controladorInicio = new CJuego(modeloInicio, vistaInicio);
            // Aqu pedimos los avatares a la bd
            controladorInicio.cargarAvatares();
            break;    
        }
    console.log('Aplicación MVC inicializada');
});