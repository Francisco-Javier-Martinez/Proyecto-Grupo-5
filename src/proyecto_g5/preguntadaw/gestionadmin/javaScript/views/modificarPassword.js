export class ModificarPassword {

    constructor() {
        //recoger elementos del DOM
        this.password = document.getElementById('password');

        this.errorPassword = document.getElementById('error-password');

        this.formModificar = document.getElementById('formulario');

        //si el formulario se envia, llamo a manejarEnvio
        this.formModificar.addEventListener('submit', (e) => this.manejarEnvio(e));
    }

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
            this.formModificar.submit(); 
        } else {
            console.log("Formulario inválido");
        }
    }
    
    validarFormulario() {
        let formularioValido = true;
        // Limpiar todos los errores al inicio de la validación
        this.limpiarError(this.password, this.errorPassword);

        // ^ → inicio del texto                         NO QUITAR ESTOS COMENTARIOS!!!
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