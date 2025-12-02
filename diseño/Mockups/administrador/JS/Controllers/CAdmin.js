export class CAdmin {
    constructor(modelo, vista) {
        this.modelo = modelo;
        this.vista = vista;
        console.log('Controlador: Inicializado.');
        this.cargarTemas();
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