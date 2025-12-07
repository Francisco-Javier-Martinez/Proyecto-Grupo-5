<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Instalacion administrador</title>
        <link rel="stylesheet" href="jc.css">
    </head>
    <body id="loginAdmin">
        <header>
            <img id="logo" src="img/preguntadawLogo.png" alt="Logo preguntadaw">
            <h1>Preguntadaw</h1>
        </header>
        <main>
            <form action="recoger.php?tipo=1" method="post">
                <h1>Administrador del juego</h1>
                <label for="email">Email: </label>
                <input type="email" id="email" name="email">
                <label for="nombre">Nombre: </label>
                <input type="text" id="nombre" name="nombre">
                <label for="password">Contraseña: </label>
                <input type="password" id="password" name="password">
                <input type="submit" value ="Acceder">
                <?php
                    if(isset($_GET['mensaje'])){
                        echo "<h3>".$_GET['mensaje']."</h3>";
                    }
                ?>
            </form>
            
        </main>
        <footer>
            <h3>Escuela Virgen de Guadalupe - © Todos los derechos reservados</h3>
        </footer>
    </body>
</html>