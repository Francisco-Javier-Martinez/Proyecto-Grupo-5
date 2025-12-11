<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestión de Avatares</title>
        <link rel="stylesheet" href="./php/views/css/jc.css">
    </head>
    <body id="gestionAvatares">

        <header>
            <a href="./index.php?controller=Administrador&action=volverPanelInicial"><img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw"></a>
            <h1>Gestión de Avatares</h1>
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
           <section>
            <?php 
            if (empty($datos)): 
            ?>
                <p>No hay avatares</p>
            <?php else: ?>
                <?php foreach ($datos as $avatar): ?>
                    <article>
                        <a href="./index.php?controller=Personajes&action=borrarAvatar&id=<?=$avatar['idPersonaje']?>">
                            <img src="php/views/img/imagenesAux/basura.png" class="imgBasura">
                        </a>

                        <img 
                            class="imgAvatar"
                            src="data:image/png;base64,<?= base64_encode($avatar['imagen']); ?>"
                            alt="<?=$avatar['nombre']?>"
                        >

                        <h4><?= $avatar['nombre'] ?></h4>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>


            <!-- FORMULARIO CREAR AVATAR -->
            <form action="./index.php?controller=Personajes&action=crearAvatar" method="post" enctype="multipart/form-data">
                <h1>Crear avatar</h1>

                <label>Sube imagen del avatar</label>
                <input type="file" name="imagenSubidaAvatar" required>

                <label>Nombre del avatar</label>
                <input type="text" name="nombreAvatar" required>

                <input type="submit" value="Crear">
            </form>
        </main>
        <footer>
            <p>© Escuela Virgen de Guadalupe</p>
        </footer>
        <script type="module" src="javaScript/app.js"></script>
    </body>
</html>
