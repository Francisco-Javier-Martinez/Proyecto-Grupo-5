-- Crear base de datos
CREATE DATABASE IF NOT EXISTS preguntadaw;
USE preguntadaw;

-- TABLA PERSONAJES
CREATE TABLE personajes (
    idPersonaje TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    imagen BLOB NOT NULL,
    PRIMARY KEY (idPersonaje)
);

-- TABLA USUARIOS
CREATE TABLE usuarios (
    idUsuario SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    contrasenia VARCHAR(60) NOT NULL,
    email VARCHAR(150) NOT NULL,
    tipo bit NOT NULL DEFAULT 0,
    PRIMARY KEY (idUsuario),
    CONSTRAINT uniq_email_usuarios UNIQUE(email)
);

-- TABLA JUEGO
CREATE TABLE juego (
    idJuego SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(250) NOT NULL,
    codigo CHAR(7) NOT NULL,
    publico BIT NOT NULL DEFAULT 0,
    idUsuario SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (idJuego),
    CONSTRAINT fk_juego_usuario FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- TABLA JUGADOR
CREATE TABLE jugador (
    idJugador SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    idPersonaje TINYINT UNSIGNED NOT NULL,
    PRIMARY KEY (idJugador),
    CONSTRAINT fk_jugador_personaje FOREIGN KEY (idPersonaje) REFERENCES personajes(idPersonaje)
);

-- TABLA RANKING
CREATE TABLE ranking (
    idJugador SMALLINT UNSIGNED NOT NULL,
    idJuego SMALLINT UNSIGNED NOT NULL,
    puntuacion SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT pk_ranking PRIMARY KEY (idJugador, idJuego),
    CONSTRAINT fk_ranking_jugador FOREIGN KEY(idJugador) REFERENCES jugador(idJugador),
    CONSTRAINT fk_ranking_juego FOREIGN KEY(idJuego) REFERENCES juego(idJuego),
    CONSTRAINT chk_ranking_puntuacion CHECK (puntuacion BETWEEN 250 AND 500)
);

-- TABLA TEMA
CREATE TABLE tema (
    idTema SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(250) NOT NULL,
    publico BIT NOT NULL DEFAULT 0,
    abreviatura CHAR(10) NOT NULL,
    idUsuario SMALLINT UNSIGNED NULL DEFAULT NULL,
    PRIMARY KEY(idTema),
    CONSTRAINT fk_tema_usuario FOREIGN KEY(idUsuario) REFERENCES usuarios(idUsuario)
);

-- TABLA TEMAS_JUEGOS (relación N:M)
CREATE TABLE temas_juegos (
    idTema SMALLINT UNSIGNED NOT NULL,
    idJuego SMALLINT UNSIGNED NOT NULL,
    PRIMARY KEY (idTema, idJuego),
    CONSTRAINT fk_tj_tema FOREIGN KEY(idTema) REFERENCES tema(idTema),
    CONSTRAINT fk_tj_juego FOREIGN KEY(idJuego) REFERENCES juego(idJuego)
);

-- TABLA PREGUNTAS
CREATE TABLE preguntas (
    idTema SMALLINT UNSIGNED NOT NULL,
    nPregunta TINYINT UNSIGNED NOT NULL,
    titulo VARCHAR(50) NOT NULL,
    imagen VARCHAR(60) NOT NULL,
    explicacion VARCHAR(250) NOT NULL,
    puntuacion SMALLINT UNSIGNED NOT NULL DEFAULT 200,
    PRIMARY KEY (idTema, nPregunta),
    CONSTRAINT fk_preguntas_tema FOREIGN KEY (idTema) REFERENCES tema(idTema)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- TABLA RESPUESTAS
CREATE TABLE respuestas (
    idTema SMALLINT UNSIGNED NOT NULL,
    nPregunta TINYINT UNSIGNED NOT NULL,
    nLetra CHAR(1) NOT NULL CHECK (nLetra IN('a','b','c','d')),
    texto VARCHAR(500) NOT NULL,
    es_correcta BIT NOT NULL DEFAULT 0,
    PRIMARY KEY (idTema, nPregunta, nLetra),
    CONSTRAINT fk_respuestas_preguntas FOREIGN KEY (idTema, nPregunta)
        REFERENCES preguntas(idTema, nPregunta)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
