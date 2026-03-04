-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2026 a las 14:39:11
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
-- Base de datos: `livethefe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_banners`
--

CREATE TABLE `tbl_banners` (
  `ID` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_banners`
--

INSERT INTO `tbl_banners` (`ID`, `titulo`, `descripcion`, `link`) VALUES
(2, 'LiveTheFe', 'Sistema de trazabilidad y control para producción', '#menu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_colaboradores`
--

CREATE TABLE `tbl_colaboradores` (
  `ID` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `linkfacebook` varchar(255) NOT NULL,
  `linkinstagram` varchar(255) NOT NULL,
  `linklinkedin` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_colaboradores`
--

INSERT INTO `tbl_colaboradores` (`ID`, `titulo`, `descripcion`, `linkfacebook`, `linkinstagram`, `linklinkedin`, `foto`) VALUES
(24, 'Operario de cannabis', 'Encargado de apoyar en el cultivo y procesamiento de la planta bajo normas legales y de calidad. Sus funciones incluyen el cuidado de los cultivos, la cosecha, el mantenimiento de espacios de trabajo y el cumplimiento de protocolos de seguridad.        ', 'https://www.facebook.com/ProyectoTime', 'https://www.instagram.com/time_codeman/?hl=es-la', 'https://www.linkedin.com/in/samir-alexander-trochez-secue-20b9aa1b6/', '1772028295_OPERARIO.png'),
(25, 'QUIMIC@', 'Profesional en química especializada en el estudio y aplicación de compuestos derivados del cannabis. Con experiencia en investigación, desarrollo de productos y control de calidad, su enfoque se centra en garantizar procesos responsables y seguros, promo', 'https://www.facebook.com/ProyectoTime', 'https://www.instagram.com/time_codeman/?hl=es-la', 'https://www.linkedin.com/in/samir-alexander-trochez-secue-20b9aa1b6/', '1772029526_QUIMICA.png'),
(26, 'INGENIERO DE DATOS', 'Ingeniero de datos especializado en la industria del cannabis, con experiencia en el diseño de arquitecturas de información, análisis avanzado y gestión de grandes volúmenes de datos. Su trabajo se centra en transformar información científica y de mercado', 'https://www.facebook.com/ProyectoTime', 'https://www.instagram.com/time_codeman/?hl=es-la', 'https://www.linkedin.com/in/samir-alexander-trochez-secue-20b9aa1b6/', '1772029645_INGE_DATOS.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_comentarios`
--

CREATE TABLE `tbl_comentarios` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `mensaje` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_comentarios`
--

INSERT INTO `tbl_comentarios` (`ID`, `nombre`, `correo`, `mensaje`) VALUES
(2, 'SALEXTROS', 'SALEXTROS@HOTMAIL.COM', 'Buenas trades solicito una mesa para 7 personas muchas gracias.'),
(6, 'MAXIMINA TROCHEZ', 'samir_trochez@soy.sena.edu.co', 'Todo espectacular =)'),
(10, 'g', 'hola@hol.com', 'gggg'),
(11, 'Cristian Trochez', 'cristian_18@gmail.com', 'Excelente servicio volveré con mi familia =)'),
(12, 'Maximina', 'maximina@gmail.com', 'Excelentes productos los recomiendo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ingredientes` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `precio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_menu`
--

INSERT INTO `tbl_menu` (`ID`, `nombre`, `ingredientes`, `foto`, `precio`) VALUES
(15, 'JABÓN CANNABIS', 'Aceite de cannabis (CBD), aceite de coco, aceite de oliva, glicerina vegetal, agua destilada, sosa cáustica (hidróxido de sodio), aceites esenciales (lavanda, menta, eucalipto, etc.), colorantes naturales (arcillas, cúrcuma, carbón activado).', '1772034108_JABON_CANNABIS.png', '$35000'),
(16, 'POMADA CANNABIS', 'Aceite de cannabis (CBD), cera de abejas, aceite de coco, manteca de karité, aceite de oliva, aceites esenciales (menta, lavanda, eucalipto, etc.).', '1772034250_POMADA.png', '$45000'),
(17, 'ENSECIA CANNABIS', 'Aceite esencial de cannabis, aceite portador (coco fraccionado, almendra, jojoba), alcohol etílico (opcional para fijar aroma), agua destilada, aceites esenciales complementarios (lavanda, menta, eucalipto, etc.).', '1772034369_ENSENCIA_2.png', '$55000'),
(18, 'ACEITE CANNABIS', 'Marihuana seca y curada, aceite de oliva virgen extra (o aceite de coco/MCT), agua embotellada (para limpieza inicial de la planta).', '1772034639_ACEITE_CANNABIS.png', '$78000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_testimonios`
--

CREATE TABLE `tbl_testimonios` (
  `ID` int(11) NOT NULL,
  `opinion` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_testimonios`
--

INSERT INTO `tbl_testimonios` (`ID`, `opinion`, `nombre`) VALUES
(9, '“La pomada me ayudó muchísimo con la tensión muscular. Muy recomendada.”', 'anonimo'),
(10, '“El aceite tiene excelente aroma y calidad. Lo uso a diario para masajes.”', 'Axel'),
(11, '“Los productos son naturales, efectivos y de muy buena presentación.”', 'Maria José');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `ID` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ID`, `usuario`, `password`, `correo`) VALUES
(6, 'salextros', '81dc9bdb52d04dc20036dbd8313ed055', 'salextros@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_banners`
--
ALTER TABLE `tbl_banners`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_colaboradores`
--
ALTER TABLE `tbl_colaboradores`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_comentarios`
--
ALTER TABLE `tbl_comentarios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_testimonios`
--
ALTER TABLE `tbl_testimonios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_banners`
--
ALTER TABLE `tbl_banners`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_colaboradores`
--
ALTER TABLE `tbl_colaboradores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tbl_comentarios`
--
ALTER TABLE `tbl_comentarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tbl_testimonios`
--
ALTER TABLE `tbl_testimonios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
