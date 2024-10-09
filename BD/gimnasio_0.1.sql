-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2024 a las 17:33:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gimnasio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `ci` varchar(20) NOT NULL,
  `fecha_registro` date NOT NULL,
  `dias_restantes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `ci`, `fecha_registro`, `dias_restantes`) VALUES
(1, 'David Fernando Lujan Renteria', '77134270', '10412291', '2024-01-29', 962),
(16, 'Latoya Herring', '(375)157-0890x0144', '774-65-4793', '2024-03-25', 78),
(18, 'Mal', '319-126-0172', '104122', '2023-11-08', 0),
(22, 'Tonya Daniel', '629-761-3440', '497-12-9027', '2023-09-28', 250),
(23, 'William Bryant', '066-139-1911x760', '725-65-4119', '2024-07-23', 145),
(24, 'Steven Thompson', '021-413-1597', '378-84-4382', '2023-10-07', 291),
(25, 'Mark Johnson', '598.486.9656', '807-34-2011', '2023-10-28', 102),
(26, 'Jonathan Anderson', '600.161.3427x5223', '558-27-0452', '2024-08-12', 299),
(27, 'Alexis Pierce', '(027)755-7729x56482', '244-18-5032', '2023-10-29', 313),
(28, 'Matthew Thompson', '(639)209-6157', '348-41-6174', '2024-06-21', 204),
(29, 'Elizabeth Brown', '(993)446-9282', '095-14-5272', '2024-07-14', 161),
(30, 'Douglas Reed', '(141)165-4301', '841-21-3614', '2023-09-29', 150),
(31, 'Vincent Rodriguez', '(621)440-1512x6555', '778-83-0496', '2023-12-09', 294),
(32, 'Margaret Bennett', '001-282-660-3800', '667-31-2149', '2023-11-26', 138),
(33, 'Brandon Mcclain', '364.195.7100x58745', '145-91-3944', '2024-02-08', 289),
(34, 'Erin West', '251.641.8913x2354', '761-77-9278', '2023-11-30', 29),
(35, 'Katherine Rose', '001-163-785-4305x258', '805-96-8491', '2024-02-28', 309),
(36, 'Carlos Harris', '490.307.5417x6284', '467-21-5732', '2023-11-07', 86),
(37, 'Joann Jones', '(432)177-8259', '573-83-1960', '2024-07-11', 60),
(38, 'Calvin Garrett', '221-736-4712x7097', '811-79-3469', '2023-12-06', 293),
(39, 'Eric Mason', '344.065.0659x03585', '732-26-1575', '2023-09-27', 231),
(40, 'Martin Chambers', '049-085-6932x9947', '513-86-6179', '2024-07-24', 59),
(41, 'Victoria Salazar', '434.899.0674x49712', '825-54-9415', '2024-03-30', 208),
(42, 'Tiffany Guerrero', '(816)641-8317x4930', '550-49-0863', '2024-07-18', 291),
(43, 'Brian Foster', '914.785.4464', '314-66-5312', '2024-01-01', 284),
(44, 'Gloria George', '001-751-142-6445x105', '554-89-3069', '2024-01-21', 102),
(45, 'Kathleen Wilson', '(682)203-0174', '822-64-0620', '2024-06-29', 275),
(46, 'Krista Pearson', '001-305-275-3801', '887-71-0196', '2023-11-25', 222),
(47, 'Taylor Martin', '479-992-0102x425', '459-96-1973', '2024-08-01', 71),
(48, 'Margaret West', '001-612-028-9452x488', '142-83-7426', '2023-10-21', 182),
(49, 'Rita Murphy', '001-540-345-5861x029', '682-91-2710', '2024-01-02', 244),
(51, 'dfswdsa', '1111', '11111', '2024-09-27', 0),
(52, 'dsdsa', '1111', '11111', '2024-09-27', 0),
(53, 'cxacs', '1111', '1111', '2024-09-27', 0),
(54, 'Minus sit ut et rem ', 'Sed culpa magna magn', 'Consequatur eos in ', '2024-09-27', 0),
(55, 'Minus sit ut et rem ', 'Sed culpa magna magn', 'Consequatur eos in ', '2024-09-27', 0),
(56, 'Et dolore ipsa poss', 'Rerum eligendi dolor', 'Eaque aliqua Omnis ', '2024-09-27', 0),
(57, 'Dicta est at dolori', 'Sint mollitia id o', 'Est ea amet ex et', '2024-09-27', 0),
(58, 'Officia quaerat moll', 'Elit corporis nisi ', 'Elit beatae a ut in', '2024-09-27', 365),
(59, 'dsadsadsadsadsa', 'Elit corporis nisi ', 'Elit beatae a ut in', '2024-09-27', 365),
(60, 'Renteria', '11111111111111122222', '999999999999999', '2024-09-27', 365),
(61, '00000', '00000', '00000', '2024-09-27', 365),
(62, '00000', '00000', '00000', '2024-09-27', 30),
(63, 'Et magna ut in dolor', 'Est sed est magnam d', 'Tempor eaque dolor e', '2024-09-28', 30),
(64, 'Adipisicing veritati', 'Ipsam ipsam laborios', 'Reiciendis voluptas ', '2024-09-28', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_suscripcion`
--

