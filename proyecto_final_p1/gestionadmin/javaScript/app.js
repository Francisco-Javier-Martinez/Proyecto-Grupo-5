import { MAdmin } from './models/MAdmin.js';
import { VAdmin } from './views/VAdmin.js';
import { CAdmin } from './controllers/CAdmin.js';
import { MPreguntasRespuestas } from './models/mPreguntasRespuestas.js';


import { MTemas } from './models/MTemas.js';
import { VTemas } from './views/VTemas.js';
import { CTemas } from './controllers/CTemas.js';

import { VanadirProfesores } from './views/vanadirProfesores.js';
import { RegistroAdmin} from './views/registroAdmin.js';
import { GestionAvatares } from './views/gestionAvatares.js';
import { CreacionPreguntasRespuestas } from './views/creacionPreguntasRespuestas.js';
import { ModificarPreguntasRespuestas } from './views/modificarPreguntasRespuestas.js';
import { CPreguntasRespuestas } from './controllers/cPreguntasRespuestas.js';

let page = document.body.id; //Toma el id del body de la pagina para hacer el switchs

switch(page){
    case 'creacionJuegos':
        const modelo = new MAdmin();
        const vista = new VAdmin();
        const controlador = new CAdmin(modelo, vista);
        break;
    case 'modificacionTemas':
        console.log('Aplicación TEMA inicializada');
        // const urlParams = new URLSearchParams(window.location.search);
        // const titulo = urlParams.get('titulo');
        const modeloT = new MTemas();
        const vistaT = new VTemas();
        const controladorT = new CTemas(modeloT, vistaT);
        break;
    //caso para añadir profesores
    case 'profesores':
        const vanadirProfesores = new VanadirProfesores();        
        break;
    case 'loginAdmin':
        const registroAdmin = new RegistroAdmin();
        const mAdmin = new MAdmin();
        const cAdmin = new CAdmin(mAdmin, registroAdmin);
        break;
    case 'gestionAvatares':
        const formAvatares = new GestionAvatares();
        break;
    case 'gestionPreguntas':
        const creacionPreguntasRespuestas = new CreacionPreguntasRespuestas();
        creacionPreguntasRespuestas.actualizarRadios();
        break;

    case 'modificarPreguntas':
        const mPreguntasRespuestas = new MPreguntasRespuestas(); 

        // 2. Controlador sin vista aún
        const cPreguntasRespuestas = new CPreguntasRespuestas(mPreguntasRespuestas, null);

        // 3. Vista con controlador
        const modificarPreguntasRespuestas = new ModificarPreguntasRespuestas(cPreguntasRespuestas);

        // 4. Asignar vista al controlador
        cPreguntasRespuestas.vista = modificarPreguntasRespuestas;

        // 5. Ahora sí obtenemos los datos
        cPreguntasRespuestas.obtenerPreguntasRespuestas();
    default:
        console.log('Página no reconocida por la aplicación MVC');
        break;
}
console.log('Aplicación MVC inicializada');
