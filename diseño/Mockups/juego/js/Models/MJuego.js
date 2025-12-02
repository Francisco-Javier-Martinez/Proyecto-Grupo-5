export class MJuego {
    constructor() {
        this.cachePreguntas = null;
        this.cacheRespuestas = null;
    }

    // Método que combina preguntas y respuestas
    async obtenerPreguntasConRespuestas() {
        try {
            // Obtener ambas cosas en paralelo
            const [preguntasData, respuestasData] = await Promise.all([
                fetch('./js/Data/preguntas.json').then(r => r.json()),
                fetch('./js/Data/respuestas.json').then(r => r.json())
            ]);

            // Combinar los datos
            const preguntasCompletas = preguntasData.map(pregunta => {
                // Filtrar respuestas para esta pregunta
                const respuestasPregunta = respuestasData.filter(respuesta => 
                    respuesta.idTema === pregunta.idTema && 
                    respuesta.nPregunta === pregunta.nPregunta
                );

                // Retornar pregunta con sus respuestas
                return {
                    ...pregunta,
                    respuestas: respuestasPregunta
                };
            });

            return preguntasCompletas;
        } catch (error) {
            console.error('Error combinando datos:', error);
            throw error;
        }
    }

    obtenerTemas(){
        return fetch('../js/Data/temas.json').then(r => r.json());
    }

    async obtenerPreguntas() {
        return fetch('../js/Data/preguntas.json').then(r => r.json());
    }

    async obtenerRespuestas() {
        return fetch('../js/Data/respuestas.json').then(r => r.json());
    }
}