CREATE TABLE `planes_suscripcion` (
  `id_plan` int(11) NOT NULL,
  `nombre_plan` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion` int(11) NOT NULL,
  `estado_plan` varchar(50) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes_suscripcion`
--

INSERT INTO `planes_suscripcion` (`id_plan`, `nombre_plan`, `descripcion`, `precio`, `duracion`, `estado_plan`, `imagen`) VALUES
(1, 'Plan Básico 2024', 'Acceso ilimitado a todas las instalaciones básicas', 10.99, 300, 'activo', 'plan1.jpg'),
(2, 'Plan Premium', 'Acceso ilimitado a todas las instalaciones, incluidos spas y saunas', 29.99, 30, 'activo', 'plan2.jpg'),
(3, 'Plan Anual', 'Acceso durante un año con un descuento', 300.00, 365, 'activo', 'plan3.jpg'),
(4, 'Plan Familiar', 'Acceso para hasta 4 miembros de la familia', 50.00, 30, 'activo', 'plan4.jpg'),
(5, 'Plan Estudiantil', 'Precio reducido para estudiantes', 5.99, 30, 'inactivo', 'plan5.jpg'),
(6, 'Facere illum nisi l', 'Amet perspiciatis ', 83.00, 42, 'inactivo', 'Capture001.png'),
(7, 'Quisquam odit dolore', 'Tenetur consequatur', 37.00, 10, 'inactivo', 'Capture001.png'),
(8, 'Excepteur necessitat', 'Libero qui consequun', 23.00, 94, 'inactivo', 'Capture001.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

CREATE TABLE `suscripciones` (
  `id_suscripcion` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `tipo_pago` varchar(50) NOT NULL,
  `usuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suscripciones`
--

INSERT INTO `suscripciones` (`id_suscripcion`, `id_cliente`, `id_plan`, `tipo_pago`, `usuario`) VALUES
(9, 58, 3, 'efectivo', 'root'),
(10, 59, 3, 'efectivo', 'root'),
(11, 60, 3, 'efectivo', 'root'),
(12, 61, 3, 'efectivo', 'root'),
(13, 62, 1, 'qr', 'root'),
(14, 1, 2, 'efectivo', 'root'),
(15, 1, 3, 'efectivo', 'root'),
(16, 1, 6, 'qr', 'Juan'),
(17, 63, 1, 'qr', 'root'),
(18, 1, 6, 'efectivo', 'root'),
(19, 64, 2, 'efectivo', 'root'),
(20, 1, 3, 'efectivo', 'root'),
(21, 1, 3, 'efectivo', 'root');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `password` char(40) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password`, `rol`) VALUES
(3, 'root', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', 'root'),
(4, 'Juan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Empleado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `planes_suscripcion`
--
ALTER TABLE `planes_suscripcion`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indices de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD PRIMARY KEY (`id_suscripcion`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_plan` (`id_plan`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `planes_suscripcion`
--
ALTER TABLE `planes_suscripcion`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  MODIFY `id_suscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD CONSTRAINT `suscripciones_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `suscripciones_ibfk_2` FOREIGN KEY (`id_plan`) REFERENCES `planes_suscripcion` (`id_plan`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `actualizarDiasRestantes` ON SCHEDULE EVERY 1 DAY STARTS '2023-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE clientes
  SET dias_restantes = dias_restantes - 1
  WHERE dias_restantes > 0$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
