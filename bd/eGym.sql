-- CREACIÓN DE BASE DE DATOS
CREATE DATABASE IF NOT EXISTS `egym`;
USE `egym`;

-- TABLA USUARIOS
CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `nombreUsuario` varchar(30) NOT NULL NULL,
  `apellido1` varchar(30) NOT NULL NULL,
  `apellido2` varchar(30) NOT NULL NULL,
  `contraseña` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL UNIQUE,
  `imagenUsuario` varchar(50) DEFAULT NULL UNIQUE,
  `tipoUsuario` enum('usuario','administrador') DEFAULT 'usuario'
);

-- DATOS PARA LA TABLA USUARIO
INSERT INTO `usuarios` (`dni`, `nombreUsuario`, `apellido1`, `apellido2`, `contraseña`, `mail`, `imagenUsuario`, `tipoUsuario`) VALUES
('26754134A', 'Teresa', 'Badillo', 'Ruiz', '$2y$10$WcCGtMeY6f43xLjYO2jRie9S9biWgaEZfkw69OZ83ax447dUzsmwy', 'teresa@gmail.com', 'teresa', 'usuario'),
('26754134M', 'Miquel', 'Rodrigo', 'Navarro', '$2y$10$dKazYJ1axcetY2aeD5LFVuXl6AfmpVO.Ca7ISzxbMef57U0BVB/wS', 'maikirn@gmail.com', 'maikirn', 'administrador');


-- TABLA COMENTARIOS
CREATE TABLE `comentarios` (
`claveComentarios` int,
`dni` varchar(9) NOT NULL,
`comentario` text NOT NULL,
`fecha` date NOT NULL,
`calificacion` int NOT NULL
);


-- TABLA CLASES
CREATE TABLE `clases` (
  `nombreClase` varchar(10) NOT NULL,
  `imagenClase` varchar(50) NOT NULL UNIQUE,
  `descripcion` text NOT NULL
);

-- DATOS PARA LA TABLA CLASES
INSERT INTO `clases` (`nombreClase`, `imagenClase`, `descripcion`) VALUES
('Boxeo', 'boxeo.jpg', 'Boxeo, deporte en el que dos personas combaten entre sí, únicamente con sus puños. Un combate de boxeo se desarrolla bajo unas reglas establecidas y cuenta con un árbitro, jueces y un cronometrador.'),
('Calistenia', 'calistenia.jpg', 'La calistenia es un sistema de entrenamiento con ejercicios físicos que se realizan con el propio peso corporal. En su concepto más puro la calistenia se practica sin cargas adicionales. El propio cuerpo del deportista es el que ejerce como resistencia trabajando así tanto la fuerza como la capacidad cardiovascular.'),
('Crossfit', 'crossfit.jpg', 'CrossFit es una técnica de entrenamiento que conecta movimientos de diferentes disciplinas, tales como la halterofilia, el entrenamiento metabólico o el gimnástico. Consiste en acometer un programa de ejercicios (flexiones, tracción, etc), en un tiempo determinado y con un número definido de veces.'),
('Cycling', 'cycling.jpg', 'Se trata de un ejercicio físico colectivo, el cual se realiza sobre una bicicleta estática al ritmo de la música, en la que se efectúa un trabajo cardiovascular de alta intensidad con intervención muy elevada de los grandes grupos musculares del tren inferior.'),
('Natacion', 'natacion.jpg', 'La natación utiliza la mayoría de los grupos musculares y es un exigente ejercicio físico que ayuda a mantener el corazón y los pulmones saludables. Nadar también ayuda a mantener flexibles las articulaciones, especialmente el cuello, los hombros, y la pelvis.');


-- TABLA USUARIOS_CLASES
CREATE TABLE `usuarios_clases` (
`dni` varchar(9) NOT NULL,
`nombreClase` varchar(10) NOT NULL,
`nivel` enum('principiante','intermedio','avanzado') DEFAULT 'principiante'
);


-- TABLA VIDEOS
CREATE TABLE `videos` (
  `nombreVideo` varchar(50) NOT NULL,
  `video` varchar(50) NOT NULL UNIQUE,
  `nivel` enum('principiante','intermedio','avanzado') NOT NULL,
  `nombreClase` varchar(10) NOT NULL
);

-- DATOS PARA TABLA VIDEOS
INSERT INTO `videos` (`nombreVideo`, `video`, `nivel`, `nombreClase`) VALUES
('boxeo avanzado', 'boxeo_avanzado.mp4', 'avanzado', 'Boxeo'),
('boxeo intermedio', 'boxeo_intermedio.mp4', 'intermedio', 'Boxeo'),
('boxeo principiante', 'boxeo_principiante.mp4', 'principiante', 'Boxeo'),
('calistenia avanzado', 'calistenia_avanzado.mp4', 'avanzado', 'Calistenia'),
('calistenia intermedio', 'calistenia_intermedio.mp4', 'intermedio', 'Calistenia'),
('calistenia principiante', 'calistenia_princiante.mp4', 'principiante', 'Calistenia'),
('crossfit avanzado', 'crossfit_avanzado.mp4', 'avanzado', 'Crossfit'),
('crossfit intermedio', 'crossfit_intermedio.mp4', 'intermedio', 'Crossfit'),
('crossfit principiante', 'crossfit_principiante.mp4', 'principiante', 'Crossfit'),
('cycling avanzado', 'cycling_avanzado.mp4', 'avanzado', 'Cycling'),
('cycling intermedio', 'cycling_intermedio.mp4', 'intermedio', 'Cycling'),
('cycling principiante', 'cycling_principiante.mp4', 'principiante', 'Cycling'),
('natacion avanzado', 'natacion_avanzado.mp4', 'avanzado', 'Natacion'),
('natacion intermedio', 'natacion_intermedio.mp4', 'intermedio', 'Natacion'),
('natacion principiante', 'natacion_principiante.mp4', 'principiante', 'Natacion'),
('principios del boxeo', 'aa.mp4', 'principiante', 'Boxeo'),
('técnicas de boxeo', 'cc.mp4', 'principiante', 'Boxeo'),
('como ponerse los guantes', 'dsddd.mp4', 'principiante', 'Boxeo'),
('tipos de estilos', 'hh.mp4', 'intermedio', 'Boxeo'),
('Mike Tyson estilo', 'zzzz.mp4', 'avanzado', 'Boxeo'),
('como boxear', 'bb.mp4', 'principiante', 'Boxeo'),
('tipos de golpes', 'sasas.mp4', 'intermedio', 'Boxeo');


--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`nombreClase`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`);
  
--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY AUTO_INCREMENT (`claveComentarios`),
  ADD CONSTRAINT `FK_COMENTARIOS_USUARIOS` FOREIGN KEY (`dni`) REFERENCES `usuarios` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`nombreVideo`),
  ADD CONSTRAINT `FK_VIDEOS_CLASES` FOREIGN KEY (`nombreClase`) REFERENCES `clases` (`nombreClase`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Indices de la tabla `usuarios_clases`
--
ALTER TABLE `usuarios_clases`
  ADD PRIMARY KEY (`dni`, `nombreClase`),
  ADD CONSTRAINT `FK_USUARIOS_CLASES_USUARIOS` FOREIGN KEY (`dni`) REFERENCES `usuarios` (`dni`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_USUARIOS_CLASES_CLASES` FOREIGN KEY (`nombreClase`) REFERENCES `clases` (`nombreClase`);
