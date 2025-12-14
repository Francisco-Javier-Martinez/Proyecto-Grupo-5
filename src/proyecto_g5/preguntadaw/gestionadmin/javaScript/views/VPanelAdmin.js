export class VPanelAdmin {
    constructor() {
        this.alerta = document.getElementById('alert');
        this.botonesEditar = document.querySelectorAll(".jugar.editar");
        this.iniciar();
    }

    iniciar() {
        this.botonesEditar.forEach(boton => {
            boton.addEventListener("click", this.handleEditClick.bind(this));
        });
    }

    handleEditClick(e) {
        e.preventDefault();
        const boton = e.currentTarget;
        const url = boton.getAttribute("href");
        
        if (!url) return;
        if (!url.includes("idJuego=")) return;
        
        const idJuego = url.split("idJuego=")[1];
        
        if (idJuego) {
            this.crearModal(idJuego);
        }
    }

    crearModal(idJuego) {
        const modal = document.createElement("div");
        modal.classList.add("modal-bg");

        modal.innerHTML = `
            <div class="modal">
                <h2>Editar Juego</h2>
                <form id="form-editar-juego" method="POST" action="index.php?controller=Juego&action=editarJuego">
                    <input type="hidden" name="idJuego" value="${idJuego}">
                    <label>Título</label>
                    <input type="text" name="titulo" required>
                    <label>Estado</label>
                    <select name="publico">
                        <option value="1">Público</option>
                        <option value="0">Privado</option>
                    </select>
                    <label>Habilitado</label>
                    <select name="habilitado">
                        <option value="1">Habilitado</option>
                        <option value="0">Deshabilitado</option>
                    </select>
                    <div class="modal-btns">
                        <button type="submit" class="guardar">Guardar</button>
                        <button type="button" class="cerrar">Cancelar</button>
                    </div>
                </form>
            </div>
        `;

        document.body.appendChild(modal);

        // Agregar evento al formulario para mostrar alerta después de enviar
        const form = modal.querySelector("#form-editar-juego");
        form.addEventListener("submit", (e) => {
            // La alerta se mostrará cuando se recargue la página con la respuesta
        });

        modal.querySelector(".cerrar").addEventListener("click", () => {
            modal.remove();
        });

        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.remove();
        });
    }
}