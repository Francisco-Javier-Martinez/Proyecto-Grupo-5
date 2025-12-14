<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus datos</title>
    <link rel="stylesheet" href="./php/views/css/stylesPanelP.css">
</head>
<body id="verDatos">
    <header>
       <a href="index.php?controller=Juego&action=listarJuegos">
            <img id="logo" src="php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
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
        <h1>Tu cuenta</h1>
        <section>
            <form id="formulario">
                <label for="nombre">Nombre de usuario</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo ($datos['usuario']['nombre'] ?? ''); ?>">
                
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="<?php echo ($datos['usuario']['email'] ?? ''); ?>">
                
                <a href="index.php?controller=Usuario&action=generarCodigoRecuperacion">¿Has olvidado tu contraseña?</a>
            </form>
        </section>
    </main>
    <footer>
        <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>
</body>
</html>