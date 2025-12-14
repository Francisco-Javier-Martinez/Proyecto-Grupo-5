<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar contraseña</title>
    <link rel="stylesheet" href="./php/views/css/stylesPanelP.css">
</head>
<body>
    <header>
        <a href="index.php?controller=Usuario&action=verDatos">
            <img id="logo" src="img/preguntadawLogo.png" alt="Logo preguntadaw">
        </a>
        <h1>Bienvenido <?php echo htmlspecialchars($datos['usuario']['nombre'] ?? 'Usuario'); ?></h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php?controller=Juego&action=listarJuegos">Panel</a></li>
            <li><a href="index.php?controller=Juego&action=crearJuego">Crear juego</a></li>
            <?php
                if ($_SESSION['tipo'] == 1) {
                    echo '<li><a href="index.php?controller=Administrador&action=listarAdministradores">Gestionar Usuarios</a></li>';
                }
            ?>
            <li><a href="./index.php?action=listarTemas&controller=Temas">Temas</a></li>
            <li><a href="./index.php?action=vistaGestionAvatares&controller=Administrador">Avatares</a></li>
            <li><a href="./index.php?action=cerrarSesion&controller=Administrador">Cerrar sesion</a></li>
        </ul>
    </nav>
    <main>
        <h1>Modificar contraseña</h1>
        <?php if(!empty($mensajeError)) : ?>
            <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($mensajeError); ?></p>
        <?php endif; ?>
        <section>
            <form action="index.php?controller=Usuario&action=modificarContraseña" method="post">
                <label for="codigo">Código de recuperación</label>
                <input type="text" id="codigo" name="codigo" required>

                <label for="contraseña">Nueva contraseña</label>
                <input type="password" id="contraseña" name="contraseña" required>

                <label for="contraseña1">Repítela</label>
                <input type="password" id="contraseña1" name="contraseña1" required>

                <input type="submit" value="Enviar">
            </form>
        </section>
    </main>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>
