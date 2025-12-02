export class MAdmin {
    constructor() {
    
    }

    obtenerTemas(){
        return fetch('./JS/Data/temas.json').then(r => r.json());
    }
    
}