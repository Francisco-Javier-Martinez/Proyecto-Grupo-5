CREATE DATABASE preguntadaw;
USE preguntadaw;

CREATE TABLE personajes(
    idPersonaje tinyint unsigned NOT NULL auto_increment,
    nombre varchar (50) NOT NULL,
    imagen binary NOT NULL,
    PRIMARY KEY (idPersonaje)
); 

CREATE TABLE usuarios(
    idUsuario SMALLINT UNSIGNED NOT NULL auto_increment,
    nombre varchar(50) NOT NULL,
    contrasenia CHAR (15) NOT NULL,
    email varchar(150) NOT NULL,
    PRIMARY KEY(idUsuario),
    CONSTRAINT email_Usuarios UNIQUE(email)
); 

CREATE TABLE juego(
    idJuego smallint unsigned NOT NULL auto_increment,
    descripcion varchar(250) NOT NULL,
    codigo char (7) NOT NULL,
    publico bit NOT NULL DEFAULT 0,
    idUsuario SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (idJuego),
    CONSTRAINT FK_Juego FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

CREATE TABLE jugador(
    idJugador smallint unsigned NOT NULL auto_increment,
    nombre varchar (50) NOT NULL,
    idPersonaje tinyint unsigned NOT NULL,
    PRIMARY KEY(idJugador),
    CONSTRAINT fk_Personajes FOREIGN KEY (idPersonaje) REFERENCES personajes (idPersonaje)
); 

CREATE TABLE ranking(
    idJugador smallint unsigned NOT NULL,
    idJuego smallint unsigned NOT NULL,
    puntuacion smallint unsigned NOT NULL,
    CONSTRAINT PK_Juego PRIMARY KEY (idJugador, idJuego),
    CONSTRAINT FK_Juego_idJugador FOREIGN KEY(idJugador) REFERENCES jugador(idJugador),
    CONSTRAINT FK_Juego_idJuego FOREIGN KEY(idJuego) REFERENCES juego(idJuego),
    CONSTRAINT chk_puntuacion CHECK (puntuacion BETWEEN 250 AND 500)
);

CREATE TABLE tema(
    idTema smallint unsigned NOT NULL auto_increment,
    nombre varchar(50) NOT NULL,
    descripcion varchar(250) NOT NULL,
    publico bit NOT NULL DEFAULT 0,
    abreviatura char(10) NOT NULL,
    idUsuario smallint unsigned NULL DEFAULT NULL,
    CONSTRAINT PK_Temas PRIMARY KEY(idTema),
    CONSTRAINT FK_Temas FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

CREATE TABLE temas_juegos(
    idTema smallint unsigned NOT NULL,
    idJuego smallint unsigned NOT NULL,
    CONSTRAINT PK_JuegosTemas PRIMARY KEY (idTema, idJuego),
    CONSTRAINT FKTemas_JuegosTemas FOREIGN KEY(idTema) REFERENCES tema(idTema),
    CONSTRAINT FKJuegos_JuegosTemas FOREIGN KEY(idJuego) REFERENCES juego(idJuego)
);

/* PREGUNTAS, RESPUESTAS - CORREGIDO */

CREATE TABLE preguntas(
    idTema smallint unsigned NOT NULL,  -- QUITADO auto_increment aquí
    nPregunta tinyint unsigned NOT NULL,
    titulo varchar(50) NOT NULL,  -- Cambiado "título" (con tilde) por "titulo" (sin tilde)
    imagen varchar(20) NOT NULL,
    explicacion varchar(250) NOT NULL,
    puntuacion smallint unsigned NULL DEFAULT 200,  -- CORREGIDO: un solo DEFAULT
    CONSTRAINT idPregunta PRIMARY KEY(idTema, nPregunta),
    CONSTRAINT fk_preguntas_tema FOREIGN KEY (idTema) REFERENCES tema(idTema)  -- AÑADIDO: falta esta referencia
);

CREATE TABLE respuestas (
    idTema SMALLINT UNSIGNED NOT NULL,
    nPregunta TINYINT UNSIGNED NOT NULL,
    nLetra CHAR(1) NOT NULL CHECK (nLetra IN('a','b','c','d')),
    texto VARCHAR(500) NOT NULL,
    es_correcta BIT NOT NULL DEFAULT 0,  -- AÑADIDO: para identificar cuál es la correcta

    CONSTRAINT idRespuesta PRIMARY KEY (idTema, nPregunta, nLetra),
    CONSTRAINT fk_pregunta FOREIGN KEY (idTema, nPregunta) REFERENCES preguntas(idTema, nPregunta)
);

-- 1. Elimina la clave foránea existente (ya que no podemos modificar directamente sus acciones ON DELETE/ON UPDATE)
ALTER TABLE respuestas
DROP FOREIGN KEY fk_pregunta;

-- 2. Vuelve a crear la clave foránea con la acción ON DELETE CASCADE
ALTER TABLE respuestas
ADD CONSTRAINT fk_pregunta FOREIGN KEY (idTema, nPregunta)
REFERENCES preguntas(idTema, nPregunta)
ON DELETE CASCADE
ON UPDATE CASCADE;
