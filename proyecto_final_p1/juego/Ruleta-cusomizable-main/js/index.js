//Referencias a objetos
const ruleta = document.getElementById("ruleta");
let opcionesContainer;
let opciones = Array.from(document.getElementsByClassName("opcion"));
const root = document.documentElement;
const formContainer = document.getElementById("formContainer");
const modal = document.querySelector("dialog");
const totalElement = document.getElementById("porcentaje");
const botonCancelar = document.getElementById("cancelar");
const botonAceptar = document.getElementById("aceptar");
const botonAgregar = document.getElementById("agregar");
const ganadorTextoElement = document.getElementById("ganadorTexto");

/** Texto de la opción ganadora */
let ganador = "";
let ganadorId = null;
/** Para el setInterval que hace que el cartel de ganador anime los "..." */
let animacionCarga;
/** Estado actual de la ruleta true => Bloquea el mouse; */
let sorteando = false;
/** Contiene la lista de colores posibles para el gráfico */
const colores=[
	"126253","134526","C7B446","5D9B9B","8673A1","100000","4C9141","8E402A","231A24","424632","1F3438","025669","008F39","763C28"
];

/** Cambia la escala para hacer la herramienta pseudo responsive (faltaría un event listener al cambio de width para que sea bien responsive) */
let escala = screen.width < 550 ? screen.width * 0.7 : 400;
root.style.setProperty("--escala",escala+"px");

/** Contiene la suma actual de probabilidades en base 100 */
let suma = 0;



/** Instancias de conceptos que se cargan al iniciar la app */
const uno = {
	nombre: "1",
	probabilidad: 25
}
const dos = {
	nombre: "2",
	probabilidad: 25
}
const tres = {
	nombre: "3",
	probabilidad: 25
}
const cuatro = {
	nombre: "4",
	probabilidad: 25
}

let conceptos = [uno,dos,tres,cuatro];

async function init(){
	// Priorizar datos inyectados por servidor (MVC)
	if (window.ruletaTemas && Array.isArray(window.ruletaTemas) && window.ruletaTemas.length > 0) {
		console.log('Ruleta: usando temas inyectados por servidor (window.ruletaTemas)');
		const temas = window.ruletaTemas.slice(0, 4);
		const n = temas.length;
		const baseProb = Math.floor(100 / n);
		const conceptosTemp = temas.map(t => {
			// Normalizar distintas formas que puede tener el objeto tema desde PHP/BD
			const id = (t.idTema !== undefined && t.idTema !== null) ? t.idTema : ((t.id !== undefined && t.id !== null) ? t.id : (t[0] !== undefined ? t[0] : null));
			// Intentar varias propiedades posibles para el nombre
			let nombre = null;
			if (t.nombre && String(t.nombre).trim() !== '') nombre = String(t.nombre);
			else if (t.Nombre && String(t.Nombre).trim() !== '') nombre = String(t.Nombre);
			else if (t[1] !== undefined && String(t[1]).trim() !== '') nombre = String(t[1]);
			else if (t.nombre_tema && String(t.nombre_tema).trim() !== '') nombre = String(t.nombre_tema);
			else nombre = id !== null ? ('Tema ' + String(id)) : 'Tema';
			return { id: id, nombre: nombre, probabilidad: baseProb };
		});
		let sumaProb = conceptosTemp.reduce((s, c) => s + c.probabilidad, 0);
		let i = 0;
		while (sumaProb < 100) { conceptosTemp[i % conceptosTemp.length].probabilidad += 1; sumaProb++; i++; }
		conceptos = conceptosTemp;
		console.log('Conceptos (server):', conceptos);
		ajustarRuleta();
		return;
	}

	// Si no hay datos del servidor, informar y usar valores por defecto
	console.warn('No se han recibido temas desde el servidor (window.ruletaTemas). Mostrando valores por defecto.');
	if (ganadorTextoElement) ganadorTextoElement.textContent = 'No hay temas del servidor.';
	ajustarRuleta();
}


