<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestión de Avatares</title>
        <link rel="stylesheet" href="./php/views/css/jc.css">
    </head>
    <body id="gestionAvatares">

        <header>
            <h1>Gestión de Avatares</h1>
        </header>

        <main>
            <section>
            <?php foreach ($datos as $avatar): ?>

                <article>
                    <!-- BOTÓN BORRAR -->
                    <a href="./index.php?controller=Personajes&action=borrarAvatar&id=<?=$avatar['idPersonaje']?>">
                        <img src="php/views/img/imagenesAux/basura.png" class="imgBasura">
                    </a>

                    <!-- IMAGEN desde BLOB -->
                    <img 
                        class="imgAvatar"
                        src="data:image/png;base64,<?= base64_encode($avatar['imagen']); ?>"
                        alt="<?=$avatar['nombre']?>"
                    >

                    <h4><?= $avatar['nombre'] ?></h4>
                </article>

            <?php endforeach; ?>
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
    </body>
</html>
