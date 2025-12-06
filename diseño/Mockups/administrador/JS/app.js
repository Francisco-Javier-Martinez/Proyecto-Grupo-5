import { MAdmin } from './Models/MAdmin.js';
import { VAdmin } from './Views/VAdmin.js';
import { CAdmin } from './Controllers/CAdmin.js';

import { MTemas } from './Models/MTemas.js';
import { VTemas } from './Views/VTemas.js';
import { CTemas } from './Controllers/CTemas.js';

// Inicializar la aplicación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    let page = document.body.id; //Toma el id del body de la pagina para hacer el switch

    switch(page){
        case 'creacionJuegos':
            const modelo = new MAdmin();
            const vista = new VAdmin();
            const controlador = new CAdmin(modelo, vista);
            break;
        case 'modificacionTemas':
            console.log('Aplicación TEMA inicializada');
            const urlParams = new URLSearchParams(window.location.search);
            const titulo = urlParams.get('titulo');
            const modeloT = new MTemas();
            const vistaT = new VTemas(titulo);
            const controladorT = new CTemas(modeloT, vistaT);
            break;
    }
    console.log('Aplicación MVC inicializada');
});