/** Pone a girar la ruleta y hace el sorteo del resultado */
function sortear(){
	sorteando = true;
	ganadorTextoElement.textContent = ".";
	document.getElementById("sortear").style.display = "none";
	animacionCarga = setInterval(()=>{
		switch( ganadorTextoElement.textContent){
			case ".":
				ganadorTextoElement.textContent = ".."
				break;
			case "..":
				ganadorTextoElement.textContent = "..."
				break;
			default:
				ganadorTextoElement.textContent = "."
				break;
		}
	} ,500)
	/** Numero del 0 al 1 que contiene al ganador del sorteo */
	const nSorteo = Math.random();
	/** Cantidad de grados que debe girar la ruleta */
	const giroRuleta = (1-nSorteo)*360 + 360*10; //10 vueltas + lo aleatorio;
	root.style.setProperty('--giroRuleta', giroRuleta + "deg");
	ruleta.classList.toggle("girar",true)
	/** Acumulador de probabilidad para calcular cuando una probabilidad fue ganadora */
	let pAcumulada = 0;
	conceptos.forEach(concepto => {
		if(nSorteo*100 > pAcumulada && nSorteo*100 <= pAcumulada+concepto.probabilidad){
			ganador = concepto.nombre;
			ganadorId = concepto.id !== undefined && concepto.id !== null ? concepto.id : concepto.nombre;
		};
		pAcumulada +=concepto.probabilidad;
	})
}

/** Desacopla lo que ocurre al terminar de girar la ruleta de la función girar */
ruleta.addEventListener("animationend", ()=>{
	ruleta.style.transform = "rotate("+getCurrentRotation(ruleta)+"deg)";
	ruleta.classList.toggle("girar",false)
	sorteando=false;
	ganadorTextoElement.textContent = ganador;
	clearInterval(animacionCarga);

		setTimeout(async () => {
				const param = ganadorId !== null ? ganadorId : ganador;
				// Rutas candidatas (de más a menos relativas). Probamos con HEAD antes de navegar
				const candidates = [
					new URL('../seleccion_Preguntas.html', window.location.href).href,
					`${window.location.origin}/pruebas/preguntadaw/juego/seleccion_Preguntas.html`,
					`${window.location.origin}/pruebas/juego/seleccion_Preguntas.html`,
					`${window.location.origin}/pruebas/preguntadaw/seleccion_Preguntas.html`
				];
				for (const baseUrl of candidates) {
					try {
						const checkUrl = baseUrl.includes('?') ? `${baseUrl}&tema=${encodeURIComponent(param)}` : `${baseUrl}?tema=${encodeURIComponent(param)}`;
						const resp = await fetch(checkUrl, { method: 'HEAD' });
						if (resp && resp.ok) {
							window.location.href = checkUrl;
							return;
						}
					} catch (e) {
						// Ignorar errores de fetch y probar siguiente candidato
					}
				}
				// Fallback: navegar a la ruta relativa original (puede mostrar 404 si no existe)
				window.location.href = `../juego/seleccion_Preguntas.html?tema=${encodeURIComponent(param)}`;
		}, 1500);
})


