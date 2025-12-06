export class MAdmin {
    constructor() {
        this.baseUrl = 'https://24.daw.esvirgua.com/JosephParte/administrador/api';
    }

    async obtenerTemas() {
        const response = await fetch(`${this.baseUrl}/consultarTemas.php`);
        return await response.json();
    }

    async obtenerJuegos(){
        //Simulación de bbdd con json, esto llamaria al index.php para traer los datos
        return await fetch('./JS/Data/juegos.json').then(r => r.json());
    }

    async crearJuego(titulo,publico,temas,usuario){
        //Aqui hay que llamar al index.php para crear el juego
    }
    
} 