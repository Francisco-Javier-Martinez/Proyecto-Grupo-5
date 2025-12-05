export class MJuego {
    constructor() {
        this.cachePreguntas = null;
        this.cacheRespuestas = null;
    }

    // Método que combina preguntas y respuestas
    async obtenerPreguntasConRespuestas(idTema) {
        try {
            const [preguntasData, respuestasData] = await Promise.all([
                fetch('./js/Data/preguntas.json').then(r => r.json()),
                fetch('./js/Data/respuestas.json').then(r => r.json())
            ]);

            // Filtrar preguntas por tema
            const preguntasDelTema = preguntasData.filter(pregunta => 
                pregunta.idTema === Number(idTema) 
            );

            // Combinar las preguntas del tema
            const preguntasCompletas = preguntasDelTema.map(pregunta => {
                const respuestasPregunta = respuestasData.filter(respuesta => 
                    respuesta.idTema === pregunta.idTema && 
                    respuesta.nPregunta === pregunta.nPregunta
                );

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