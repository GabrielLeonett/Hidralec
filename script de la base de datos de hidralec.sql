-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 00:46:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hidralec`
--
CREATE DATABASE IF NOT EXISTS `hidralec` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hidralec`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(15) NOT NULL,
  `Nombre_Categoria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_ventas`
--

CREATE TABLE `detalles_ventas` (
  `ID_Ventas` varchar(10) NOT NULL,
  `Precio_Unitario` int(10) NOT NULL,
  `ID_Detalles_Venta` varchar(10) NOT NULL,
  `ID_Productos` int(10) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_ventas`
--

INSERT INTO `detalles_ventas` (`ID_Ventas`, `Precio_Unitario`, `ID_Detalles_Venta`, `ID_Productos`, `Cantidad`) VALUES
('5cc4e80d03', 5, '189e23413b', 29, 3),
('5cc4e80d03', 50, '38e8b47ec6', 26, 2),
('bda894acb7', 15, '429', 24, 2),
('5cc4e80d03', 5, '432e2699df', 27, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `Estado` text NOT NULL,
  `Municipio` text NOT NULL,
  `Sector_o_urbanizacion` text NOT NULL,
  `Calle_o_edifcio` text NOT NULL,
  `Casa_o_apartamento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `ID_Empleados` int(15) NOT NULL,
  `Nombre_Empleado` text NOT NULL,
  `Apellido_Empleado` text NOT NULL,
  `Cargo` text NOT NULL,
  `Correo_Empleado` varchar(20) NOT NULL,
  `Telefono_Empleado` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_venta`
--

CREATE TABLE `estado_venta` (
  `ID_Estado_Venta` int(15) NOT NULL,
  `Estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_venta`
--

INSERT INTO `estado_venta` (`ID_Estado_Venta`, `Estado`) VALUES
(1, 'Pendiente'),
(2, 'Rechazado'),
(3, 'Confirmado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `N_Referencia` int(15) NOT NULL,
  `Pago` int(15) NOT NULL,
  `Fecha` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_Productos` int(15) NOT NULL,
  `ID_Proveedores` int(15) NOT NULL,
  `Nombre_Productos` text NOT NULL,
  `Descripcion_Producto` text NOT NULL,
  `Precio` varchar(20) NOT NULL,
  `Stock` int(150) NOT NULL,
  `Areas de uso` text NOT NULL,
  `DIr_Imagen` varchar(200) NOT NULL,
  `Carrusel_Productos` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_Productos`, `ID_Proveedores`, `Nombre_Productos`, `Descripcion_Producto`, `Precio`, `Stock`, `Areas de uso`, `DIr_Imagen`, `Carrusel_Productos`) VALUES
(23, 0, 'pala', 'Es una herramienta básica de jardinería, formada por una lámina metálica, levemente curvada y un mango de madera para manejarla. Se usa paracavar la tierra, excavar hoyos de plantación o trasladar el sustrato.', '12', 10, 'contruccion', 'pala_1729864397.jpg', 1),
(24, 0, 'pico', 'Los picos son herramientas de mano utilizadas principalmente en la construcción para romper superficies no muy duras, en las fundiciones de hierro o en trabajos de soldadura para eliminar rebabas de distinto tamaño y dureza.', '15', 18, 'contruccion', 'descarga (1)_1729895862.jpg', 1),
(25, 0, 'Pintura Montana', 'La pintura es el arte de la representación gráfica utilizando pigmentos mezclados con otras sustancias aglutinantes orgánicas o sintéticas. En este arte se emplean técnicas de pintura, conocimientos de teoría del color y de composición pictórica, y el dibujo.', '30', 5, 'Construccion', 'pintura_1729898971.jpg', 0),
(26, 0, 'Bomba de agua', 'Una bomba de agua es una herramienta vital para asegurar el suministro y distribución de agua en hogares, edificios, agricultura y en la industria en general. Con ella, se puede extraer agua de pozos profundos y moverla a través de tuberías o mangueras hasta lugares donde se requiere su uso.', '50', 1, 'Agricultura', 'bomba_1729899054.jpg', 0),
(27, 0, 'Destornillador', 'Un destornillador es una herramienta que se utiliza para apretar y aflojar tornillos y otros elementos de máquinas que requieren poca fuerza de apriete', '5', 8, 'Todas, carpinteria', 'destornillador.jpg', 0),
(28, 0, 'Tornillo', 'El tornillo es una pieza metálica que tiene como función unir dos o más elementos.', '12', 15, 'Carpinteria', 'tornillo.jpg', 1),
(29, 0, 'Bombillo | LED', 'Se trata de un cuerpo semiconductor sólido de gran resistencia que, al recibir una corriente eléctrica de muy baja intensidad, emite luz de forma eficiente y con alto rendimiento.', '5', 97, 'Todas, Hogar', 'bombillo.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `ID_Proveedores` int(15) NOT NULL,
  `Nombre_Proveedores` text NOT NULL,
  `Correo` varchar(30) NOT NULL,
  `Telefono` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(15) NOT NULL,
  `Nombre_Usuario` varchar(60) NOT NULL,
  `Correo_Usuario` varchar(80) NOT NULL,
  `Usuario_Usuario` varchar(60) NOT NULL,
  `Password_Usuario` varchar(60) NOT NULL,
  `Permisos_Usuario` varchar(15) NOT NULL DEFAULT 'Cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre_Usuario`, `Correo_Usuario`, `Usuario_Usuario`, `Password_Usuario`, `Permisos_Usuario`) VALUES
