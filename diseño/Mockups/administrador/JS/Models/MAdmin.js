export class MAdmin {
    constructor() {
    
    }

    async obtenerTemas(){
        return await fetch('./JS/Data/temas.json').then(r => r.json());
    }

    async obtenerJuegos(){
        return await fetch('./JS/Data/juegos.json').then(r => r.json());
    }
    
}