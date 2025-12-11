<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Creación de Temas</title>
        <link rel="stylesheet" href="php/views/css/jugadorT.css" />
    </head>
    <body id= "modificacionTemas">
        <header>
             <a href="./index.php?controller=Administrador&action=volverPanelInicial"><img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw"></a>
            <h1>PREGUNTADAW</h1>
         </header>
        <nav>
            <ul>
                <li><a href="verDatos.html">Tu cuenta</a></li>
                <li><a href="creacion_Juegos.html">Crear juego</a></li>
                <li><a href="gestion_Usuarios.html">Gestionar Usuarios</a></li>
                <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
                <li><a href="./index.php?action=vistaGestionAvatares&controller=Administrador">Avatares</a></li>
                <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
            </ul>
        </nav>
        <main>
            <div class="contenedor-principal">
                <h2>CREACIÓN DE TEMAS</h2>
                <form action="./index.php?action=introducirTemas&controller=Temas" method="post">
                    <label for="nombre-tema" class="texto-label">Nombre del tema</label>
                    <input id="nombre-tema" type="text" name="nombreTema"/><br>
                    <label for="abreviatura">Abreviatura del tema</label>
                    <input type="text" name="abreviatura" id="abreviatura">
                    <div class="publico-container">
                        <label class="switch-label">
                            Tema público
                            <span class="descripcion">Permite que otros usuarios puedan encontrar y utilizar tu tema para usarlo en sus juegos</span>
                        </label>
                        <label class="switch">
                            <input type="checkbox" name="publico"/>
                        </label>
                    </div>
                    <textarea class="descripcion-tema" placeholder="Descripción del tema" name="descripcion"></textarea>
                    <input type="submit" value="crear" class="botonanadir">
                    <?php
                        if(isset($mensajeError)){
                            echo "<h3>".$mensajeError."</h3>";
                        }
                    ?>
                </form>

            </div>
        </main>
        <footer>
            Derechos reservados a la Escuela Virgen de Guadalupe
        </footer>
        <div id="alert">

        </div>
        <script type="module" src="/javaScript/app.js"></script>
    </body>
</html>
