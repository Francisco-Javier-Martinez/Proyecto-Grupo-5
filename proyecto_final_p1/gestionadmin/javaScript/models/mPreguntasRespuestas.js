export class MPreguntasRespuestas {
    constructor() {
        this.API_URL = 'https://rickandmortyapi.com/api/character';

    }

    async sacarPreguntasRespuestas(idTema, nPregunta) {
        const url = `index.php?controller=PreguntasRespuestas&action=editarPregunta&idTema=${idTema}&nPregunta=${nPregunta}`;;
        try{
            const respuesta = await fetch(url);
             if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            const datos = await respuesta.json();
            console.log(datos);
            console.log('Modelo: Datos recibidos.');

            return datos; 
            
        }catch(error){
            console.error("ERROR AL OBTENER DATOS", error);
        }

    }
    
}
