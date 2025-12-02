import { MJuego } from './Models/MJuego.js';
import { VJuego } from './Views/VJuego.js';
import { CJuego } from './Controllers/CJuego.js';

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    const modelo = new MJuego();
    const vista = new VJuego();
    const controlador = new CJuego(modelo, vista);
    
    console.log('Aplicación MVC inicializada');
});