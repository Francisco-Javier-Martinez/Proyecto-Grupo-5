export class VmodificarProfesores {
    constructor() {
        console.log("Iniciando Vista Modificar Profesores");
        
        // Recoger elementos del formulario (solo los que quedaron)
        this.inputUserName = document.getElementById('userName');
        this.inputEmail = document.getElementById('email');
        
        // Errores
        this.errorUserName = document.getElementById('error-userName');
        this.errorEmail = document.getElementById('error-email');

        // Elementos de acción
        this.formModificarUsuario = document.getElementById('modificarUsuario');
        this.borrarAccesoBtn = document.getElementById('borrarAccesoBtn');

        
        this.formModificarUsuario.addEventListener('submit', (e) => this.manejarEnvio(e));
        
        
        // Manejar el clic en el botón de borrar acceso
        if (this.borrarAccesoBtn) {
            this.borrarAccesoBtn.addEventListener('click', (e) => this.manejarBorrarAcceso(e));
        }
    }
    
    // Método auxiliar para mostrar el error visualmente
    mostrarError(inputElement, errorElement, mensaje) {
        // Verifica si el elemento existe antes de manipularlo
        if (inputElement) inputElement.style.border = '2px solid red';
        if (errorElement) {
            errorElement.style.color = 'red';
            errorElement.style.paddingTop = '5px';
            errorElement.textContent = mensaje;
        }
    }

    // Método para limpiar los errores visuales
    limpiarError(inputElement, errorElement) {
        if (inputElement) inputElement.style.border = '1px solid #ced4da'; 
        if (errorElement) errorElement.textContent = '';
    }

    // Método que maneja el envío del formulario de modificación
    manejarEnvio(e) {
        e.preventDefault(); // Detiene el envío
        if (this.validarFormulario()) {
            this.formModificarUsuario.submit();
        } else {
            console.log("Formulario de Modificación inválido");
        }
    }

    // Método para manejar el borrado de acceso (si es necesario)
    manejarBorrarAcceso(e) {
        e.preventDefault();
        if (confirm('¿Está seguro de que desea borrar el acceso de este administrador?')) {
            // Aquí podrías redirigir o hacer alguna acción específica
            console.log("Borrar acceso confirmado");
        }
    }

    // Este método valida el formulario, adaptado para la modificación
    validarFormulario() {
        let formularioValido = true;
        
        // Limpiar todos los errores al inicio de la validación
        this.limpiarError(this.inputUserName, this.errorUserName);
        this.limpiarError(this.inputEmail, this.errorEmail);

        // 1. Validar Nombre de Usuario
        const userNameValue = this.inputUserName.value.trim();
        if (userNameValue.length < 2 || userNameValue.length > 50) {
            this.mostrarError(
                this.inputUserName,
                this.errorUserName,
                'El nombre de usuario debe tener entre 2 y 50 caracteres.'
            );
            formularioValido = false;
        }

        // 2. Validar Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const emailValue = this.inputEmail.value.trim();
        
        if (!emailPattern.test(emailValue)) {
            this.mostrarError(
                this.inputEmail, 
                this.errorEmail, 
                'El correo electrónico no es válido.'
            );
            formularioValido = false;
        }

        // ¡IMPORTANTE: Retornar el valor!
        return formularioValido;
    }
}
