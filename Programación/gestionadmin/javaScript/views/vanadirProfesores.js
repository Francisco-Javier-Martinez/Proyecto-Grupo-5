export class VanadirProfesores {
    constructor() {
        // Callbacks para el controlador
        this.onCrearProfesor = null;
        this.onActualizarProfesor = null;
        this.onEliminarProfesor = null;
        this.onCargarProfesores = null;
        this.onValidarEmail = null;

        // Recoger elementos del DOM
        this.inputUserName = document.getElementById('userName');
        this.inputEmail = document.getElementById('email');
        this.inputPassword = document.getElementById('password');
        this.inputPasswordConfirm = document.getElementById('password-confirm');
        
        // Spans de error
        this.errorUserName = document.getElementById('error-userName');
        this.errorEmail = document.getElementById('error-email');
        this.errorPassword = document.getElementById('error-password');
        this.errorPasswordConfirm = document.getElementById('error-password-confirm');

        // Formulario
        this.formCrearUsuario = document.getElementById('crearUsuario');
        this.contenedorProfesores = document.getElementById('listaProfesores') || document.querySelector('.admin-list');

        // Eventos
        if (this.formCrearUsuario) {
            this.formCrearUsuario.addEventListener('submit', (e) => this.manejarEnvio(e));
        }

        // Validación de email en tiempo real
        if (this.inputEmail) {
            this.inputEmail.addEventListener('blur', (e) => this.validarEmailEnTiempoReal(e));
        }
    }
    
    /**
     * Mostrar error visualmente
     */
    mostrarError(inputElement, errorElement, mensaje) {
        if (inputElement && errorElement) {
            inputElement.style.border = '2px solid red';
            errorElement.style.color = 'red';
            errorElement.style.paddingTop = '15px';
            errorElement.textContent = mensaje;
        }
    }

    /**
     * Limpiar errores visuales
     */
    limpiarError(inputElement, errorElement) {
        if (inputElement && errorElement) {
            inputElement.style.border = '1px solid #ced4da';
            errorElement.textContent = '';
        }
    }

    /**
     * Limpiar todos los errores
     */
    limpiarTodosLosErrores() {
        this.limpiarError(this.inputUserName, this.errorUserName);
        this.limpiarError(this.inputEmail, this.errorEmail);
        this.limpiarError(this.inputPassword, this.errorPassword);
        this.limpiarError(this.inputPasswordConfirm, this.errorPasswordConfirm);
    }

    /**
     * Validar email en tiempo real
     */
    async validarEmailEnTiempoReal(e) {
        const email = e.target.value.trim();
        
        if (email === '') {
            this.limpiarError(this.inputEmail, this.errorEmail);
            return;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            this.mostrarError(this.inputEmail, this.errorEmail, 'El correo electrónico no es válido.');
            return;
        }

        // Validar disponibilidad en el servidor si existe el callback
        if (this.onValidarEmail) {
            const disponible = await this.onValidarEmail(email);
            if (!disponible) {
                this.mostrarError(this.inputEmail, this.errorEmail, 'Este email ya está registrado.');
            } else {
                this.limpiarError(this.inputEmail, this.errorEmail);
            }
        } else {
            this.limpiarError(this.inputEmail, this.errorEmail);
        }
    }

    /**
     * Manejar el envío del formulario
     */
    manejarEnvio(e) {
        e.preventDefault();

        if (this.validarFormulario()) {
            const datos = {
                userName: this.inputUserName.value.trim(),
                email: this.inputEmail.value.trim(),
                password: this.inputPassword.value
            };

            if (this.onCrearProfesor) {
                this.onCrearProfesor(datos);
            }
        } else {
            console.log("Formulario inválido");
        }
    }

    /**
     * Validar el formulario
     */
    validarFormulario() {
        let formularioValido = true;
        
        this.limpiarTodosLosErrores();

        // Validar usuario (2-50 caracteres)
        if (this.inputUserName.value.trim().length < 2 || this.inputUserName.value.trim().length > 50) {
            this.mostrarError(
                this.inputUserName,
                this.errorUserName,
                'El nombre de usuario debe tener entre 2 y 50 caracteres.'
            );
            formularioValido = false;
        }

        // Validar email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(this.inputEmail.value.trim())) {
            this.mostrarError(
                this.inputEmail,
                this.errorEmail,
                'El correo electrónico no es válido.'
            );
            formularioValido = false;
        }

        // Validar contraseña (8-15 caracteres, mayús, minús, número, especial)
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+*-])[A-Za-z\d@$!%*?&+*-]{8,15}$/;
        if (!passwordPattern.test(this.inputPassword.value)) {
            this.mostrarError(
                this.inputPassword,
                this.errorPassword,
                'La contraseña debe tener entre 8 y 15 caracteres, incluyendo al menos una mayúscula, una minúscula, un número y un carácter especial.'
            );
            formularioValido = false;
        }

        // Validar confirmación de contraseña
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

    /**
     * Mostrar lista de profesores
     */
    mostrarProfesores(profesores) {
        if (!this.contenedorProfesores) return;

        let html = '';
        
        if (profesores.length === 0) {
            html = '<p>No hay profesores registrados.</p>';
        } else {
            profesores.forEach(profesor => {
                html += `
                    <div class="admin-box">
                        <div class="admin-info">
                            <h3>${profesor.userName}</h3>
                            <p class="admin-details">
                                <span class="material-icons">email</span>
                                <span>${profesor.email}</span>
                            </p>
                            <p class="admin-details">
                                <span class="material-icons">calendar_today</span>
                                <span>${new Date(profesor.fecha_creacion).toLocaleDateString('es-ES')}</span>
                            </p>
                            <div style="margin-top: 10px; display: flex; gap: 10px;">
                                <button class="btn-editar" data-id="${profesor.id}">Editar</button>
                                <button class="btn-eliminar" data-id="${profesor.id}">Eliminar</button>
                            </div>
                        </div>
                    </div>
                `;
            });

            // Agregar event listeners a los botones
            setTimeout(() => {
                document.querySelectorAll('.btn-editar').forEach(btn => {
                    btn.addEventListener('click', (e) => this.editarProfesor(e.target.dataset.id));
                });

                document.querySelectorAll('.btn-eliminar').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        if (this.onEliminarProfesor) {
                            this.onEliminarProfesor(e.target.dataset.id);
                        }
                    });
                });
            }, 0);
        }

        this.contenedorProfesores.innerHTML = html;
    }

    /**
     * Editar un profesor
     */
    editarProfesor(id) {
        console.log('Editar profesor:', id);
        // Aquí puedes implementar la lógica de edición
        // Por ejemplo, cargar los datos en el formulario
    }

    /**
     * Limpiar el formulario
     */
    limpiarFormulario() {
        if (this.formCrearUsuario) {
            this.formCrearUsuario.reset();
            this.limpiarTodosLosErrores();
        }
    }

    /**
     * Mostrar mensaje de éxito
     */
    mostrarExito(mensaje) {
        alert(mensaje); // Puedes mejorar esto con un toast o notificación más elegante
        console.log('Éxito:', mensaje);
    }

    /**
     * Mostrar mensaje de error
     */
    mostrarErrorGlobal(mensaje) {
        alert('Error: ' + mensaje);
        console.error('Error:', mensaje);
    }
}