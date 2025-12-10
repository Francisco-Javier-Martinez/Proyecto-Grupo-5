
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="php/views/css/stylesPanelP.css">
</head>
<body>
    <header>
        <a href="panelAdministrador.php">
            <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
        </a>
        <h1>Bienvenido <?php echo $_SESSION['nombre']?></h1>
    </header>
    <nav>
        <ul>
            <li><a href="verDatos.html">Tu cuenta</a></li>
            <li><a href="creacion_Juegos.html">Crear juego</a></li>
            <li><a href="./index.php?action=listarAdministradores&controller=Administrador">Gestionar Usuarios</a></li>
            <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="gestion_Avatares.html">Avatares</a></li>
            <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
        </ul>
    </nav>
    <main>
        <h1>Juegos Creados</h1>
        
        <section id="tarjetas">
            
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
            <div class="contenedorEtiqueta">
                    <div class="encabezadoTarjeta">
                        <h3>Titulo</h3>
                        <div class="estadoJuego">Publico</div> 
                    </div>
                    <div class="contenedorTemas"> 
                        <div><p>Tema 1</p></div>
                        <div><p>Tema 2</p></div>
                        <div><p>Tema 3</p></div>
                        <div><p>Tema 4</p></div>
                    </div>
            </div>
        </section>
        
    </main>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>