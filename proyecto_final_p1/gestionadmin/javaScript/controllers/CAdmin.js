export class CAdmin {
    constructor(modelo, vista) {
        this.modelo = modelo;
        this.vista = vista;
        console.log('Controlador: Inicializado.');
        this.cargarTemas();
        this.tomarJuegos();
    }
    
    async cargarTemas() {
        try {
            console.log("Controlador: Solicitando datos de temas al Modelo...");
            const temas = await this.modelo.obtenerTemas();
            console.log("Controlador: Datos de temas recibidos del Modelo");
            console.log("Controlador: Enviando datos de temas a la Vista...");
            this.vista.mostrarTemas(temas);
            console.log("Controlador: Datos de temas enviados a la Vista");
        } catch (error) {
            this.vista.mostrarError("Fallo al cargar los temas.");
        }
    }

    async tomarJuegos(){
        try{
            console.log("Controlador: Solicitando datos de juegos al Modelo...");
            const juegos = await this.modelo.obtenerJuegos();
            console.log("Controlador: Datos de juegos recibidos del Modelo");
            console.log("Controlador: Enviando datos de juegos a la Vista...");
            this.vista.comprobarJuegos(juegos);
            console.log("Controlador: Datos de juegos enviados a la Vista");
        }catch(error){
            this.vista.mostrarError("Fallo al cargar los juegos.");
        }
    }

    async crearJuego(titulo,publico,temas,usuario){
        this.modelo.crearJuego(titulo,publico,temas,usuario);
    }

}