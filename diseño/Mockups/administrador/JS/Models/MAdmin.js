export class MAdmin {
    constructor() {
    
    }

    async obtenerTemas(){
        //Simulación de bbdd con json, esto llamaria al index.php para traer los datos
        return await fetch('./JS/Data/temas.json').then(r => r.json());
    }

    async obtenerJuegos(){
        //Simulación de bbdd con json, esto llamaria al index.php para traer los datos
        return await fetch('./JS/Data/juegos.json').then(r => r.json());
    }
    
}