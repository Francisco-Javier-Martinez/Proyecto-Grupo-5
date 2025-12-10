export const Modelo = {

    // Array simulando temas ya existentes
    nombresTemas: ["Historia", "Ciencia", "Arte"],

    codigoCorrecto: "12345",

    validarCodigo(codigoIntroducido) {
        return /^[0-9]{1,5}$/.test(codigoIntroducido) && codigoIntroducido === this.codigoCorrecto;
    },

    validarCorreo(correoIntroducido) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correoIntroducido);
    },

    validarClave(claveIntroducida) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{9,15}$/.test(claveIntroducida);
    },

    clavesCoinciden(claveUno, claveDos) {
        return claveUno === claveDos;
    },

    // -------- NUEVAS VALIDACIONES --------
    validarNombreTema(nombre) {
        return nombre.length >= 2;
    },

    nombreTemaDisponible(nombre) {
        return !this.nombresTemas.includes(nombre.trim());
    },

    validarDescripcionTema(descripcion) {
        return descripcion.length >= 10;
    },

    agregarTema(nombre) {
        this.nombresTemas.push(nombre.trim());
    },

    eliminarTema(idTema) {
        console.log("Eliminar tema con id:", idTema);
    }
};
