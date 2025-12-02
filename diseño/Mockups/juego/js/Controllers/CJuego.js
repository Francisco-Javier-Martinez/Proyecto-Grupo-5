export class CJuego {
    constructor(modelo, vista) {
        this.modelo = modelo;
        this.vista = vista;
        console.log('Controlador: Inicializado.');
        this.cargarPreguntasConRespuestas(); 
    }

    // Método para cargar preguntas con respuestas
    async cargarPreguntasConRespuestas() {
        try {
            console.log("Controlador: Solicitando preguntas COMPLETAS al Modelo...");
            const preguntasCompletas = await this.modelo.obtenerPreguntasConRespuestas();
            console.log("Controlador: Datos de preguntas COMPLETAS recibidos del Modelo");
            console.log("Controlador: Enviando preguntas COMPLETAS a la Vista...")
            this.vista.mostrarPreguntas(preguntasCompletas);
            console.log("Controlador: Preguntas COMPLETAS enviadas a la Vista");
        } catch (error) {
            this.vista.mostrarError("Fallo al cargar las preguntas con respuestas.");
        }
    }

    async cargarTemas() {
        try {
            console.log("Controlador: Solicitando datos de temas al Modelo...");
            const temas = await this.modelo.obtenerTemas();
            console.log("Controlador: Datos de temas recibidos del Modelo");
            console.log("Controlador: Enviando datos de temas a la Vista...")
            this.vista.mostrarTemas(temas);
            console.log("Controlador: Datos de temas enviados a la Vista");
        } catch (error) {
            this.vista.mostrarError("Fallo al cargar los temas.");
        }
    }
}