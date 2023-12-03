-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 03-12-2023 a las 06:12:57
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `empresa01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `apellido` varchar(120) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `pass` varchar(120) NOT NULL,
  `rol` int(1) NOT NULL,
  `archivo_h` varchar(255) NOT NULL,
  `archivo` varchar(120) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `eliminado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id`, `nombre`, `apellido`, `correo`, `pass`, `rol`, `archivo_h`, `archivo`, `status`, `eliminado`) VALUES
(1, 'Diego Humberto', 'Esquivel', 'seguridad@gmail.com', '123', 2, '', '', 1, 1),
(2, 'Samuel emanuel', 'Esquivel', 'samuel@hotmail.com', '1123', 2, '', '', 1, 1),
(3, 'Karla judith', 'Barbosa', 'karla@gmail.com', '5542', 1, '', '', 1, 1),
(4, 'Joel', 'Quintero', 'joel@gmail.com', '123456', 1, '', '', 1, 1),
(5, 'Javier', 'Mendez', 'javier@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, '', '', 1, 1),
(6, 'Maria ', 'Barbosa', 'javier@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, '', '', 1, 1),
(7, 'Jaret', 'Esquivel', 'javier@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, '', '', 1, 0),
(8, 'Eduardo Ulises', 'Barbosa Zaragoza', 'eduardo1@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, '', '', 1, 0),
(9, 'manuel', 'mendez', 'joel@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, '', '', 1, 0),
(10, 'Mauricio', 'Santos', 'mauricio@gmail.com', '3aca6cc84657b8d0b2f42c3821ce0ba6', 2, '', '', 1, 0),
(11, 'Elena ', 'Macias', 'elena@gmail.com', '268e27056a3e52cf3755d193cbeb0594', 2, '', '', 1, 0),
(13, 'francisco', 'escamilla', 'franco@gmail.com', '4d186321c1a7f0f354b297e8914ab240', 1, '', '', 1, 1),
(14, 'Emanuel', 'Arce', 'Emanuel@gmail.com', 'f688ae26e9cfa3ba6235477831d5122e', 2, '', '', 1, 0),
(15, 'Andres', 'Mejia', 'andres@gmail.com', '4d186321c1a7f0f354b297e8914ab240', 2, '', '', 1, 0),
(16, 'Kevin', 'carrasco', 'kevin@gmail.com', '202cb962ac59075b964b07152d234b70', 1, '', 'dc12d93a9510d2eba1def374156b4710.png', 1, 0),
(17, 'Francisco', 'Padilla', 'padilla@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, '', '', 1, 0),
(18, 'Joel', 'Quezada', 'Quezada@gmail.com', '202cb962ac59075b964b07152d234b70', 2, '', '4de0ced98803e83d000f756578b9a0a5.png', 1, 0),
(19, 'Humberto', 'Sargent', 'Sargent1@gmail.com', '202cb962ac59075b964b07152d234b70', 1, '', 'b95c919b71bba5632a8504da8fa2ad24.png', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `codigo` varchar(32) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` double NOT NULL,
  `stock` int(11) NOT NULL,
  `archivo_n` varchar(255) NOT NULL,
  `archivo` varchar(128) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `eliminado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `codigo`, `descripcion`, `costo`, `stock`, `archivo_n`, `archivo`, `status`, `eliminado`) VALUES
(1, 'Teclado', '1', 'Teclado RGB ', 400, 19, '', 'cd66b6cc2c2afd8d7beede7d16e8ae15.jpg', 1, 1),
(2, 'Mouse RGB', '2', 'Mouse RGB ideal para jugadores', 200, 10, '', '2d2dc66088474f81f6c8bdbf2857d657.jpg', 1, 1),
(3, 'Computadora de oficina', '3', 'Computadora de oficina ideal para espacios reducidos', 3000, 10, '', '6d399319ed7ddf18e63b0f76a7721a6c.jpg', 1, 0),
(4, 'Mousepad', '123', 'Mousepad RGB', 200, 64, '', 'ecb907f9ef93661d4f1f3e572da16509.jpg', 1, 0),
(5, 'Teclado', '4', 'Teclado para computadora RGB', 600, 10, '', 'ecb907f9ef93661d4f1f3e572da16509.jpg', 1, 0),
(6, 'Camara para computadora', '56', 'Cámara para hacer llamadas', 250, 8, '', '6d399319ed7ddf18e63b0f76a7721a6c.jpg', 1, 1),
(7, 'Audifonos', '10', 'Audífonos RGB', 300, 8, '', '82768a7c419c96af1dd9a7cf44cc8e7d.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `archivo` varchar(64) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `eliminado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `promociones`
--

INSERT INTO `promociones` (`id`, `nombre`, `archivo`, `status`, `eliminado`) VALUES
(1, 'Audifonos RGB', '82768a7c419c96af1dd9a7cf44cc8e7d.jpg', 1, 0),
(2, 'Camara', '6d399319ed7ddf18e63b0f76a7721a6c.jpg', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
