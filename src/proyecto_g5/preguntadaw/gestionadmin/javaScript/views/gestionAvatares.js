export class GestionAvatares {

    constructor() {
        //recoger elementos del DOM
        this.imagenAvatar = document.getElementById('imagenSubidaAvatar');
        this.nombreAvatar = document.getElementById('nombreAvatar');

        //esto son los span de error que los pongo debajo de cada input
        this.errorImagen = document.getElementById('error-img');
        this.errorNombre = document.getElementById('error-nombre');
        
        //Cojo el formulario
        this.formRegistro = document.getElementById('formAvatares');

        //si el formulario se envia, llamo a manejarEnvio con addEventListener
        this.formRegistro.addEventListener('submit', (e) => this.manejarEnvio(e));
    }

    // Método auxiliar para mostrar el error visualmente
    mostrarError(campoError, errorElemento, mensaje) {
        campoError.style.border = '2px solid red';
        errorElemento.style.color = 'red';
        errorElemento.style.paddingTop = '15px';
        errorElemento.textContent = mensaje;
    }

    //Este metodo sirve para limpiar los errores visuales para que si vuelves a enviar el formulario no se queden los errores anteriores
    limpiarError(campoError, errorElemento) {
        campoError.style.border = '1px solid #ced4da'; 
        errorElemento.textContent = '';
    }

    // Método que maneja el envío del formulario
    manejarEnvio(envio) {
        envio.preventDefault(); // Detiene el envío por defecto del formulario

        if (this.validarFormulario()) {
            //si esta bien que haga el submit, es decir, enviarlo
            this.formRegistro.submit(); 
        } else {
            console.log("Formulario inválido");
        }
    }

    // Este método valida el formulario de Avatares
    validarFormulario() {
        let formularioValido = true;
        // Limpiar todos los errores al inicio de la validación
        this.limpiarError(this.nombreAvatar, this.errorNombre); 
        this.limpiarError(this.imagenAvatar, this.errorImagen);

        //Nombre podrá tener entre 2 y 50 letras
        if (this.nombreAvatar.value.trim().length < 2 || this.nombreAvatar.value.trim().length > 20) {     //. trim ELIMINA ESPACIOS EN BLANCO AL INICIO Y FINAL
            this.mostrarError(
                this.nombreAvatar,
                this.errorNombre,
                'El nombre del avatar debe tener entre 2 y 20 caracteres.'
            );
            formularioValido = false;
        }

        //imagenes (png, jpg, jpeg)
        //Verificar si se seleccionó una imagen (obligatorio)
        if (this.imagenAvatar.files.length === 0) {
            this.mostrarError(
                this.imagenAvatar,
                this.errorImagen,
                'Debes seleccionar una imagen para el avatar.'
            );
            formularioValido = false;
        } else {
            // Si hay un archivo, comprobamos el formato
            const extensionesPermitidas = ['png', 'jpg', 'jpeg'];
            // Acceder al único archivo seleccionado. imagenes funcionan por array, al ser solo una imagen pues es el indice 0
            const imagen = this.imagenAvatar.files[0];
            
            // Cogemos la extensión del archivo
            const nombreImagen = imagen.name; //nos da el nombre del archivo con su exytension
            const extension = nombreImagen.substring(nombreImagen.lastIndexOf('.') + 1).toLowerCase(); //Nos coge extensión a partir del punto

            // Comprobamos la extensión
            if (!extensionesPermitidas.includes(extension)) {
                this.mostrarError(
                    this.imagenAvatar,
                    this.errorImagen,
                    'Solo se permiten archivos .png, .jpg o .jpeg.'
                );
                formularioValido = false;
            } 
            /* Si llega aquí sin entrar en el if, la imagen es válida y no se hace nada 
            (formularioValido se mantiene como esté (true o false, dependiendo de las comprobaciones anteriores))*/
        }

        return formularioValido;
    }
}