-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2020 a las 19:00:08
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas`
--

CREATE TABLE `bebidas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(35) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `contador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bebidas`
--

INSERT INTO `bebidas` (`id`, `created_at`, `updated_at`, `nombre`, `precio`, `contador`) VALUES
(1, '2020-12-15 00:23:58', '2020-12-15 06:38:53', 'Campari', 100, 1),
(2, '2020-12-15 00:24:10', '2020-12-15 15:45:44', 'Fernet', 110, 1),
(3, '2020-12-15 00:25:06', '2020-12-15 17:47:34', 'Whiskey', 250, 3),
(4, '2020-12-15 00:25:48', '2020-12-15 00:25:48', 'Cynar', 180, 0),
(5, '2020-12-15 00:26:53', '2020-12-15 15:36:33', 'Vino', 140, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cervezas`
--

CREATE TABLE `cervezas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(35) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `contador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cervezas`
--

INSERT INTO `cervezas` (`id`, `created_at`, `updated_at`, `nombre`, `precio`, `contador`) VALUES
(1, '2020-12-15 00:29:49', '2020-12-15 13:25:01', 'Quilmes', 100, 3),
(2, '2020-12-15 00:30:01', '2020-12-15 00:30:01', 'Stella', 150, 0),
(3, '2020-12-15 00:30:15', '2020-12-15 00:30:15', 'IPA de la casa', 150, 0),
(4, '2020-12-15 00:30:33', '2020-12-15 17:47:34', 'Bolson', 160, 1),
(6, '2020-12-15 00:33:00', '2020-12-15 15:36:33', 'Antares', 200, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(35) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `contador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`id`, `created_at`, `updated_at`, `nombre`, `precio`, `contador`) VALUES
(1, '2020-12-15 00:34:05', '2020-12-15 00:34:05', 'Asado para 4', 1800, 0),
(2, '2020-12-15 00:35:09', '2020-12-15 00:35:09', 'Matambre de cerdo con papas', 1100, 0),
(3, '2020-12-15 00:35:45', '2020-12-15 17:47:34', 'Hamburguesa', 600, 5),
(4, '2020-12-15 00:36:08', '2020-12-15 15:45:44', 'Salmon con Salsa Blanca', 950, 1),
(5, '2020-12-15 00:36:28', '2020-12-15 15:36:33', 'Pizza Muzza', 550, 3),
(6, '2020-12-15 00:36:41', '2020-12-15 00:36:41', 'Volcan de chocolate', 450, 0),
(7, '2020-12-15 00:37:17', '2020-12-15 00:37:17', 'Tiramisu', 350, 0),
(8, '2020-12-15 00:37:30', '2020-12-15 00:37:30', 'Flan Casero', 330, 0),
(9, '2020-12-15 00:37:42', '2020-12-15 00:38:42', 'Bombon Helado', 220, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cod_pedido` varchar(7) DEFAULT NULL,
  `puntaje` int(11) DEFAULT NULL,
  `comentario` varchar(66) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `created_at`, `updated_at`, `cod_pedido`, `puntaje`, `comentario`) VALUES
(1, '2020-12-15 17:35:19', '2020-12-15 17:35:19', 'P-UP21N', 33, 'Todo muy lindo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `codigo` varchar(5) DEFAULT NULL,
  `estado` int(1) DEFAULT NULL,
  `contador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `created_at`, `updated_at`, `codigo`, `estado`, `contador`) VALUES
(1, '2020-12-15 02:28:36', '2020-12-15 17:42:11', '12345', 1, 8),
(4, '2020-12-15 02:38:35', '2020-12-15 17:47:34', '23456', 1, 7),
(5, '2020-12-15 02:38:43', '2020-12-15 15:45:44', '34567', 1, 3),
(6, '2020-12-15 02:38:53', '2020-12-15 14:12:35', '45678', 4, 2),
(7, '2020-12-15 02:38:59', '2020-12-15 06:38:56', '56789', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `codigo` varchar(7) DEFAULT NULL,
  `id_usuario` int(8) DEFAULT NULL,
  `cod_bebida` int(4) DEFAULT NULL,
  `cod_cerveza` int(4) DEFAULT NULL,
  `cod_comida` int(4) DEFAULT NULL,
  `nombre_cliente` varchar(25) DEFAULT NULL,
  `estado` int(2) DEFAULT NULL,
  `cod_mesa` int(5) DEFAULT NULL,
  `tiempo_estimado` int(3) DEFAULT NULL,
  `tiempo_restante` int(3) DEFAULT NULL,
  `tiempo_entrega` int(3) DEFAULT NULL,
  `costo` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `created_at`, `updated_at`, `codigo`, `id_usuario`, `cod_bebida`, `cod_cerveza`, `cod_comida`, `nombre_cliente`, `estado`, `cod_mesa`, `tiempo_estimado`, `tiempo_restante`, `tiempo_entrega`, `costo`) VALUES
(19, '2020-12-15 13:27:53', '2020-12-15 17:36:42', 'P-UP21N', 8, 5, NULL, 5, NULL, 3, 23456, 41, 41, 49, 690),
(20, '2020-12-15 14:12:49', '2020-12-15 17:40:58', 'P-A48DJ', 8, 5, 6, 5, NULL, 3, 12345, 29, 29, 32, 890),
(21, '2020-12-15 15:36:33', '2020-12-15 15:36:54', 'P-J2FV6', 8, 5, 6, 5, NULL, 3, 23456, 12, 12, 32, 890),
(22, '2020-12-15 15:45:44', '2020-12-15 15:55:35', 'P-SNP6L', 8, 2, NULL, 4, NULL, 4, 34567, 48, 48, 37, 1060),
(23, '2020-12-15 17:42:11', '2020-12-15 17:42:40', 'P-D837A', 8, 3, NULL, 3, NULL, 3, 12345, 47, 0, 43, 850),
(24, '2020-12-15 17:47:34', '2020-12-15 17:47:34', 'P-OHSEN', 8, 3, 4, 3, 'Rene', 1, 23456, 15, 15, 47, 1010);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre` varchar(25) DEFAULT NULL,
  `tipo` varchar(25) DEFAULT NULL,
  `clave` int(11) DEFAULT NULL,
  `contador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `created_at`, `updated_at`, `nombre`, `tipo`, `clave`, `contador`) VALUES
(1, '2020-12-14 05:21:54', '2020-12-14 05:21:54', 'Tomas', 'socios', 1234, 0),
(2, '2020-12-14 05:23:59', '2020-12-14 05:23:59', 'Jose', 'socios', 1212, 0),
(3, '2020-12-14 05:25:26', '2020-12-15 17:42:40', 'Ricardo', 'bartender', 5678, 7),
(4, '2020-12-14 05:26:10', '2020-12-14 05:26:10', 'Maximiliano', 'cerveceros', 5656, 0),
(5, '2020-12-14 05:26:35', '2020-12-14 05:26:35', 'Miguel', 'cocineros', 1010, 0),
(6, '2020-12-14 05:26:50', '2020-12-14 05:26:50', 'Eduardo', 'cocineros', 1015, 0),
(7, '2020-12-14 05:27:13', '2020-12-14 05:27:13', 'Agustin', 'mozos', 1019, 0),
(8, '2020-12-14 05:27:27', '2020-12-15 17:47:34', 'Sebastian', 'mozos', 4411, 8),
(9, '2020-12-14 05:32:01', '2020-12-14 05:32:01', 'Alejandro', 'socios', 4499, 0),
(10, '2020-12-14 23:38:35', '2020-12-14 23:58:55', 'Santino', 'bartender', 8877, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cervezas`
--
ALTER TABLE `cervezas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cervezas`
--
ALTER TABLE `cervezas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comidas`
--
ALTER TABLE `comidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
