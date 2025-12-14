import { MAdmin } from './models/MAdmin.js';
import { VAdmin } from './views/VAdmin.js';
import { CAdmin } from './controllers/CAdmin.js';
import { MPreguntasRespuestas } from './models/mPreguntasRespuestas.js';

import { VTemas } from './views/VTemas.js';
import { CTemas } from './controllers/CTemas.js';

import { ModificarPassword } from './views/modificarPassword.js';
import { VanadirProfesores } from './views/vanadirProfesores.js';
import { RegistroAdmin} from './views/registroAdmin.js';
import { GestionAvatares } from './views/gestionAvatares.js';
import { CreacionPreguntasRespuestas } from './views/creacionPreguntasRespuestas.js';
import { ModificarPreguntasRespuestas } from './views/modificarPreguntasRespuestas.js';
import { CPreguntasRespuestas } from './controllers/cPreguntasRespuestas.js';
import { VPanelAdmin } from './views/VPanelAdmin.js';

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
    case 'profesores':
        const vanadirProfesores = new VanadirProfesores();        
        break;
    case 'loginAdmin':
        const registroAdmin = new RegistroAdmin();
        const mAdmin = new MAdmin();
        const cAdmin = new CAdmin(mAdmin, registroAdmin);
        break;
    case 'gestionAvatares':
        const gestionAvatares = new GestionAvatares();
        break;
    case 'gestionPreguntas':
        const creacionPreguntasRespuestas = new CreacionPreguntasRespuestas();
        creacionPreguntasRespuestas.actualizarRadios();
        break;

    case 'modificarPreguntas':
        const mPreguntasRespuestas = new MPreguntasRespuestas(); 
        const cPreguntasRespuestas = new CPreguntasRespuestas(mPreguntasRespuestas, null);
        const modificarPreguntasRespuestas = new ModificarPreguntasRespuestas(cPreguntasRespuestas);
        cPreguntasRespuestas.vista = modificarPreguntasRespuestas;
        cPreguntasRespuestas.obtenerPreguntasRespuestas();
        break;
    case 'modificarProfesor':
        const modificarProfesores = new VmodificarProfesores();
        const modeloM = new MAdmin();
        const controladorM = new CAdmin(modeloM,modificarProfesores);
        controladorM.tomarAdministrador();
        console.log('Vista Modificar inicializando');
        break;
    case 'codigo':
        const cambiarPassword = new ModificarPassword();
        break;
    case 'panelAdministrador':
        console.log("HOLAAAA");
        const vistaPA = new VPanelAdmin();
        break;
    default:
        console.log('Página no reconocida por la aplicación MVC');
        break;
}
console.log('Aplicación MVC inicializada');