/** Crea todas las partes del elemento ruleta según la lista de conceptos */
function ajustarRuleta (){
	// Primero borro la ruleta anterior y creo una nueva.
	if(opcionesContainer)	ruleta.removeChild(opcionesContainer)
	opcionesContainer = document.createElement("div");
	opcionesContainer.id = "opcionesContainer";
	ruleta.appendChild(opcionesContainer);
	let pAcumulada = 0
	conceptos.forEach((concepto, i) => {
		//Creo triangulos de colores
		const opcionElement = document.createElement("div");
		opcionElement.classList.toggle("opcion",true);
		opcionElement.style = `
			--color: #${colores[i%colores.length]};
			--deg:${probabilidadAGrados(pAcumulada)}deg;
			${getPosicionParaProbabilidad(concepto.probabilidad)}`
		opcionElement.addEventListener("click", ()=> onOpcionClicked(i))
		opcionesContainer.appendChild(opcionElement);
		//Creo textos
		const nombreElement = document.createElement("p");
		nombreElement.textContent = concepto.nombre;
		nombreElement.classList.add("nombre");
		nombreElement.style = `width : calc(${concepto.probabilidad} * var(--escala) * 1.5 / 80);
			transform: rotate(${probabilidadAGrados(concepto.probabilidad)/2+probabilidadAGrados(pAcumulada)}deg)`
		opcionesContainer.appendChild(nombreElement);
		//Creo separadores
		const separadorElement = document.createElement("div");
		separadorElement.style = `transform: rotate(${probabilidadAGrados(pAcumulada)}deg)`
		separadorElement.classList.add("separador");
		opcionesContainer.appendChild(separadorElement);
		pAcumulada += concepto.probabilidad;
		//Reseteo la posición y el cartel
		ruleta.style.transform = "rotate(0deg)";
		ganadorTextoElement.textContent = "¡Click en Girar para iniciar!";
	})
}


//Eventos de botones

document.getElementById("sortear").addEventListener("click", () => {
	if(!sorteando) {
		sortear();
	}
})

function onOpcionClicked(i){
	// Modal deshabilitado por petición del usuario.
	// Antes aquí se construía el formulario y se llamaba a `modal.showModal()`.
	// Para no mostrar nunca el diálogo, simplemente ignoramos el click.
	console.log('onOpcionClicked: modal deshabilitado (click en opción ignorado). Opción index:', i);
	return;
}

botonAceptar.addEventListener("click",()=> {
	conceptos = Array.from(formContainer.children).map(opcion =>
		nuevaProbabilidad = {
			nombre: opcion.children[0].tagName==="LABEL" ? opcion.children[0].textContent : opcion.children[0].value,
			pInicial: 0,
			probabilidad: parseFloat(opcion.children[1].value)
		})
		ajustarRuleta()
		modal.close()
	});

	botonCancelar.addEventListener("click",()=> {
		modal.close();
	});


/** Revisa si  los porcentajes de probabilidades suman a 100% */
function verificarValidezFormulario(){
	suma=0;
	Array.from(formContainer.children).forEach(opcion =>{
		suma += parseFloat(opcion.children[1].value);
	})
	botonAceptar.disabled = suma !== 100; // Deshabilito el botón aceptar si la suma es distinto de 100
	totalElement.textContent = suma.toString();
	
}

// Botón "+" en el formulario de probabilidades
document.getElementById("agregar").addEventListener("click",() =>{
	agregarConfiguracionProbabilidad();
})

function agregarConfiguracionProbabilidad(probabilidad = undefined){
	const opcionContainer = document.createElement("div");
	let opcionLabel;
	const opcionInput = document.createElement("input");
	const eliminarBoton = document.createElement("button");
	if(probabilidad){
		opcionLabel = document.createElement("label");
		opcionLabel.textContent = probabilidad.nombre;
		opcionLabel.for = probabilidad.nombre;
		opcionInput.value = probabilidad.probabilidad;
		opcionLabel.type = "text";
	}
	else {
		opcionLabel = document.createElement("input");
	}
	opcionInput.type = "number";
	eliminarBoton.textContent = "X"
	opcionInput.addEventListener("change", ()=> verificarValidezFormulario())
	opcionContainer.appendChild(opcionLabel);
	opcionContainer.appendChild(opcionInput);
	opcionContainer.appendChild(eliminarBoton);
	formContainer.appendChild(opcionContainer);
	eliminarBoton.addEventListener("click",(event)=>{
		event.target.parentNode.parentNode.removeChild(event.target.parentNode); //También puede ser formContainer.removeChild(event.target.parentNode)
		verificarValidezFormulario();
	})
}


