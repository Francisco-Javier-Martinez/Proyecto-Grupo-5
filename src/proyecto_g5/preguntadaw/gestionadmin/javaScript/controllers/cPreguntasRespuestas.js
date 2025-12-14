export class CPreguntasRespuestas {
    constructor(modelo, vista) { 
        this.modelo = modelo;
        this.vista = vista; // Inicialmente puede ser null o venir del app.js

        // Obtenemos los IDs de la URL
        const urlParams = new URLSearchParams(window.location.search);
        this.idTema = urlParams.get('idTema');
        this.nPregunta = urlParams.get('nPregunta');
    }

    async obtenerPreguntasRespuestas(){
        try {
            console.log(`Controlador: Solicitando datos para Tema ${this.idTema}, Pregunta ${this.nPregunta}`);
            
            const datos = await this.modelo.sacarPreguntasRespuestas(this.idTema, this.nPregunta);
            console.log(datos);
            if(datos && datos.success) { // Verificamos success del PHP
                console.log('Controlador: Datos recibidos correctamente', datos);
                
                if (this.vista) {
                    this.vista.visualizarDatos(datos);
                } else {
                    console.error("Controlador: La vista no está asignada todavía.");
                }
            } else {
                console.error("Controlador: PHP devolvió success: false o datos vacíos");
            }
        } catch (error) {
            console.error("Controlador Error:", error);
        }
    }
}