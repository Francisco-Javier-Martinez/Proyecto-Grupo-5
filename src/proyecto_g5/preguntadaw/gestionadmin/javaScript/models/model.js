// javaScript/models/model.js
export const Modelo = {
    validarCorreo(correo) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo);
    },
    validarClave(clave) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{9,15}$/.test(clave);
    },
    clavesCoinciden(c1, c2) {
        return c1 === c2;
    },
    validarCodigo(codigo) {
        return /^[0-9]{1,5}$/.test(codigo);
    },
    validarNombreTema(nombre) {
        return nombre.length >= 2;
    },
    validarDescripcionTema(descripcion) {
        return descripcion.length >= 10;
    }
};
