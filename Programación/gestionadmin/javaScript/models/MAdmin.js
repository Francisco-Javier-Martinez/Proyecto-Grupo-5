export class MAdmin {
    constructor() {
        this.baseUrl = 'https://24.daw.esvirgua.com/JosephParte/administrador/api';
    }

    async obtenerTemas() {
        const response = await fetch("http://localhost/Pruebas/Proyecto-Grupo-5/Programación/gestionadmin/php/api/consultarTemas.php");
        return await response.json();
    }

    async crearJuego(titulo,publico,temas,usuario){
        //Aqui hay que llamar al index.php para crear el juego
    }

    async obtenerAdministrador() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        const response = await fetch(`http://localhost/Pruebas/Proyecto-Grupo-5/Programación/gestionadmin/php/api/consultarAdmin.php?id=${id}`);
        return await response.json();
    }
    
} 