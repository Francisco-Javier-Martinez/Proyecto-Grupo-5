export class ModificarPreguntasRespuestas {
    constructor(controlador) {
        this.controlador = controlador;
        console.log("Vista: Constructor ejecutado...");

        this.datos;

        // Elementos dell DOM
        this.tituloPregunta = document.getElementById('titulo');
        this.puntos = document.getElementById('puntuacion');
        this.imagen = document.getElementById("imagen"); // Input file
        this.imgActual = document.getElementById("imgenPregunta"); // La etiqueta <img> para previsualizar
        this.explicacionPregunta = document.getElementById('explicacionPregunta');
        
        // Inputs ocultos (IMPORTANTE para enviar el update luego)
        this.idTemaInput = document.querySelector('input[name="idTema"]');
        this.nPreguntaInput = document.querySelector('input[name="nPregunta"]');

        this.respuesta1 = document.getElementById("respuesta1");
        this.respuesta2 = document.getElementById("respuesta2");
        this.respuesta3 = document.getElementById("respuesta3");
        this.respuesta4 = document.getElementById("respuesta4");
        
        this.formulario = document.querySelector('form');

        // labels/p de errores
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
            console.warn('Formulario no encontrado.');

        }

        this.actualizarRadios();
        this.controlador.obtenerPreguntasRespuestas();

    }

    visualizarDatos(datos) {
        console.log("Vista recibiendo datos:", datos);

        // Rellenar campos ocultos
        if(this.idTemaInput) this.idTemaInput.value = datos.idTema;
        if(this.nPreguntaInput) this.nPreguntaInput.value = datos.nPregunta;

        // Imagen (Manejo de null o ruta)
        if (datos.imagenPregunta) {
            this.imgActual.src = datos.imagenPregunta;
            this.imgActual.style.display = 'block'; // Asegurar que se vea
        }

        // Datos de la pregunta
        const pregunta = datos.pregunta;
        if (pregunta) {
            this.tituloPregunta.value = pregunta.titulo || '';
            this.puntos.value = pregunta.puntuacion || '';
            this.explicacionPregunta.value = pregunta.explicacion || '';
        }

        // 4. Respuestas
        const respuestas = datos.respuestas;
        const respuestasInputs = [this.respuesta1, this.respuesta2, this.respuesta3, this.respuesta4];
        // Array de letras para mapear con los values de los radio buttons (a, b, c, d)
        const letras = ['a', 'b', 'c', 'd']; 

        if (respuestas && respuestas.length > 0) {
            respuestas.forEach((respuesta, index) => {
                // Rellenar texto de los inputs
                if (respuestasInputs[index]) {
                    // Nota: PHP suele devolver la columna 'respuesta' (verificar console.log)
                    respuestasInputs[index].value = respuesta.respuesta || respuesta.texto || ''; 
                    
                    // Actualizar el label visual al lado del radio button
                    const label = document.getElementById(`label${index + 1}`);
                    if(label) label.textContent = respuestasInputs[index].value;
                }

                // Marcar el radio button correcto
                // Envía 1 si es correcta
                if (respuesta.esCorrecta == 1 || respuesta.esCorrecta === true) {
                    const letraCorrecta = letras[index]; // a, b, c o d
                    const radio = document.querySelector(`input[name="opcion"][value="${letraCorrecta}"]`);
                    if (radio) {
                        radio.checked = true;
                    }
                }
            });
        }
    }

    mostrarError(campo, error, mensaje) {
        campo.style.border = '2px solid red';
        error.style.color = 'red';
        error.style.paddingTop = '15px';
        error.textContent = mensaje;
    }

    limpiarError(campo, error) {
        campo.style.border = '1px solid #ced4da';
        error.textContent = '';
    }

    manejarEnvio(e) {
        if (!this.validarFormulario()) {
            e.preventDefault();
             alert("Formulario inválido");
        }
        // Si es válido, deja que el formulario haga submit normal al PHP
    }

    actualizarRadios() {
        // Tu lógica existente
        const inputs = [this.respuesta1, this.respuesta2, this.respuesta3, this.respuesta4];
        const labels = [
            document.getElementById('label1'),
            document.getElementById('label2'),
            document.getElementById('label3'),
            document.getElementById('label4')
        ];

        inputs.forEach((input, index) => {
            if(input && labels[index]){
                input.addEventListener('input', () => {
                    labels[index].textContent = input.value;
                });
            }
        });
    }

    validarFormulario() {
        let valido = true;

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


        if (this.imagen.files.length > 0) {
            const archivo = this.imagen.files[0];
            const nombreArchivo = archivo.name;
            const extension = nombreArchivo.substring(nombreArchivo.lastIndexOf('.') + 1).toLowerCase();
            const extensionesPermitidas = ['png', 'jpg', 'jpeg'];

            if (!extensionesPermitidas.includes(extension)) {
                this.mostrarError(
                    this.imagen,
                    this.errorImagen,
                    'Solo se permiten archivos .png, .jpg o .jpeg.'
                );
                valido = false;
            }
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