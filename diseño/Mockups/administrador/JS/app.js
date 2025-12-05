import { MAdmin } from './Models/MAdmin.js';
import { VAdmin } from './Views/VAdmin.js';
import { CAdmin } from './Controllers/CAdmin.js';

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
            
            break;
    }
    console.log('Aplicación MVC inicializada');
});