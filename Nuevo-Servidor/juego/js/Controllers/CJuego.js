export class CJuego {
    constructor(modelo, vista, tema) {
        this.modelo = modelo;
        this.vista = vista;
        console.log('Controlador: Inicializado.');
        this.cargarPreguntasConRespuestas(tema); 
    }

    // Método para cargar preguntas con respuestas
    async cargarPreguntasConRespuestas(tema) {
        try {
            console.log("Controlador: Solicitando preguntas al Modelo...");
            const preguntasCompletas = await this.modelo.obtenerPreguntasConRespuestas(tema);
            console.log("Controlador: Datos de preguntas recibidos del Modelo");
            console.log("Controlador: Enviando preguntas a la Vista...")
            this.vista.mostrarPreguntas(preguntasCompletas);
            console.log("Controlador: Preguntas enviadas a la Vista");
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
    async cargarAvatares() {
        try {
            console.log("Controlador: Solicitando avatares al Modelo...");
            const avatares = await this.modelo.obtenerAvatares();
            
            console.log("Controlador: Avatares recibidos del Modelo");
            this.vista.mostrarAvatares(avatares);

        } catch (error) {
            this.vista.mostrarError("Fallo al cargar los avatares.");
        }
    }

} 