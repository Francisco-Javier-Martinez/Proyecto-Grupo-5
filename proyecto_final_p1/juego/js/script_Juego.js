
const caja_respuestas = document.querySelectorAll(".respuestas");
const colores = ["#f54949ff", "#339f98ff", "#d7ae4eff", "#069c74ff"];

const respuestas = [
    [1,"Futbol",0],
    [2,"Futbol Americano",0],
    [3,"Baseball",0],
    [4,"Tenis",1]
];

respuestas.forEach((respuesta, index) => {
    // Crear el elemento button
    let boton = document.createElement("button");
    
    // Agregar clases
    boton.className = "respuesta";
    
    // Agregar atributos
    boton.value = respuesta[2];  // 0 o 1
    boton.name = respuesta[0];   // ID
    boton.textContent = respuesta[1]; // Texto
    
    // Colores 
    boton.style.backgroundColor = colores[index];
    boton.style.fontSize = "1.2rem";

    // Agregar a cada caja de respuestas
    caja_respuestas.forEach(caja => {
        // Clonar el botón 
        let botonClonado = boton.cloneNode(true);
        caja.appendChild(botonClonado);
    });
});

const botonesRespuesta = document.querySelectorAll(".respuesta");

botonesRespuesta.forEach(element => {
    element.addEventListener("click", function(evento) {
        // Recoger el value del boton
        const valor = this.value; 
        const esCorrecta = valor === "1";
        correcto = esCorrecta;
        //Creamos el objeto temporal en el localstorage
        localStorage.setItem('respuestaCorrecta', esCorrecta);
        localStorage.setItem('respuestaTexto', this.textContent);

        // Mostrar si es correcta o no
        if (esCorrecta) {
            this.style.backgroundColor = "green";
            this.style.color = "white";
            
        } else {
            this.style.backgroundColor = "red";
            this.style.color = "white";
            

            const botonCorrecto = document.querySelector('.respuesta[value="1"]');
            if (botonCorrecto) {
                botonCorrecto.style.backgroundColor = "green";
                botonCorrecto.style.color = "white";
                
            }
        }
        
        // Desahabilito todos los botonos
        botonesRespuesta.forEach(boton => {
            boton.disabled = true;
            boton.style.opacity = "0.7";
        });
        
        // Pasa a la siguiente pregunta
        setTimeout(() => {
            window.location.href = "feeckback.html";    
        }, 1000); // 1s
    });
});


