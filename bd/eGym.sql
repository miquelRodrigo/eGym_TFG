-- CREACIÓN DE BASE DE DATOS
CREATE DATABASE IF NOT EXISTS `egym`;
USE `egym`;

-- TABLA USUARIOS
CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido1` varchar(30) NOT NULL,
  `apellido2` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `imagen` varchar(50) DEFAULT NULL UNIQUE,
  `tipo` enum('usuario','administrador') DEFAULT 'usuario',
  PRIMARY KEY (`dni`)
);

-- TABLA DEPORTES
CREATE TABLE `deportes` (
  `idDeporte` int not null,
  `nombre` varchar(10) NOT NULL,
  `imagen` varchar(50) NOT NULL UNIQUE,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idDeporte`)
);

-- DATOS PARA LA TABLA DEPORTES
INSERT INTO `deportes` (`idDeporte`, `nombre`, `imagen`, `descripcion`) VALUES
(1, 'Boxeo', 'boxeo.jpg', 'Boxeo, deporte en el que dos personas combaten entre sí, únicamente con sus puños. Un combate de boxeo se desarrolla bajo unas reglas establecidas y cuenta con un árbitro, jueces y un cronometrador.'),
(2, 'Calistenia', 'calistenia.jpg', 'La calistenia es un sistema de entrenamiento con ejercicios físicos que se realizan con el propio peso corporal. En su concepto más puro la calistenia se practica sin cargas adicionales. El propio cuerpo del deportista es el que ejerce como resistencia trabajando así tanto la fuerza como la capacidad cardiovascular.'),
(3, 'Crossfit', 'crossfit.jpg', 'CrossFit es una técnica de entrenamiento que conecta movimientos de diferentes disciplinas, tales como la halterofilia, el entrenamiento metabólico o el gimnástico. Consiste en acometer un programa de ejercicios (flexiones, tracción, etc), en un tiempo determinado y con un número definido de veces.'),
(4, 'Cycling', 'cycling.jpg', 'Se trata de un ejercicio físico colectivo, el cual se realiza sobre una bicicleta estática al ritmo de la música, en la que se efectúa un trabajo cardiovascular de alta intensidad con intervención muy elevada de los grandes grupos musculares del tren inferior.'),
(5, 'Natacion', 'natacion.jpg', 'La natación utiliza la mayoría de los grupos musculares y es un exigente ejercicio físico que ayuda a mantener el corazón y los pulmones saludables. Nadar también ayuda a mantener flexibles las articulaciones, especialmente el cuello, los hombros, y la pelvis.');


-- TABLA USUARIOS_DEPORTES
CREATE TABLE `usuarios_deportes` (
`dni` varchar(9) NOT NULL,
`idDeporte` int NOT NULL,
`nivel` enum('principiante','intermedio','avanzado') DEFAULT 'principiante',
PRIMARY KEY (`dni`, `idDeporte`)
);

-- TABLA CLASES
CREATE TABLE `clases` (
  `idClase` int AUTO_INCREMENT not null,
  `nombre` varchar(50) NOT NULL,
  `video` varchar(50) NOT NULL UNIQUE,
  `nivel` enum('principiante','intermedio','avanzado') NOT NULL,
  `idDeporte` int NOT NULL,
  PRIMARY KEY (`idClase`)
);

-- DATOS PARA TABLA CLASES
INSERT INTO `clases` (`nombreClase`, `video`, `nivel`, `idDeporte`) VALUES
('Boxeo avanzado', 'boxeo_avanzado.mp4', 'avanzado', 1),
('Boxeo intermedio', 'boxeo_intermedio.mp4', 'intermedio', 1),
('Boxeo principiante', 'boxeo_principiante.mp4', 'principiante', 1),
('Calistenia avanzado', 'calistenia_avanzado.mp4', 'avanzado', 2),
('Calistenia intermedio', 'calistenia_intermedio.mp4', 'intermedio', 2),
('Calistenia principiante', 'calistenia_princiante.mp4', 'principiante', 2),
('Crossfit avanzado', 'crossfit_avanzado.mp4', 'avanzado', 3),
('Crossfit intermedio', 'crossfit_intermedio.mp4', 'intermedio', 3),
('Crossfit principiante', 'crossfit_principiante.mp4', 'principiante', 3),
('Cycling avanzado', 'cycling_avanzado.mp4', 'avanzado', 4),
('Cycling intermedio', 'cycling_intermedio.mp4', 'intermedio', 4),
('Cycling principiante', 'cycling_principiante.mp4', 'principiante', 4),
('Natacion avanzado', 'natacion_avanzado.mp4', 'avanzado', 5),
('Natacion intermedio', 'natacion_intermedio.mp4', 'intermedio', 5),
('Natacion principiante', 'natacion_principiante.mp4', 'principiante', 5),
('Principios del boxeo', 'aa.mp4', 'principiante', 1),
('Técnicas de boxeo', 'cc.mp4', 'principiante', 1),
('¿Cómo ponerse los guantes?', 'dsddd.mp4', 'principiante', 1),
('Tipos de estilos', 'hh.mp4', 'intermedio', 1),
('Mike Tyson estilo', 'zzzz.mp4', 'avanzado', 1),
('¿Cóomo boxear?', 'bb.mp4', 'principiante', 1),
('Tipos de golpes', 'sasas.mp4', 'intermedio', 1);


-- TABLA COMENTARIOS
CREATE TABLE `comentarios` (
`idComentario` int AUTO_INCREMENT not null,
`dni` varchar(9) NOT NULL,
`texto` varchar(255) NOT NULL,
`fecha` date NOT NULL,
`calificacion` int NOT NULL,
`idClase` int not null,
PRIMARY KEY (`idComentario`)
);

--
-- Indices de la tabla `usuarios_deportes`
--
ALTER TABLE `usuarios_deportes`
  ADD CONSTRAINT `FK_USUARIOS_DEPORTES_USUARIOS` FOREIGN KEY (`dni`) REFERENCES `usuarios` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIOS_DEPORTES_DEPORTES` FOREIGN KEY (`idDeporte`) REFERENCES `deportes` (`idDeporte`);
  
--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `FK_VIDEOS_DEPORTES` FOREIGN KEY (`idDeporte`) REFERENCES `deportes` (`idDeporte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `FK_COMENTARIOS_USUARIOS` FOREIGN KEY (`dni`) REFERENCES `usuarios` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMENTARIOS_CLASES` FOREIGN KEY (`idClase`) REFERENCES `clases` (`idClase`) ON DELETE CASCADE ON UPDATE CASCADE;
