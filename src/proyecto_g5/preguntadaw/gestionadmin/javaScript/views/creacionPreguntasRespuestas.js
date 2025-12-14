export class CreacionPreguntasRespuestas{
    constructor(){
        console.log("Vista: Constructor ejecutado...");
        
        this.tituloPregunta = document.getElementById('titulo'); 
        this.puntos = document.getElementById('puntuacion');
        this.imagen = document.getElementById("imagen");
        this.explicacionPregunta = document.getElementById('explicacionPregunta');
        this.respuesta1= document.getElementById("respuesta1");
        this.respuesta2= document.getElementById("respuesta2");
        this.respuesta3= document.getElementById("respuesta3");
        this.respuesta4= document.getElementById("respuesta4");
        this.formulario = document.querySelector('form'); ///


         //essto son los elementos (span/p) de error que ponemos debajo de cada input
        this.errorTitulo = document.getElementById('titulo-error');
        this.errorPuntos = document.getElementById('puntos-error');
        this.errorImagen = document.getElementById('imagen-error');
        this.explicacionError = document.getElementById('explicacion-error');

        this.errorR1 = document.getElementById('respuesta1-error');
        this.errorR2 = document.getElementById('respuesta2-error');
        this.errorR3 = document.getElementById('respuesta3-error');
        this.errorR4 = document.getElementById('respuesta4-error');
    
        if (this.formulario) {
            this.formulario.addEventListener('submit', this.manejarEnvio.bind(this));
        } else {
            console.warn('Formulario no encontrado: revisar selector de form.');
        }

    }

      // Mostrar error
    mostrarError(campo, error, mensaje) {
        campo.style.border = '2px solid red';
        error.style.color = 'red';
        error.style.paddingTop = '15px';
        error.textContent = mensaje;
    }

    // Limpiar error
    limpiarError(campo, error) {
        campo.style.border = '1px solid #ced4da';
        error.textContent = '';
    }

    manejarEnvio(e) {
        e.preventDefault();
        if (this.validarFormulario()) {
            this.formulario.submit();
        } else {
            alert("Formulario inválido");
        }
    }

    //actualizarRadios con lo q se va metiendo en  las respuestas
    actualizarRadios(){
        const respuesta1 = document.getElementById('respuesta1');
        const respuesta2 = document.getElementById('respuesta2');
        const respuesta3 = document.getElementById('respuesta3');
        const respuesta4 = document.getElementById('respuesta4');

        const label1 = document.getElementById('label1');
        const label2 = document.getElementById('label2');
        const label3 = document.getElementById('label3');
        const label4 = document.getElementById('label4');

        respuesta1.addEventListener('input', () => {
            label1.textContent = respuesta1.value;
        });
        respuesta2.addEventListener('input', () => {
            label2.textContent = respuesta2.value;
        });
        respuesta3.addEventListener('input', () => {
            label3.textContent = respuesta3.value;
        });
        respuesta4.addEventListener('input', () => {
            label4.textContent = respuesta4.value;
        });
    }


    // VALIDACIÓN
    validarFormulario() {
        let valido = true;

        // Limpiar errores
        this.limpiarError(this.tituloPregunta, this.errorTitulo);
        this.limpiarError(this.puntos, this.errorPuntos);
        this.limpiarError(this.imagen, this.errorImagen);
        this.limpiarError(this.explicacionPregunta, this.explicacionError);

        this.limpiarError(this.respuesta1, this.errorR1);
        this.limpiarError(this.respuesta2, this.errorR2);
        this.limpiarError(this.respuesta3, this.errorR3);
        this.limpiarError(this.respuesta4, this.errorR4);

        // -------------Validación del Título ---------------------

        if (this.tituloPregunta.value.trim().length < 5) {
            this.mostrarError(
                this.tituloPregunta,
                this.errorTitulo,
                'El título debe tener al menos 5 caracteres.'
            );
            valido = false;
        }


        // Validación de Puntos (1-100)
        const valorPuntos = parseInt(this.puntos.value);
        if (valorPuntos < 200) {
            this.mostrarError(
                this.puntos,
                this.errorPuntos,
                'Los puntos deben ser mayores a 200.'
            );
            valido = false;
        }



        // ------------- Validación de Imagen--------------

        
        const extensionesPermitidas = ['png', 'jpg', 'jpeg'];

        if (this.imagen.files.length === 0) {
            this.mostrarError(
                this.imagen,
                this.errorImagen,
                'Debes seleccionar una imagen.'
            );
            valido = false; // El formulario NO es válido.

        } else {
            // Solo si hay archivo - validar la extensión.
            const archivo = this.imagen.files[0]; //la primera (y única) imagen
            const nombreArchivo = archivo.name;
            const extension = nombreArchivo.substring(nombreArchivo.lastIndexOf('.') + 1).toLowerCase(); //te saca la extensión desde el punto

            // Validar extensión
            if (!extensionesPermitidas.includes(extension)) {
                this.mostrarError(
                    this.imagen,
                    this.errorImagen,
                    'Solo se permiten archivos .png, .jpg o .jpeg.'
                );
                valido = false; // El formulario NO es válido.
            }
            // Si la extensión es válida, no se hace nada y 'valido' se mantiene.
        }

        // Acceder al archivo seleccionado
        const archivo = this.imagen.files[0];

        // Obtener el nombre del archivo
        const nombreArchivo = archivo.name;

        // Obtener la extensión después del último punto
        const extension = nombreArchivo.substring(nombreArchivo.lastIndexOf('.') + 1).toLowerCase();

        // Validar extensión
        if (!extensionesPermitidas.includes(extension)) {
            this.mostrarError(
                this.imagen,
                this.errorImagen,
                'Solo se permiten archivos .png, .jpg o .jpeg.'
            );
            valido = false;
        }

        //-------------- Validación Explicación-------------------

        if (this.explicacionPregunta.value.trim().length < 10) {
            this.mostrarError(
                this.explicacionPregunta,
                this.explicacionError,
                'La explicación debe tener al menos 10 caracteres.'
            );
            valido = false;
        }



        //   ---------------Validación de Respuestas------------------

        if (this.respuesta1.value.trim() === "") {
            this.mostrarError(this.respuesta1, this.errorR1, 'Campo obligatorio.');
            valido = false;
        }
        if (this.respuesta2.value.trim() === "") {
            this.mostrarError(this.respuesta2, this.errorR2, 'Campo obligatorio.');
            valido = false;
        }
        if (this.respuesta3.value.trim() === "") {
            this.mostrarError(this.respuesta3, this.errorR3, 'Campo obligatorio.');
            valido = false;
        }
        if (this.respuesta4.value.trim() === "") {
            this.mostrarError(this.respuesta4, this.errorR4, 'Campo obligatorio.');
            valido = false;
        }

        return valido;
    }
}

