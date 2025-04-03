-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2025 a las 23:28:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `binnacle`
--

CREATE TABLE `binnacle` (
  `id` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `table_item` varchar(100) NOT NULL,
  `action` varchar(100) NOT NULL,
  `new_data` varchar(100) NOT NULL,
  `old_data` varchar(100) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `nucleo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_menu`
--

CREATE TABLE `cart_menu` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(4, 'Repuestos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `tipo`, `cedula`, `telefono`, `id_usuario`) VALUES
(5, 'Alan Borges', 'Venezolano', '24569823', '04125889632', 2),
(6, 'Pablo Lopez', 'Venezolano', '25478998', '04123665879', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dolar`
--

CREATE TABLE `dolar` (
  `id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dolar`
--

INSERT INTO `dolar` (`id`, `valor`, `fecha`, `id_usuario`) VALUES
(4, '70.00', '2025-03-30 23:30:18', 2),
(5, '71.00', '2025-03-30 23:43:50', 2),
(6, '70.00', '2025-03-30 23:53:54', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `factura` int(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus` enum('pago','pendiente','cancelado','facturado') NOT NULL,
  `quantity` int(11) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_credi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `factura`, `id_usuario`, `product_id`, `cliente_id`, `modified`, `estatus`, `quantity`, `metodo`, `fecha`, `fecha_credi`) VALUES
(50, 3, 2, 7, 5, '2025-03-31 01:11:03', 'facturado', 2, 'Debito', '2025-03-30', '2025-03-30'),
(54, 4, 2, 7, 6, '2025-03-31 01:25:55', 'facturado', 1, 'Efectivo', '2025-03-30', '2025-03-30'),
(57, 5, 2, 6, 5, '2025-03-31 19:15:22', 'facturado', 3, 'Divisa', '2025-03-31', NULL),
(58, 5, 2, 7, 5, '2025-03-31 19:15:22', 'facturado', 3, 'Divisa', '2025-03-31', NULL),
(61, 7, 2, 6, 5, '2025-03-31 19:19:53', 'facturado', 2, 'Transferencia', '2025-03-31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `nucleo` varchar(100) NOT NULL,
  `descrip` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `privileges`
--

INSERT INTO `privileges` (`id`, `nucleo`, `descrip`, `name`) VALUES
(2, 'Pedidos', 'Listar los elementos del nucleo indicado', 'List'),
(3, 'Pedidos', 'Modificar los elementos del nucleo indicado', 'Update'),
(4, 'Pedidos', 'Realizar eliminaciones de registros en el indicado', 'Delete'),
(5, 'Usuarios', 'Listar los elementos del nucleo indicado', 'List'),
(6, 'Usuarios', 'Modificar los elementos del nucleo indicado', 'Update'),
(7, 'Usuarios', 'Realizar eliminaciones de registros en el indicado', 'Delete'),
(8, 'Dolar', 'Listar los elementos del nucleo indicado', 'List'),
(9, 'Dolar', 'Modificar los elementos del nucleo indicado', 'Update'),
(10, 'Dolar', 'Realizar eliminaciones de registros en el indicado', 'Delete'),
(11, 'Producto', 'Listar los elementos del nucleo indicado', 'List'),
(12, 'Producto', 'Modificar los elementos del nucleo indicado', 'Update'),
(13, 'Producto', 'Realizar eliminaciones de registros en el indicado', 'Delete'),
(14, 'Cliente', 'Listar los elementos del nucleo indicado', 'List'),
(15, 'Cliente', 'Modificar los elementos del nucleo indicado', 'Update'),
(16, 'Cliente', 'Realizar eliminaciones de registros en el indicado', 'Delete');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `cod_barra` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus` varchar(50) DEFAULT NULL,
  `id_categorias` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `cod_barra`, `nombre`, `precio`, `porcentaje`, `stock`, `modified`, `estatus`, `id_categorias`, `id_usuario`, `id_ubicacion`) VALUES
(5, 'N/A', 'Bomba Hidraulica', '58.00', '50.00', 12, '2025-03-31 19:43:54', 'habilitado', 4, 2, 1),
(6, 'N/A', 'Pastilla de freno', '25.00', '20.00', 90, '2025-03-31 19:19:03', 'habilitado', 4, 2, 1),
(7, 'N/A', 'Bujia ', '10.00', '20.00', 19, '2025-03-31 19:14:22', 'habilitado', 4, 2, 1),
(8, 'N/A', 'Amortiguador', '52.00', '50.00', 54, '2025-03-31 19:14:50', 'habilitado', 4, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `nombre`) VALUES
(1, 'Estante A54'),
(2, 'Almacen B8'),
(3, 'Estante 5'),
(4, 'Estante 2'),
(5, 'Estante 58 B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `tipo_usuario` varchar(50) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `correo`, `nombre`, `clave`, `tipo_usuario`, `estatus`) VALUES
(2, '123456789', 'usuario@ejemplo.com', 'Nombre del usuario', 'd2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879', 'admin', 'activo'),
(3, '1547896', 'alan@gmail.com', 'AlanRomgo', 'd2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879', 'empleado', 'activo'),
(4, '25471388', 'alexandra@gmail.com', 'alexandra', 'd2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879', 'empleado', 'activo'),
(6, '33255698', 'cigarron@gmail.com', 'Miguel Lugo', 'd2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879', 'empleado', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_has_privileges`
--

CREATE TABLE `usuarios_has_privileges` (
  `id` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `id_privileges` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios_has_privileges`
--

INSERT INTO `usuarios_has_privileges` (`id`, `id_usuarios`, `id_privileges`) VALUES
(1, 6, 2),
(2, 6, 3),
(3, 6, 4),
(4, 6, 5),
(5, 6, 6),
(6, 6, 7),
(7, 6, 8),
(8, 6, 9),
(9, 6, 10),
(10, 6, 11),
(11, 6, 12),
(12, 6, 13),
(13, 6, 14),
(14, 6, 15),
(15, 6, 16);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `binnacle`
--
ALTER TABLE `binnacle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart_menu`
--
ALTER TABLE `cart_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_car_user` (`user_id`),
  ADD KEY `res_car_product` (`product_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_user_cli` (`id_usuario`);

--
-- Indices de la tabla `dolar`
--
ALTER TABLE `dolar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_dol` (`id_usuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_product` (`product_id`),
  ADD KEY `rest_client` (`cliente_id`),
  ADD KEY `pedidos_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_cat` (`id_categorias`),
  ADD KEY `res_ub` (`id_ubicacion`),
  ADD KEY `res_us` (`id_usuario`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_has_privileges`
--
ALTER TABLE `usuarios_has_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `res_privi` (`id_privileges`),
  ADD KEY `res_user` (`id_usuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `binnacle`
--
ALTER TABLE `binnacle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cart_menu`
--
ALTER TABLE `cart_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `dolar`
--
ALTER TABLE `dolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios_has_privileges`
--
ALTER TABLE `usuarios_has_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart_menu`
--
ALTER TABLE `cart_menu`
  ADD CONSTRAINT `res_car_product` FOREIGN KEY (`product_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_car_user` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `res_user_cli` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `dolar`
--
ALTER TABLE `dolar`
  ADD CONSTRAINT `res_dol` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_product` FOREIGN KEY (`product_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rest_client` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `res_cat` FOREIGN KEY (`id_categorias`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_ub` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_us` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_has_privileges`
--
ALTER TABLE `usuarios_has_privileges`
  ADD CONSTRAINT `res_privi` FOREIGN KEY (`id_privileges`) REFERENCES `privileges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `res_user` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
