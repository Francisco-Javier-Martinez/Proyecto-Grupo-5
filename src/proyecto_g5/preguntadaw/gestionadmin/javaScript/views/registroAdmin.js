export class RegistroAdmin {

    constructor() {
        //recoger elementos del DOM
        this.nombre = document.getElementById('nombre');
        this.email = document.getElementById('email');
        this.password = document.getElementById('password');

        //essto son los span de error que los pongo debajo de cada input
        this.errorNombre = document.getElementById('error-userName');
        this.errorEmail = document.getElementById('error-email');
        this.errorPassword = document.getElementById('error-password');
        
        //me cojo el formulario
        this.formRegistro = document.getElementById('formRegistro');

        //si el formulario se envia, llamo a manejarEnvio
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

    // Este método valida el formulario de Profesores
    validarFormulario() {
        let formularioValido = true;
        // Limpiar todos los errores al inicio de la validación
        this.limpiarError(this.nombre, this.errorNombre); 
        this.limpiarError(this.email, this.errorEmail);
        this.limpiarError(this.password, this.errorPassword);

        //Nombre podrá tener entre 2 y 50 letras
        if (this.nombre.value.trim().length < 2 || this.nombre.value.trim().length > 50) {     //. trim ELIMINA ESPACIOS EN BLANCO AL INICIO Y FINAL
            this.mostrarError(
                this.nombre,
                this.errorNombre,
                'El nombre de usuario debe tener entre 2 y 50 caracteres.'
            );
            formularioValido = false;
        }

        //Email

        // -- Expresión para validar un email -- //

        // ^ → inicio del texto
        // [^\s@]+ → uno o más caracteres que NO sean espacios ni @ (nombre del email)
        // @ → debe haber un solo @
        // [^\s@]+ → uno o más caracteres que NO sean espacios ni @ (dominio)
        // \. → un punto literal
        // [^\s@]+ → uno o más caracteres que NO sean espacios ni @ (extensión, ej: .com)
        // $ → final del texto

        const emailExpresion = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailExpresion.test(this.email.value.trim())) {
            this.mostrarError(
                this.email, 
                this.errorEmail, 
                'Introduce un correo válido'
            );
            formularioValido = false;
        }

        //Contraseña min 8 max 15 y debe contener al menos una mayuscula, una minuscula, un numero y un caracter especial
        // Expresión regular para validar contraseñas SEGURAS!!

        // ^ → inicio del texto
        // (?=.*[a-z]) → al menos una letra minúscula
        // (?=.*[A-Z]) → al menos una letra mayúscula
        // (?=.*\d) → al menos un número
        // (?=.*[@$!%*?&]) → al menos un carácter especial de @$!%*?&
        // [A-Za-z\d@$!%*?&]{8,15} → solo permite letras, números y esos símbolos, longitud 8-15
        // $ → fin del texto
        const requisitosPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;
        if (!requisitosPassword.test(this.password.value)) {
            this.mostrarError(
                this.password, 
                this.errorPassword,
                'La contraseña debe tener entre 8 y 15 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y un carácter especial.'
            );
            formularioValido = false;
        }

        return formularioValido;
    }
}