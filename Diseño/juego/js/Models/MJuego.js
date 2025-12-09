export class MJuego {
    constructor() {
        this.baseUrl = 'https://24.daw.esvirgua.com/JosephParte/juego/api';
    }

    async obtenerPreguntasConRespuestas(idTema) {
        const response = await fetch(`${this.baseUrl}/consultarPreguntas.php?idTema=${idTema}`);
        const preguntas = await response.json(); 
        
        console.log(' Preguntas recibidas:', preguntas.length, 'preguntas');
        
        return preguntas; 
    }

    obtenerTemas() {
        return fetch('../js/Data/temas.json').then(r => r.json());
    }
}