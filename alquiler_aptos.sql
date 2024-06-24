

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



--

CREATE TABLE `apartamentos` (
  `id_apartamento` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `tipo_apartamento` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `id_tarifa` int(11) NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `apartamentos` (`id_apartamento`, `nombre`, `direccion`, `tipo_apartamento`, `id_ciudad`, `id_tarifa`, `imagen`) VALUES
(1, 'edificio milano plaza', 'calle false 1 # 2', 1, 1, 5, 'https://www.decorfacil.com/wp-content/uploads/2017/09/20170907decoracao-de-apartamento-47.jpg');


CREATE TABLE `ciudades` (
  `id_ciudad` int(11) NOT NULL,
  `nombre` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `ciudades` (`id_ciudad`, `nombre`) VALUES
(1, 'madrid'),
(2, 'malaga'),
(3, 'madrid'),
(4, 'malaga');


CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `clientes` (`id_cliente`, `nombre`, `email`) VALUES
(1, 'santiago morales', 'santiago@gmail.com');



CREATE TABLE `reservas` (
  `id_reserva` varchar(4) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `apartamento` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `alquiler` int(11) NOT NULL,
  `tasa_servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `reservas` (`id_reserva`, `fecha_inicio`, `fecha_fin`, `apartamento`, `cliente`, `alquiler`, `tasa_servicio`) VALUES
('', '2024-06-14', '2024-07-04', 1, 1, 0, 0),
('bfbc', '2023-06-01', '2023-07-10', 1, 1, 3900, 117);


CREATE TABLE `tarifas` (
  `id_tarifa` int(11) NOT NULL,
  `id_tipo_tarifa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `tipo_tarifa` (
  `id_tipo_tarifa` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `fecha_inicio` int(11) NOT NULL,
  `fecha_fin` int(11) NOT NULL,
  `valor_tarifa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `tipo_tarifa` (`id_tipo_tarifa`, `name`, `fecha_inicio`, `fecha_fin`, `valor_tarifa`) VALUES
(5, 'Primavera', 3, 6, 100),
(6, 'Verano', 6, 9, 150),
(7, 'Otoño', 9, 12, 120),
(8, 'Invierno', 12, 3, 80);


ALTER TABLE `apartamentos`
  ADD PRIMARY KEY (`id_apartamento`),
  ADD KEY `tipo_apartamento` (`tipo_apartamento`,`id_ciudad`,`id_tarifa`),
  ADD KEY `id_ciudad` (`id_ciudad`),
  ADD KEY `apartamentos_ibfk_2` (`id_tarifa`);


ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id_ciudad`);


ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);


ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `apartamento` (`apartamento`),
  ADD KEY `cliente` (`cliente`);


ALTER TABLE `tarifas`
  ADD PRIMARY KEY (`id_tarifa`),
  ADD KEY `id_aparamento` (`id_tipo_tarifa`);


ALTER TABLE `tipo_tarifa`
  ADD PRIMARY KEY (`id_tipo_tarifa`);


ALTER TABLE `apartamentos`
  MODIFY `id_apartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `ciudades`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `tarifas`
  MODIFY `id_tarifa` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `tipo_tarifa`
  MODIFY `id_tipo_tarifa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


ALTER TABLE `apartamentos`
  ADD CONSTRAINT `apartamentos_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id_ciudad`),
  ADD CONSTRAINT `apartamentos_ibfk_2` FOREIGN KEY (`id_tarifa`) REFERENCES `tipo_tarifa` (`id_tipo_tarifa`);


ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`apartamento`) REFERENCES `apartamentos` (`id_apartamento`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;






------------------------------------CONSULTAS ---------------

----12. SQL para obtener todas las reservas activas, donde se indique código de reserva, fecha de inicio y fecha final de la reserva, nombre del apartamento y nombre del cliente:


SELECT r.id_reserva, r.fecha_inicio, r.fecha_fin, a.nombre AS nombre_apartamento, c.nombre AS nombre_cliente
FROM reservas r
INNER JOIN apartamentos a ON r.apartamento = a.id_apartamento
INNER JOIN clientes c ON r.cliente = c.id_cliente
WHERE r.fecha_fin >= CURDATE();











------------13. SQL para obtener los datos de los clientes cuyo apellido comience por “C” y que hayan realizado más de 2 reservas:





SELECT c.nombre, c.apellido, c.email
FROM clientes c
INNER JOIN (
    SELECT cliente, COUNT(*) AS cantidad_reservas
    FROM reservas
    GROUP BY cliente
    HAVING cantidad_reservas > 2
) r ON c.id_cliente = r.cliente
WHERE c.apellido LIKE 'C%';





--------------------14. SQL para obtener el nombre, apellido y email de los clientes que realizaron reservas hoy (en orden alfabético):





SELECT DISTINCT c.nombre, c.apellido, c.email
FROM clientes c
INNER JOIN reservas r ON c.id_cliente = r.cliente
WHERE DATE(r.fecha_inicio) = CURDATE()
ORDER BY c.nombre, c.apellido;










------15. SQL para obtener el nombre del apartamento turístico que tenga más días reservados:




SELECT a.nombre AS nombre_apartamento
FROM reservas r
INNER JOIN apartamentos a ON r.apartamento = a.id_apartamento
WHERE a.tipo_apartamento = 1 
GROUP BY r.apartamento
ORDER BY SUM(DATEDIFF(r.fecha_fin, r.fecha_inicio) + 1) DESC
LIMIT 1;
