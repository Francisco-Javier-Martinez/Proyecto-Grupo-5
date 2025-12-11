export class VelegirJuego {
    constructor() {
        console.log("Vista Elegir Juego: Constructor ejecutado..."); 
        this.form = document.getElementById('seleccionJuegoForm');
        this.inputCodigo = document.getElementById('codigoJuego');
        this.configurarManejadorFormulario();
        this.configurarBotonesJugar();
        this.tituloNombre = document.getElementById("nombreJugador");

        this.nombreJugador = localStorage.getItem("jugadorNombre");

        this.tituloNombre.innerHTML = "<h1>Bienvenido " + this.nombreJugador + "</h1>";
        
        console.log(this.nombreJugador);
    }

    //Este metodo configura el manejador de eventos para el formulario de selección de juego
    configurarManejadorFormulario() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.manejarEnvioCodigo(e));
        }
    }
    //Este metodo maneja el envio del formulario de selección de juego
    manejarEnvioCodigo(evento) {
        // Obtener el código ingresado por el usuario
        const codigo = this.inputCodigo.value.trim();

        // Mostrar mensaje si la longitud no es correcta
        const cont = document.getElementById('mensajeCodigo');
        if (codigo === '' || codigo.length > 7) {
            // Evitar envío si es inválido
            evento.preventDefault();
            if (cont) { cont.style.display = 'block'; cont.style.color = '#ff5555'; cont.textContent = 'Ha de ser máximo 7 caracteres'; }
            return;
        }
        // El servidor buscará el `idJuego` asociado al código y redirigirá a la ruleta.
    }
    
    configurarBotonesJugar(){
        const tarjetas = Array.from(document.querySelectorAll('.tarjeta'));
        console.log('VelegirJuego: tarjetas encontradas =', tarjetas.length);
        tarjetas.forEach(tarjeta => {
            const btn = tarjeta.querySelector('.jugar');
            if(!btn) return;
            btn.addEventListener('click', (e) => {
                console.log('Jugar: navegación permitida al servidor para cargar la ruleta (MVC)');
            });
        });
    }

}