(2, 'Gabriel Leonett', 'Gabrielleonett@gmail.com', 'Gabriel12', '$2y$10$snyHuIiFArc0j6.4.Zar7e/FEZSmkV3/I6yEqvvZ0NAdfQH.lf/Yy', 'Cliente'),
(3, 'Lourdes Leonett', 'leonettlourdes@gmail.com', 'LourdesLeonett', '$2y$10$snyHuIiFArc0j6.4.Zar7e/FEZSmkV3/I6yEqvvZ0NAdfQH.lf/Yy', 'Cliente'),
(4, 'Manuel Goncalves', 'Hidralec@gmail.com', 'Admin1', '$2y$10$snyHuIiFArc0j6.4.Zar7e/FEZSmkV3/I6yEqvvZ0NAdfQH.lf/Yy', 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `ID_Ventas` varchar(10) NOT NULL,
  `Monto_total` int(10) NOT NULL,
  `ID_Usuario` int(15) NOT NULL,
  `Fecha` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `ID_Estado_Venta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`ID_Ventas`, `Monto_total`, `ID_Usuario`, `Fecha`, `ID_Estado_Venta`) VALUES
('5cc4e80d03', 125, 2, '2024-11-04 23:04:47.079826', 3),
('bda894acb7', 30, 2, '2024-10-28 23:03:03.251971', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  ADD PRIMARY KEY (`ID_Detalles_Venta`),
  ADD KEY `ID_Productos` (`ID_Productos`),
  ADD KEY `ID_Ventas` (`ID_Ventas`);

--
-- Indices de la tabla `estado_venta`
--
ALTER TABLE `estado_venta`
  ADD PRIMARY KEY (`ID_Estado_Venta`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_Productos`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`ID_Ventas`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Estado_Venta` (`ID_Estado_Venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_Productos` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_ventas`
--
ALTER TABLE `detalles_ventas`
  ADD CONSTRAINT `detalles_ventas_ibfk_2` FOREIGN KEY (`ID_Productos`) REFERENCES `productos` (`ID_Productos`),
  ADD CONSTRAINT `detalles_ventas_ibfk_3` FOREIGN KEY (`ID_Ventas`) REFERENCES `ventas` (`ID_Ventas`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`ID_Estado_Venta`) REFERENCES `estado_venta` (`ID_Estado_Venta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
