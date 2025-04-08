

CREATE TABLE `cart_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `res_car_user` (`user_id`),
  KEY `res_car_product` (`product_id`),
  CONSTRAINT `res_car_product` FOREIGN KEY (`product_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `res_car_user` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4;




CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO categorias VALUES("4","Repuestos");



CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `res_user_cli` (`id_usuario`),
  CONSTRAINT `res_user_cli` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO cliente VALUES("5","Alan Borges","Venezolano","24569823","04125889632","2");
INSERT INTO cliente VALUES("6","Pablo Lopez","Venezolano","25478998","04123665879","2");



CREATE TABLE `dolar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `res_dol` (`id_usuario`),
  CONSTRAINT `res_dol` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

INSERT INTO dolar VALUES("4","70.00","2025-03-30 19:30:18","2");
INSERT INTO dolar VALUES("5","71.00","2025-03-30 19:43:50","2");
INSERT INTO dolar VALUES("6","70.00","2025-03-30 19:53:54","2");



CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `factura` int(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus` enum('pago','pendiente','cancelado','facturado') NOT NULL,
  `quantity` int(11) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_credi` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `res_product` (`product_id`),
  KEY `rest_client` (`cliente_id`),
  KEY `pedidos_ibfk_1` (`id_usuario`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `res_product` FOREIGN KEY (`product_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `rest_client` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;

INSERT INTO pedidos VALUES("50","3","2","7","5","2025-03-30 21:11:03","facturado","2","Debito","2025-03-30","2025-03-30");
INSERT INTO pedidos VALUES("54","4","2","7","6","2025-03-30 21:25:55","facturado","1","Efectivo","2025-03-30","2025-03-30");
INSERT INTO pedidos VALUES("57","5","2","6","5","2025-03-31 15:15:22","facturado","3","Divisa","2025-03-31","0000-00-00");
INSERT INTO pedidos VALUES("58","5","2","7","5","2025-03-31 15:15:22","facturado","3","Divisa","2025-03-31","0000-00-00");
INSERT INTO pedidos VALUES("61","7","2","6","5","2025-03-31 15:19:53","facturado","2","Transferencia","2025-03-31","0000-00-00");



CREATE TABLE `privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nucleo` varchar(100) NOT NULL,
  `descrip` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

INSERT INTO privileges VALUES("2","Pedidos","Listar los elementos del nucleo indicado","List");
INSERT INTO privileges VALUES("3","Pedidos","Modificar los elementos del nucleo indicado","Update");
INSERT INTO privileges VALUES("4","Pedidos","Realizar eliminaciones de registros en el indicado","Delete");
INSERT INTO privileges VALUES("5","Usuarios","Listar los elementos del nucleo indicado","List");
INSERT INTO privileges VALUES("6","Usuarios","Modificar los elementos del nucleo indicado","Update");
INSERT INTO privileges VALUES("7","Usuarios","Realizar eliminaciones de registros en el indicado","Delete");
INSERT INTO privileges VALUES("8","Dolar","Listar los elementos del nucleo indicado","List");
INSERT INTO privileges VALUES("9","Dolar","Modificar los elementos del nucleo indicado","Update");
INSERT INTO privileges VALUES("10","Dolar","Realizar eliminaciones de registros en el indicado","Delete");
INSERT INTO privileges VALUES("11","Producto","Listar los elementos del nucleo indicado","List");
INSERT INTO privileges VALUES("12","Producto","Modificar los elementos del nucleo indicado","Update");
INSERT INTO privileges VALUES("13","Producto","Realizar eliminaciones de registros en el indicado","Delete");
INSERT INTO privileges VALUES("14","Cliente","Listar los elementos del nucleo indicado","List");
INSERT INTO privileges VALUES("15","Cliente","Modificar los elementos del nucleo indicado","Update");
INSERT INTO privileges VALUES("16","Cliente","Realizar eliminaciones de registros en el indicado","Delete");



CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_barra` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus` varchar(50) DEFAULT NULL,
  `id_categorias` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_ubicacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `res_cat` (`id_categorias`),
  KEY `res_ub` (`id_ubicacion`),
  KEY `res_us` (`id_usuario`),
  CONSTRAINT `res_cat` FOREIGN KEY (`id_categorias`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `res_ub` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `res_us` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

INSERT INTO producto VALUES("5","N/A","Bomba Hidraulica","58.00","50.00","58","2025-04-04 15:47:31","habilitado","4","2","1");
INSERT INTO producto VALUES("6","N/A","Pastilla de freno","25.00","20.00","90","2025-03-31 15:19:03","habilitado","4","2","1");
INSERT INTO producto VALUES("7","N/A","Bujia ","10.00","20.00","19","2025-03-31 15:14:22","habilitado","4","2","1");
INSERT INTO producto VALUES("8","N/A","Amortiguador","52.00","50.00","54","2025-03-31 15:14:50","habilitado","4","2","1");
INSERT INTO producto VALUES("9","N/A","Silicon","10.00","25.00","10","2025-04-02 22:07:15","habilitado","4","6","1");



CREATE TABLE `ubicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO ubicacion VALUES("1","Estante A54");
INSERT INTO ubicacion VALUES("2","Almacen B8");
INSERT INTO ubicacion VALUES("3","Estante 5");
INSERT INTO ubicacion VALUES("4","Estante 2");
INSERT INTO ubicacion VALUES("5","Estante 58 B");



CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `tipo_usuario` varchar(50) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios VALUES("2","123456789","usuario@ejemplo.com","Nombre del usuario","d2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879","admin","activo");
INSERT INTO usuarios VALUES("3","1547896","alan255@gmail.com"," AlanRomgo ","d2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879","admin","activo");
INSERT INTO usuarios VALUES("4","25471388","alexandra@gmail.com","alexandra","d2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879","empleado","activo");
INSERT INTO usuarios VALUES("6","33255698","cigarron@gmail.com","Miguel Lugo","d2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879","admin","activo");
INSERT INTO usuarios VALUES("7","247896358","hola@gmail.com","Jose D","d2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879","empleado","activo");
INSERT INTO usuarios VALUES("8","27888585","altamirano@gmail.com","Black Dracula","d2922d5734e9479f5c31db726204133552459346f34734b9f3a04ff64e855879","empleado","activo");



CREATE TABLE `usuarios_has_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) NOT NULL,
  `id_privileges` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `res_privi` (`id_privileges`),
  KEY `res_user` (`id_usuarios`),
  CONSTRAINT `res_privi` FOREIGN KEY (`id_privileges`) REFERENCES `privileges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `res_user` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios_has_privileges VALUES("1","6","2");
INSERT INTO usuarios_has_privileges VALUES("2","6","3");
INSERT INTO usuarios_has_privileges VALUES("3","6","4");
INSERT INTO usuarios_has_privileges VALUES("4","6","5");
INSERT INTO usuarios_has_privileges VALUES("5","6","6");
INSERT INTO usuarios_has_privileges VALUES("6","6","7");
INSERT INTO usuarios_has_privileges VALUES("7","6","8");
INSERT INTO usuarios_has_privileges VALUES("8","6","9");
INSERT INTO usuarios_has_privileges VALUES("9","6","10");
INSERT INTO usuarios_has_privileges VALUES("10","6","11");
INSERT INTO usuarios_has_privileges VALUES("11","6","12");
INSERT INTO usuarios_has_privileges VALUES("13","6","14");
INSERT INTO usuarios_has_privileges VALUES("14","6","15");
INSERT INTO usuarios_has_privileges VALUES("15","6","16");
INSERT INTO usuarios_has_privileges VALUES("163","4","2");
INSERT INTO usuarios_has_privileges VALUES("164","4","3");
INSERT INTO usuarios_has_privileges VALUES("165","4","4");
INSERT INTO usuarios_has_privileges VALUES("166","4","5");
INSERT INTO usuarios_has_privileges VALUES("167","4","8");
INSERT INTO usuarios_has_privileges VALUES("168","4","9");
INSERT INTO usuarios_has_privileges VALUES("169","4","10");
INSERT INTO usuarios_has_privileges VALUES("170","4","11");
INSERT INTO usuarios_has_privileges VALUES("171","4","12");
INSERT INTO usuarios_has_privileges VALUES("172","4","13");
INSERT INTO usuarios_has_privileges VALUES("173","4","14");
INSERT INTO usuarios_has_privileges VALUES("174","4","15");
INSERT INTO usuarios_has_privileges VALUES("175","4","16");
INSERT INTO usuarios_has_privileges VALUES("176","8","3");
INSERT INTO usuarios_has_privileges VALUES("177","8","4");
INSERT INTO usuarios_has_privileges VALUES("178","8","5");
INSERT INTO usuarios_has_privileges VALUES("179","8","6");
INSERT INTO usuarios_has_privileges VALUES("180","8","7");
INSERT INTO usuarios_has_privileges VALUES("181","8","8");
INSERT INTO usuarios_has_privileges VALUES("182","8","9");
INSERT INTO usuarios_has_privileges VALUES("183","8","10");
INSERT INTO usuarios_has_privileges VALUES("184","8","11");
INSERT INTO usuarios_has_privileges VALUES("185","8","12");
INSERT INTO usuarios_has_privileges VALUES("186","8","13");
INSERT INTO usuarios_has_privileges VALUES("187","8","14");
INSERT INTO usuarios_has_privileges VALUES("188","8","15");
INSERT INTO usuarios_has_privileges VALUES("189","8","16");
INSERT INTO usuarios_has_privileges VALUES("190","3","2");
INSERT INTO usuarios_has_privileges VALUES("191","3","3");
INSERT INTO usuarios_has_privileges VALUES("192","3","4");
INSERT INTO usuarios_has_privileges VALUES("193","3","5");
INSERT INTO usuarios_has_privileges VALUES("194","3","6");
INSERT INTO usuarios_has_privileges VALUES("195","3","7");
INSERT INTO usuarios_has_privileges VALUES("196","3","8");
INSERT INTO usuarios_has_privileges VALUES("197","3","9");
INSERT INTO usuarios_has_privileges VALUES("198","3","10");
INSERT INTO usuarios_has_privileges VALUES("199","3","11");
INSERT INTO usuarios_has_privileges VALUES("200","3","12");
INSERT INTO usuarios_has_privileges VALUES("201","3","13");
INSERT INTO usuarios_has_privileges VALUES("202","3","14");
INSERT INTO usuarios_has_privileges VALUES("203","3","15");
INSERT INTO usuarios_has_privileges VALUES("204","3","16");



CREATE TABLE `usuarios_preguntas` (
  `id` int(11) NOT NULL,
  `fhint` varchar(100) NOT NULL,
  `fanswer` varchar(100) NOT NULL,
  `shint` varchar(100) NOT NULL,
  `sanswer` varchar(100) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  KEY `res_ans_user` (`id_usuarios`),
  CONSTRAINT `res_ans_user` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


