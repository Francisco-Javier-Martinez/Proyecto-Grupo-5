<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestión de Administradores</title>
    <link rel="stylesheet" href="php/views/css/usuario.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
  </head>
  <body id="modificarProfesor">
    <header>
      <img id="logo" src="./php/views/img/preguntadawLogo.png" alt="Logo preguntadaw">
      <h1>Usuarios</h1>
    </header>
    
    <nav>
      <ul>
        <li><a href="panelAdministrador.html">Panel</a></li>
        <li><a href="creacion_Juegos.html">Crear juego</a></li>
        <li><a href="gestion_Usuarios.html">Gestionar Usuarios</a></li>
        <li><a href="gestiontemas.html">Temas</a></li>
        <li><a href="gestion_Avatares.html">Avatares</a></li>
        <li><a href="inicio_sesion_admin.html">Cerrar sesion</a></li>
      </ul>
    </nav>
    
    <div class="container">
      <form action="index.php?controller=Administrador&action=modificarAdministrador&id=<?php echo $admin['idUsuario']; ?>" id="modificarUsuario" method="POST">
        <h2>Modificar Administrador</h2>
        <p class="subtitle">
          Solo los super administradores pueden crear nuevos administradores
        </p>

        <div class="form-box">
          <label for="userName">Nombre de Usuario *</label>
          <input type="text" id="userName" name="userName" placeholder="Ej: admin_juan" />
          <span id="error-userName" class="error-text"></span> 
        </div>

        <div class="form-box">
          <label for="email">Correo Electrónico *</label>
          <input type="email" id="email" name="email" placeholder="admin@ejemplo.com" />
          <span id="error-email" class="error-text"></span> 
        </div>

        <button type="submit" class="save-btn">Guardar Modificación</button>
      </form>
    </div>

    <footer>
      <p>Derechos reservados a la - @Escuela Virgen de Guadalupe</p>
    </footer>

    <script type="module" src="javaScript/app.js"></script>
  </body>
</html>