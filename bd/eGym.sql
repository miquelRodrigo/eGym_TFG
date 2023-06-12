-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2023 a las 07:51:47
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `egym`
--
CREATE DATABASE IF NOT EXISTS `egym` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `egym`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `nombreClase` varchar(10) NOT NULL,
  `imagenClase` varchar(50) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`nombreClase`, `imagenClase`, `descripcion`) VALUES
('Boxeo', 'boxeo.jpg', 'Boxeo, deporte en el que dos personas combaten entre sí, únicamente con sus puños. Un combate de boxeo se desarrolla bajo unas reglas establecidas y cuenta con un árbitro, jueces y un cronometrador.'),
('Calistenia', 'calistenia.jpg', 'La calistenia es un sistema de entrenamiento con ejercicios físicos que se realizan con el propio peso corporal. En su concepto más puro la calistenia se practica sin cargas adicionales. El propio cuerpo del deportista es el que ejerce como resistencia trabajando así tanto la fuerza como la capacidad cardiovascular.'),
('Crossfit', 'crossfit.jpg', 'CrossFit es una técnica de entrenamiento que conecta movimientos de diferentes disciplinas, tales como la halterofilia, el entrenamiento metabólico o el gimnástico. Consiste en acometer un programa de ejercicios (flexiones, tracción, etc), en un tiempo determinado y con un número definido de veces.'),
('Cycling', 'cycling.jpg', 'Se trata de un ejercicio físico colectivo, el cual se realiza sobre una bicicleta estática al ritmo de la música, en la que se efectúa un trabajo cardiovascular de alta intensidad con intervención muy elevada de los grandes grupos musculares del tren inferior.'),
('Natacion', 'natacion.jpg', 'La natación utiliza la mayoría de los grupos musculares y es un exigente ejercicio físico que ayuda a mantener el corazón y los pulmones saludables. Nadar también ayuda a mantener flexibles las articulaciones, especialmente el cuello, los hombros, y la pelvis.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `nombreUsuario` varchar(30) DEFAULT NULL,
  `apellido1` varchar(30) DEFAULT NULL,
  `apellido2` varchar(30) DEFAULT NULL,
  `contraseña` varchar(255) NOT NULL,
  `iban` varchar(24) DEFAULT NULL,
  `mail` varchar(255) NOT NULL,
  `imagenUsuario` varchar(50) DEFAULT NULL,
  `nivelCrossfit` enum('principiante','intermedio','avanzado') DEFAULT NULL,
  `nivelCycling` enum('principiante','intermedio','avanzado') DEFAULT NULL,
  `nivelCalistenia` enum('principiante','intermedio','avanzado') DEFAULT NULL,
  `nivelBoxeo` enum('principiante','intermedio','avanzado') DEFAULT NULL,
  `nivelNatacion` enum('principiante','intermedio','avanzado') DEFAULT NULL,
  `tipo_usuario` enum('usuario','administrador') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dni`, `nombreUsuario`, `apellido1`, `apellido2`, `contraseña`, `iban`, `mail`, `imagenUsuario`, `nivelCrossfit`, `nivelCycling`, `nivelCalistenia`, `nivelBoxeo`, `nivelNatacion`, `tipo_usuario`) VALUES
('26754134L', 'Teresa', 'Badillo', 'Ruiz', '$2y$10$WcCGtMeY6f43xLjYO2jRie9S9biWgaEZfkw69OZ83ax447dUzsmwy', 'es2222223222222222222222', 'teresa@gmail.com', 'teresa', 'principiante', 'principiante', 'principiante', 'principiante', 'principiante', 'usuario'),
('26754134M', 'Miquel', 'Rodrigo', 'Navarro', '$2y$10$dKazYJ1axcetY2aeD5LFVuXl6AfmpVO.Ca7ISzxbMef57U0BVB/wS', 'es2222222222222222222222', 'maikirn@gmail.com', 'maikirn', 'principiante', 'principiante', 'principiante', 'principiante', 'principiante', 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `nombreVideo` varchar(50) NOT NULL,
  `video` varchar(50) NOT NULL,
  `nivel` enum('principiante','intermedio','avanzado') NOT NULL,
  `nombreClase` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`nombreVideo`, `video`, `nivel`, `nombreClase`) VALUES
('boxeo avanzado', 'boxeo_avanzado.mp4', 'avanzado', 'Boxeo'),
('boxeo intermedio', 'boxeo_intermedio.mp4', 'intermedio', 'Boxeo'),
('boxeo principiante', 'boxeo_principiante.mp4', 'principiante', 'Boxeo'),
('calistenia avanzado', 'calistenia_avanzado.mp4', 'avanzado', 'Calistenia'),
('calistenia intermedio', 'calistenia_intermedio.mp4', 'intermedio', 'Calistenia'),
('calistenia principiante', 'calistenia_princiante.mp4', 'principiante', 'Calistenia'),
('como boxear', 'bb.mp4', 'principiante', 'Boxeo'),
('como ponerse los guantes', 'dsddd.mp4', 'principiante', 'Boxeo'),
('crossfit avanzado', 'crossfit_avanzado.mp4', 'avanzado', 'Crossfit'),
('crossfit intermedio', 'crossfit_intermedio.mp4', 'intermedio', 'Crossfit'),
('crossfit principiante', 'crossfit_principiante.mp4', 'principiante', 'Crossfit'),
('cycling avanzado', 'cycling_avanzado.mp4', 'avanzado', 'Cycling'),
('cycling intermedio', 'cycling_intermedio.mp4', 'intermedio', 'Cycling'),
('cycling principiante', 'cycling_principiante.mp4', 'principiante', 'Cycling'),
('Mike Tyson estilo', 'zzzz.mp4', 'avanzado', 'Boxeo'),
('natacion avanzado', 'natacion_avanzado.mp4', 'avanzado', 'Natacion'),
('natacion intermedio', 'natacion_intermedio.mp4', 'intermedio', 'Natacion'),
('natacion principiante', 'natacion_principiante.mp4', 'principiante', 'Natacion'),
('principios del boxeo', 'aa.mp4', 'principiante', 'Boxeo'),
('técnicas de boxeo', 'cc.mp4', 'principiante', 'Boxeo'),
('tipos de estilos', 'hh.mp4', 'intermedio', 'Boxeo'),
('tipos de golpes', 'sasas.mp4', 'intermedio', 'Boxeo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`nombreClase`),
  ADD UNIQUE KEY `imagenClase` (`imagenClase`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `imagenUsuario` (`imagenUsuario`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`nombreVideo`),
  ADD UNIQUE KEY `video` (`video`),
  ADD KEY `FK_VIDEOS_CLASES` (`nombreClase`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `FK_VIDEOS_CLASES` FOREIGN KEY (`nombreClase`) REFERENCES `clases` (`nombreClase`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
