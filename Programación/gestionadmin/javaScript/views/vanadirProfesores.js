export class VanadirProfesores {
    constructor() {
        //recoger elementos del DOM
        this.inputUserName = document.getElementById('userName');
        this.inputEmail = document.getElementById('email');
        this.inputPassword = document.getElementById('password');
        this.inputPasswordConfirm = document.getElementById('password-confirm');
        //essto son los span de error que los pongo debajo de cada input
        this.errorUserName = document.getElementById('error-userName');
        this.errorEmail = document.getElementById('error-email');
        this.errorPassword = document.getElementById('error-password');
        this.errorPasswordConfirm = document.getElementById('error-password-confirm');

        //me cogo el formulario
        this.formCrearUsuario = document.getElementById('crearUsuario');

        //si el formulario se envia, llamo a manejarEnvio
        this.formCrearUsuario.addEventListener('submit', (e) => this.manejarEnvio(e));
    }

    // Método auxiliar para mostrar el error visualmente
    mostrarError(inputElement, errorElement, mensaje) {
        inputElement.style.border = '2px solid red';
        errorElement.style.color = 'red';
        errorElement.style.paddingTop = '15px';
        errorElement.textContent = mensaje;
    }

    //Este metodo sirve para limpiar los errores visuales para que si vuelves a enviar el formulario no se queden los errores anteriores
    limpiarError(inputElement, errorElement) {
        inputElement.style.border = '1px solid #ced4da'; 
        errorElement.textContent = '';
    }

    // Método que maneja el envío del formulario
    manejarEnvio(e) {
        e.preventDefault(); // Detiene el envío por defecto del formulario

        if (this.validarFormulario()) {
            //si esta bien que haga el submit
            this.formCrearUsuario.submit();
        } else {
            console.log("Formulario inválido");
        }
    }

    // Este método valida el formulario de Profesores
    validarFormulario() {
        let formularioValido = true;
        // Limpiar todos los errores al inicio de la validación
        this.limpiarError(this.inputUserName, this.errorUserName);
        this.limpiarError(this.inputEmail, this.errorEmail);
        this.limpiarError(this.inputPassword, this.errorPassword);
        this.limpiarError(this.inputPasswordConfirm, this.errorPasswordConfirm);

        //Usuario este podra tener max 50 y min 2
        if (this.inputUserName.value.trim().length < 2 || this.inputUserName.value.trim().length > 50) {
            this.mostrarError(
                this.inputUserName,
                this.errorUserName,
                'El nombre de usuario debe tener entre 2 y 50 caracteres.'
            );
            formularioValido = false;
        }
        //Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(this.inputEmail.value.trim())) {
            this.mostrarError(
                this.inputEmail, 
                this.errorEmail, 
                'El correo electrónico no es válido.'
            );
            formularioValido = false;
        }

        //Contraseña min 8 max 15 y debe contener al menos una mayuscula, una minuscula, un numero y un caracter especial
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;
        if (!passwordPattern.test(this.inputPassword.value)) {
            this.mostrarError(
                this.inputPassword, 
                this.errorPassword,
                'La contraseña debe tener entre 8 y 15 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y un carácter especial.'
            );
            formularioValido = false;
        }

        //validar que las contraseñas coincidan
        if (this.inputPassword.value !== this.inputPasswordConfirm.value) {
            this.mostrarError(
                this.inputPasswordConfirm, 
                this.errorPasswordConfirm, 
                'Las contraseñas no coinciden.'
            );
            formularioValido = false;
        }
        
        return formularioValido;
    }
}