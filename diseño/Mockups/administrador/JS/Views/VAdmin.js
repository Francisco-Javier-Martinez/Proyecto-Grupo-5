

export class VAdmin{
    constructor(){
        console.log("Vista: Constructor ejecutado...");
        // this.cuadroTemas = document.querySelector(".temas-box");
        this.cuadroTemas = document.querySelector(".splide__list");
    }

    // mostrarTemas(temas){
    //     temas.forEach(tema => {
    //         let tema_item = document.createElement("div");
    //         tema_item.className = "tema-item";
    //         tema_item.innerHTML = `${tema.nombre}`;
    //         this.cuadroTemas.appendChild(tema_item);
    //     });
    // }

    mostrarTemas(temas){
        temas.forEach(tema => {
            let tema_item = document.createElement("li");
            tema_item.className = "splide__slide tema-item";
            tema_item.textContent = tema.nombre;
            this.cuadroTemas.appendChild(tema_item);
        });
        this.cargarSlide();
    }

    mostrarError(error){
        console.error("Error: ",error);
    }
    
    cargarSlide(){
        var splide = new Splide( '.splide', {
            type   : 'loop',
            drag   : 'free',
            snap   : true,
            perPage: 3,
        } );

        splide.mount();
    }
}