//Heptágono en Clippy https://bennettfeely.com/clippy/
//100% 360º - clip-path: polygon(50% 0%, 100% 0, 100% 100%, 0 100%, 0 0, 50% 0, 50% 50%)
//87.5 315º - clip-path: polygon(50% 0%, 100% 0, 100% 100%, 0 100%, 0 0, 0 0, 50% 50%)
//75% 270º - clip-path: polygon(50% 0, 100% 0, 100% 100%, 0 100%, 0 50%, 50% 50%)
//62.5% 225º - clip-path: polygon(50% 0, 100% 0, 100% 100%, 0 100%, 0 100%, 50% 50%)
//50%	180º - clip-path: polygon(50% 0, 100% 0, 100% 100%, 50% 100%, 50% 50%)
//37.5%	135º - clip-path: polygon(50% 0, 100% 0, 100% 100%, 100% 100%, 50% 50%)
//25%	90º - clip-path: polygon(50% 0, 100% 0, 100% 49%, 50% 50%)
//12.5%	45º - clip-path: polygon(50% 0, 100% 0, 100% 6%, 50% 50%)
//1%	3.6º - clip-path: polygon(50% 0, 51% 0, 50% 50%);
//0%	3.6º - clip-path: polygon(50% 0, 50% 0, 50% 50%);

/** Desde una probabilidad en % devuelve un clip-path que forma el ángulo correspondiente a esa probabilidad */
function getPosicionParaProbabilidad(probabilidad){
	if(probabilidad === 100){
		return ''
	}
	if(probabilidad >= 87.5){
		const x5 = Math.tan(probabilidadARadianes(probabilidad))*50+50;
		return `clip-path: polygon(50% 0%, 100% 0, 100% 100%, 0 100%, 0 0, ${x5}% 0, 50% 50%)`
	}
	if(probabilidad >= 75){
		const y5 = 100 - (Math.tan(probabilidadARadianes(probabilidad-75))*50+50);
		return `clip-path: polygon(50% 0%, 100% 0, 100% 100%, 0 100%, 0% ${y5}%, 50% 50%)`
	}
	if(probabilidad >= 62.5){
		const y5 = 100 - (0.5 - (0.5/ Math.tan(probabilidadARadianes(probabilidad))))*100;
		return `clip-path: polygon(50% 0%, 100% 0, 100% 100%, 0 100%, 0% ${y5}%, 50% 50%)`
	}
	if(probabilidad >= 50){
		const x4 = 100 - (Math.tan(probabilidadARadianes(probabilidad))*50+50);
		return `clip-path: polygon(50% 0, 100% 0, 100% 100%, ${x4}% 100%, 50% 50%)`
	}
	if(probabilidad >= 37.5){
		const x4 = 100 - (Math.tan(probabilidadARadianes(probabilidad))*50+50);
		return `clip-path: polygon(50% 0, 100% 0, 100% 100%, ${x4}% 100%, 50% 50%)`
	}
	if(probabilidad >= 25){
		const y3 = Math.tan(probabilidadARadianes(probabilidad-25))*50+50;
		return `clip-path: polygon(50% 0, 100% 0, 100% ${y3}%, 50% 50%)`
	}
	if(probabilidad >= 12.5){
		const y3 = (0.5 - (0.5/ Math.tan(probabilidadARadianes(probabilidad))))*100;
		return `clip-path: polygon(50% 0, 100% 0, 100% ${y3}%, 50% 50%)`
	}
	if(probabilidad >= 0){
		const x2 = Math.tan(probabilidadARadianes(probabilidad))*50 + 50;
		return `clip-path: polygon(50% 0, ${x2}% 0, 50% 50%)`
	}
}


/** Inicia ejecución */
init();

/** Cómo dibujar ángulos en CSS */
// Al final no lo usé.
// https://stackoverflow.com/questions/21205652/how-to-draw-a-circle-sector-in-css
// x = cx + r * cos(a)
// y = cy + r * sin(a)
