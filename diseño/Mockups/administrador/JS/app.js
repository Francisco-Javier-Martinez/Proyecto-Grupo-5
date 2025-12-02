import { MAdmin } from './Models/MAdmin.js';
import { VAdmin } from './Views/VAdmin.js';
import { CAdmin } from './Controllers/CAdmin.js';

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    const modelo = new MAdmin();
    const vista = new VAdmin();
    const controlador = new CAdmin(modelo, vista);
    
    console.log('Aplicación MVC inicializada');
});