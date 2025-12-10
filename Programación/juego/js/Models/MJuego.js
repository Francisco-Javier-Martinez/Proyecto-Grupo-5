export class MJuego {
    constructor() {
        // Usar `window.API_BASE` si está definido (flexible para despliegues),
        // si no, por defecto usar una ruta relativa al directorio `api`.
        // Esto evita peticiones a hosts externos cuando trabajas en local.
        this.baseUrl = (typeof window !== 'undefined' && window.API_BASE)
            ? window.API_BASE.replace(/\/+$/,'')
            : 'api';
    }

    async obtenerPreguntasConRespuestas(idTema) {
        try {
            const url = `${this.baseUrl}/consultarPreguntas.php?idTema=${encodeURIComponent(idTema)}`;
            const response = await fetch(url, { credentials: 'include' });
            if (!response.ok) {
                throw new Error(`HTTP ${response.status} - ${response.statusText}`);
            }
            const preguntas = await response.json();
            if (!Array.isArray(preguntas)) {
                throw new Error('Formato de respuesta inválido: se esperaba un array de preguntas');
            }
            console.log('Preguntas recibidas:', preguntas.length, 'preguntas desde', url);
            return preguntas;
        } catch (err) {
            console.error('Error en MJuego.obtenerPreguntasConRespuestas:', err);
            throw err;
        }
    }

    obtenerTemas() {
        return fetch('../js/Data/temas.json').then(r => r.json());
    }
}