
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación del Juego</title>
    <link rel="stylesheet" href="php/views/css/usuario.css">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
</head>
<body id="creacionJuegos">
    <?php
        $mensaje = $mensaje ?? '';
        $temas = $temas ?? [];
    ?>
    <header>
        <a href="index.php?controller=Juego&action=listarJuegos">
            <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        </a>
        <h1>PreguntaDaw</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php?controller=Juego&action=listarJuegos">Panel</a></li>
            <li><a href="index.php?controller=Juego&action=crearJuego">Crear juego</a></li>
            <li><a href="index.php?controller=Administrador&action=listarAdministradores">Gestionar Usuarios</a></li>
            <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="./index.php?action=vistaGestionAvatares&controller=Administrador">Avatares</a></li>
            <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
        </ul>
    </nav>

    <main>
        <div class="container">
            <?php if (!empty($mensaje)): ?>
                <div id="alert" class="mostrar <?php echo (strpos($mensaje, '✅') !== false) ? 'exito' : 'error'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?controller=Juego&action=crearJuego" id="formCrearJuego" method="POST">
                <input type="hidden" name="temasSeleccionados" id="temasSeleccionadosInput">
                
                <p class="subtitle">Completa los datos de tu nuevo juego. Recuerda que debe tener exactamente 4 temas.</p>
                
                <div class="form-box">
                    <label>Titulo del juego</label>
                    <input type="text" name="tituloJuego" id="tituloJuego" placeholder="Ej: Cultura General" required>
                </div>
                
                <div class="form-box">
                    <label>Juego Publico</label>
                    <span class="subtitle">Permite que otros usuarios puedan encontrar y jugar tu juego</span>
                    <input type="checkbox" name="juegoPublico" id="checkbox-publico" value="1"/>
                </div>

                <div class="form-box">
                    <label>Juego Habilitado</label>
                    <span class="subtitle">Permite que se pueda jugar</span>
                    <input type="checkbox" name="juegoHabilitado" id="checkbox-publico" value="1"/>
                </div>
                
                <div class="form-box">
                    <label>Temas del Juego</label>
                    <p class="subtitle">Selecciona temas sugeridos o crea los tuyos propios</p>
                    
                    <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <!-- Los temas se cargarán por JavaScript -->
                            </ul>
                        </div>
                    </div>
                </div>

                <h2>Tus Temas</h2>
                <p class="subtitle">Temas: <span id="contador-temas">0</span>/4</p>
                
                <div class="form-box" id="seleccionados">
                    <!-- Aquí aparecerán los temas seleccionados por JS -->
                </div>

                <button type="submit" id="crearJuego" class="save-btn">Crear Juego</button>
            </form>
        </div>
    </main>

    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>

    <script type="module" src="javaScript/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
</body>
</html>