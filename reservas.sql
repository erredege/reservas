-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2020 a las 17:50:40
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reservas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_instalaciones`
--

CREATE TABLE `horario_instalaciones` (
  `id` int(11) NOT NULL,
  `dia_semamana` int(11) NOT NULL,
  `hora_ini` int(11) NOT NULL,
  `hora_fin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instalaciones`
--

CREATE TABLE `instalaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `instalaciones`
--

INSERT INTO `instalaciones` (`id`, `nombre`, `descripcion`, `imagen`, `precio`) VALUES
(1, 'rugby', 'pista de rugby1', 'imgs/instalacion/GOT3.jpeg', 51),
(2, 'futbol', 'pista de futbol', 'imgs/instalacion/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 5),
(3, 'rugby2', 'pista de rugby 2', 'imgs/instalacion/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 10),
(4, 'futbol2', 'pista de futbol', 'imgs/instalacion/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 8),
(5, 'basket', 'pista de basket', 'imgs/instalacion/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 8),
(11, 'basket2', 'asfsdfsd', 'imgs/instalacion/11.jpg', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` int(11) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `fecha`, `hora`, `precio`) VALUES
(1, '2020-12-03', 2, 20),
(3, '2020-12-04', 2, 3),
(9, '2020-12-07', 12, 12),
(10, '2020-12-03', 22, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido1` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido2` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `dni` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagen` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo` varchar(1000) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `apellido1`, `apellido2`, `dni`, `imagen`, `tipo`) VALUES
(1, 'rosen@gmail.com', '123', 'rosen', 'a', 'a', '12345678', 'imgs/usuario/GOT3.jpeg', 'admin'),
(2, 'pepe@gmail.com', '123', 'pepe', 'p', 'p', '1234567879', 'imgs/usuario/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 'user'),
(3, 'pepe@gmail.com', '123', 'pepe', 'p', 'p', '1234567879', 'imgs/usuario/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 'user'),
(20, 'sdf@gmail.com', '123', 'kugy', 'jubj', 'iub', '123456789', 'imgs/usuario/5322166_052919-kabc-geo-star-wars-millennium-falcon-dig1-vid.jpg', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `horario_instalaciones`
--
ALTER TABLE `horario_instalaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `horario_instalaciones`
--
ALTER TABLE `horario_instalaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
