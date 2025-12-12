export class VmodificarProfesores {
    constructor() {
        console.log("Iniciando Vista Modificar Profesores - CONSTRUCTOR");
        
        // ESPERAR a que el DOM esté completamente cargado
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.inicializar());
        } else {
            this.inicializar();
        }
    }
    
    inicializar() {
        console.log("Inicializando VmodificarProfesores...");
        
        // Recoger elementos del formulario
        this.inputUserName = document.getElementById('userName');
        this.inputEmail = document.getElementById('email');
        
        console.log("Inputs encontrados:", {
            userName: !!this.inputUserName,
            email: !!this.inputEmail
        });
        
        // Errores
        this.errorUserName = document.getElementById('error-userName');
        this.errorEmail = document.getElementById('error-email');
        
        console.log("Errores encontrados:", {
            errorUserName: !!this.errorUserName,
            errorEmail: !!this.errorEmail
        });

        // Elementos de acción
        this.formModificarUsuario = document.getElementById('modificarUsuario');
        console.log("Formulario encontrado:", !!this.formModificarUsuario);
        
        // Verificar que el formulario existe antes de añadir event listener
        if (this.formModificarUsuario) {
            console.log("Añadiendo event listener al formulario");
            this.formModificarUsuario.addEventListener('submit', (e) => {
                console.log("SUBMIT EVENT DETECTADO!");
                this.manejarEnvio(e);
            });
        } else {
            console.error("ERROR: No se encontró el formulario con id 'modificarUsuario'");
        }
    }

    limpiarError(inputElement, errorElement) {
        // Verificar que los elementos existan
        if (inputElement && inputElement.style) {
            inputElement.style.border = '1px solid #ced4da'; 
        }
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    manejarEnvio(e) {
        console.log("=== MANEJAR ENVIO INICIADO ===");
        console.log("Evento submit capturado");
        
        // Verificar que los elementos existan antes de validar
        if (!this.inputUserName || !this.inputEmail) {
            console.error("Error: Elementos del formulario no encontrados");
            return; // Salir sin prevenir el envío
        }
        
        // Validar formulario
        const esValido = this.validarFormulario();
        console.log("Formulario válido?", esValido);
        
        if (!esValido) {
            console.log("Preveniendo envío...");
            e.preventDefault();
        } else {
            console.log("Permitiendo envío normal...");
            // NO llamar a submit() - dejar que el navegador lo haga
        }
        
        console.log("=== MANEJAR ENVIO FINALIZADO ===");
    }

    validarFormulario() {
        console.log("=== VALIDANDO FORMULARIO ===");
        let formularioValido = true;
        
        // Verificar que los elementos existan
        if (!this.inputUserName || !this.inputEmail || 
            !this.errorUserName || !this.errorEmail) {
            console.error("Error: Elementos del formulario no disponibles");
            return false;
        }
        
        // Limpiar todos los errores
        this.limpiarError(this.inputUserName, this.errorUserName);
        this.limpiarError(this.inputEmail, this.errorEmail);

        // 1. Validar Nombre de Usuario
        const userNameValue = this.inputUserName.value.trim();
        console.log("Valor userName:", userNameValue);
        
        if (userNameValue.length < 2 || userNameValue.length > 50) {
            console.log("ERROR en userName");
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
        console.log("Valor email:", emailValue);
        
        if (!emailPattern.test(emailValue)) {
            console.log("ERROR en email");
            this.mostrarError(
                this.inputEmail, 
                this.errorEmail, 
                'El correo electrónico no es válido.'
            );
            formularioValido = false;
        }

        console.log("Formulario válido final:", formularioValido);
        return formularioValido;
    }

    mostrarAdmin(admin){
        console.log("Mostrando admin:", admin);
        if (this.inputUserName) this.inputUserName.value = admin.nombre;
        if (this.inputEmail) this.inputEmail.value = admin.email;
    }
    
    mostrarError(inputElement, errorElement, mensaje) {
        console.log("Mostrando error:", mensaje);
        
        // Verificar que los elementos existan antes de manipularlos
        if (inputElement && inputElement.style) {
            inputElement.style.border = '2px solid red';
        } else {
            console.error("inputElement no definido o no tiene propiedad style");
        }
        
        if (errorElement) {
            errorElement.style.color = 'red';
            errorElement.style.paddingTop = '5px';
            errorElement.textContent = mensaje;
        } else {
            console.error("errorElement no definido");
        }
    }
}