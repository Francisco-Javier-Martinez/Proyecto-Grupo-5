export class CTemas {
    constructor(modelo, vista) {
        this.modelo = modelo;
        this.vista = vista;
        console.log('Controlador: Inicializado.');
    }

    modificarTema(nombre,descripcion,publico,idTema){
        this.modelo.modificarTema(nombre,descripcion,publico,idTema);
    }
    
    traerTema(idTema){
        this.modelo.traerTema(idTema);
    }
}