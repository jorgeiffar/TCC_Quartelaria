-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Nov-2025 às 20:34
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tccquartelaria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `armamentos`
--

DROP TABLE IF EXISTS `armamentos`;
CREATE TABLE IF NOT EXISTS `armamentos` (
  `id_armamento` int NOT NULL AUTO_INCREMENT,
  `nome_armamento` varchar(255) NOT NULL,
  `tipo_armamento` text NOT NULL,
  `calibre_armamento` text NOT NULL,
  `codigo_armamento` int NOT NULL,
  `status_armamento` int NOT NULL,
  PRIMARY KEY (`id_armamento`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `armamentos`
--

INSERT INTO `armamentos` (`id_armamento`, `nome_armamento`, `tipo_armamento`, `calibre_armamento`, `codigo_armamento`, `status_armamento`) VALUES
(1, 'T4', 'Fuzil', '5,56x45mm', 123564, 1),
(2, 'FAL', 'Fuzil', '7,62x51mm', 55698, 0),
(3, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 123465, 0),
(4, 'GLOCK', 'Pistola', '9mm', 474956, 0),
(5, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 789, 0),
(8, 'FAL', 'Fuzil', '7,62x51mm', 2147483647, 0),
(9, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 852852, 0),
(10, 'T4 Rajada', 'Fuzil', '5,56x45mm', 456456456, 0),
(11, 'T4', 'Fuzil', '5,56x45mm', 159159, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `equipamentos`
--

DROP TABLE IF EXISTS `equipamentos`;
CREATE TABLE IF NOT EXISTS `equipamentos` (
  `id_equipamento` int NOT NULL AUTO_INCREMENT,
  `nome_equipamento` varchar(255) NOT NULL,
  `tipo_equipamento` text NOT NULL,
  `quantidade_equipamento` int NOT NULL,
  `quantidade_disponivel_equipamento` int NOT NULL,
  `ultima_atualizacao_equipamento` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_equipamento` int NOT NULL,
  PRIMARY KEY (`id_equipamento`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id_equipamento`, `nome_equipamento`, `tipo_equipamento`, `quantidade_equipamento`, `quantidade_disponivel_equipamento`, `ultima_atualizacao_equipamento`, `status_equipamento`) VALUES
(1, 'Carregador T4', 'Outros', 35, 0, '0000-00-00 00:00:00', 0),
(3, 'Capacete ', 'Disturbios', 83, 0, '0000-00-00 00:00:00', 0),
(4, '12GA', 'Municao', 8020, 0, '2025-11-20 16:54:11', 0),
(5, '9mm', 'Municao', 8000, 0, '0000-00-00 00:00:00', 0),
(6, '5,56x45mm', 'Municao', 2001, 0, '2025-11-20 16:52:17', 0),
(7, 'Escudo', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(8, 'Granada', 'Disturbios', 52, 0, '0000-00-00 00:00:00', 0),
(11, '7,62x51mm', 'Municao', 500, 0, '2025-10-21 14:51:59', 0),
(12, 'Spark', 'Municao', 81, 15, '2025-10-21 14:52:21', 0),
(14, 'Carregador SMT 40', 'Outros', 20, 0, '2025-10-25 22:40:47', 0),
(15, 'Bandoleira CBC PUMP', 'Outros', 30, 0, '2025-10-25 22:43:11', 0),
(16, 'Carregador IA2', 'Outros', 30, 0, '2025-11-20 16:04:04', 0),
(17, 'Carregador 762 ', 'Outros', 15, 0, '2025-11-20 16:13:04', 0),
(18, 'Bastão', 'Disturbios', 50, 0, '2025-11-20 16:45:40', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_checklist`
--

DROP TABLE IF EXISTS `itens_checklist`;
CREATE TABLE IF NOT EXISTS `itens_checklist` (
  `id_item` int NOT NULL AUTO_INCREMENT,
  `nome_item` varchar(50) NOT NULL,
  `descricao_item` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `itens_checklist`
--

INSERT INTO `itens_checklist` (`id_item`, `nome_item`, `descricao_item`) VALUES
(1, 'Pneus', NULL),
(2, 'Pneu Reserva', NULL),
(3, 'Faróis', NULL),
(4, 'Sinaleiras', NULL),
(5, 'Sistema de pisca (esq., dir., alerta)', NULL),
(6, 'Luz de freios', NULL),
(7, 'Luz de ré', NULL),
(8, 'Lataria', NULL),
(9, 'Freios', NULL),
(10, 'Freio de estacionamento', NULL),
(11, 'Estofamento', NULL),
(12, 'Nível do radiador', NULL),
(13, 'Nível do óleo', NULL),
(14, 'Retrovisores', NULL),
(15, 'Extintor', NULL),
(16, 'Sistema de comunicação', NULL),
(17, 'Sirene e giro flash', NULL),
(18, 'Lavagem', NULL),
(19, 'Tapetes', NULL),
(20, 'Macaco', NULL),
(21, 'Triângulo', NULL),
(22, 'Chave de roda', NULL),
(23, 'Limpador de para-brisas', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs_sistema`
--

DROP TABLE IF EXISTS `logs_sistema`;
CREATE TABLE IF NOT EXISTS `logs_sistema` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_usuario_log` int NOT NULL,
  `acao` varchar(255) NOT NULL,
  `data_hora_log` datetime NOT NULL,
  PRIMARY KEY (`id_log`),
  KEY `fk_id_usuario_log` (`id_usuario_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `operacoes`
--

DROP TABLE IF EXISTS `operacoes`;
CREATE TABLE IF NOT EXISTS `operacoes` (
  `id_operacao` int NOT NULL AUTO_INCREMENT,
  `nome_operacao` varchar(255) NOT NULL,
  `tipo_operacao` text NOT NULL,
  `local_operacao` varchar(1000) NOT NULL,
  `descricao_operacao` varchar(1000) NOT NULL,
  `data_inicio_operacao` datetime NOT NULL,
  `status_operacao` text NOT NULL,
  PRIMARY KEY (`id_operacao`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `operacoes`
--

INSERT INTO `operacoes` (`id_operacao`, `nome_operacao`, `tipo_operacao`, `local_operacao`, `descricao_operacao`, `data_inicio_operacao`, `status_operacao`) VALUES
(1, 'Oxfordinho', 'Cerco', 'Itaqui', 'ddefwregg', '2025-10-24 22:28:00', 'Em Andamento'),
(3, 'Minumoro', 'Patrulhamento', 'Uruguaiana - Cohab 2', 'Subiraozintsu', '2025-05-26 15:05:00', 'Concluída'),
(4, 'burburinh', 'Apoio a Outro Órgão', 'Uruguaiana - Cohab 2', 'nao tem nada a fidsnajkdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddaddddddddddddddddddddd', '2025-11-20 18:00:00', 'Em Andamento');

-- --------------------------------------------------------

--
-- Estrutura da tabela `resultado_checklist_viatura`
--

DROP TABLE IF EXISTS `resultado_checklist_viatura`;
CREATE TABLE IF NOT EXISTS `resultado_checklist_viatura` (
  `id_resultado` int NOT NULL AUTO_INCREMENT,
  `id_solicitacao_viatura` int NOT NULL,
  `id_item` int NOT NULL,
  `qap` tinyint(1) DEFAULT '0',
  `observacao_item` text,
  PRIMARY KEY (`id_resultado`),
  KEY `id_solicitacao_viatura` (`id_solicitacao_viatura`),
  KEY `id_item` (`id_item`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `resultado_checklist_viatura`
--

INSERT INTO `resultado_checklist_viatura` (`id_resultado`, `id_solicitacao_viatura`, `id_item`, `qap`, `observacao_item`) VALUES
(1, 1, 1, 0, ''),
(2, 1, 2, 0, ''),
(3, 1, 3, 0, 'efq'),
(4, 1, 4, 1, ''),
(5, 1, 5, 0, ''),
(6, 1, 6, 0, ''),
(7, 1, 7, 0, ''),
(8, 1, 8, 0, 'feqfe'),
(9, 1, 9, 0, ''),
(10, 1, 10, 1, 'efq'),
(11, 1, 11, 1, 'efq'),
(12, 1, 12, 0, ''),
(13, 1, 13, 0, ''),
(14, 1, 14, 0, ''),
(15, 1, 15, 0, ''),
(16, 1, 16, 0, ''),
(17, 1, 17, 0, ''),
(18, 1, 18, 0, ''),
(19, 1, 19, 0, ''),
(20, 1, 20, 0, ''),
(21, 1, 21, 0, ''),
(22, 1, 22, 0, ''),
(23, 1, 23, 0, ''),
(24, 2, 1, 1, 'ef'),
(25, 2, 2, 1, 'wfe'),
(26, 2, 3, 1, 'fwe'),
(27, 2, 4, 1, ''),
(28, 2, 5, 0, 'wef'),
(29, 2, 6, 0, ''),
(30, 2, 7, 0, ''),
(31, 2, 8, 0, ''),
(32, 2, 9, 0, ''),
(33, 2, 10, 0, ''),
(34, 2, 11, 0, ''),
(35, 2, 12, 0, ''),
(36, 2, 13, 0, ''),
(37, 2, 14, 0, ''),
(38, 2, 15, 0, ''),
(39, 2, 16, 0, ''),
(40, 2, 17, 0, ''),
(41, 2, 18, 0, ''),
(42, 2, 19, 0, ''),
(43, 2, 20, 0, ''),
(44, 2, 21, 0, ''),
(45, 2, 22, 0, ''),
(46, 2, 23, 0, ''),
(47, 3, 1, 1, 'eteeeee'),
(48, 3, 2, 0, 'et'),
(49, 3, 3, 1, 'eth'),
(50, 3, 4, 1, ''),
(51, 3, 5, 1, ''),
(52, 3, 6, 1, ''),
(53, 3, 7, 1, ''),
(54, 3, 8, 0, ''),
(55, 3, 9, 0, 'etheth'),
(56, 3, 10, 0, ''),
(57, 3, 11, 0, ''),
(58, 3, 12, 1, 'eeee'),
(59, 3, 13, 0, 'th'),
(60, 3, 14, 0, ''),
(61, 3, 15, 0, ''),
(62, 3, 16, 1, 'thththt'),
(63, 3, 17, 0, ''),
(64, 3, 18, 0, ''),
(65, 3, 19, 0, ''),
(66, 3, 20, 0, ''),
(67, 3, 21, 0, ''),
(68, 3, 22, 0, ''),
(69, 3, 23, 0, ''),
(70, 4, 1, 1, ''),
(71, 4, 2, 0, ''),
(72, 4, 3, 0, ''),
(73, 4, 4, 0, ''),
(74, 4, 5, 0, ''),
(75, 4, 6, 0, ''),
(76, 4, 7, 0, ''),
(77, 4, 8, 0, ''),
(78, 4, 9, 0, ''),
(79, 4, 10, 0, ''),
(80, 4, 11, 0, ''),
(81, 4, 12, 0, ''),
(82, 4, 13, 0, ''),
(83, 4, 14, 0, ''),
(84, 4, 15, 0, ''),
(85, 4, 16, 0, ''),
(86, 4, 17, 0, ''),
(87, 4, 18, 0, ''),
(88, 4, 19, 0, ''),
(89, 4, 20, 0, ''),
(90, 4, 21, 0, ''),
(91, 4, 22, 0, ''),
(92, 4, 23, 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao_itens`
--

DROP TABLE IF EXISTS `solicitacao_itens`;
CREATE TABLE IF NOT EXISTS `solicitacao_itens` (
  `id_solicitacao_itens` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `motivo_solicitacao` text NOT NULL,
  `data_solicitacao` datetime NOT NULL,
  `data_devolucao_item` date NOT NULL,
  `data_devolucao_real_item` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_solicitacao` text NOT NULL,
  `observacao_item` varchar(600) NOT NULL,
  `id_item` int NOT NULL,
  `tipo_item` varchar(50) NOT NULL,
  `quantidade` int NOT NULL,
  `id_solicitacao` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitacao_itens`),
  KEY `fk_id_usuario_solicitacao` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `solicitacao_itens`
--

INSERT INTO `solicitacao_itens` (`id_solicitacao_itens`, `id_usuario`, `motivo_solicitacao`, `data_solicitacao`, `data_devolucao_item`, `data_devolucao_real_item`, `status_solicitacao`, `observacao_item`, `id_item`, `tipo_item`, `quantidade`, `id_solicitacao`) VALUES
(51, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 30, 1752189962),
(52, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', '2025-10-26 02:02:10', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1752190314),
(53, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 50, 1752190314),
(54, 1, 'b', '2025-07-10 00:00:00', '2025-07-31', '2025-10-26 02:02:10', 'Devolvido', 'Coronha arranhada', 3, 'armamento', 1, 1752190726),
(55, 1, 'b', '2025-07-10 00:00:00', '2025-07-31', '2025-10-26 02:02:10', 'Devolvido', '', 8, 'equipamento', 80, 1752190726),
(56, 1, 'a', '2025-07-14 00:00:00', '2025-07-17', '2025-10-26 02:02:10', 'Devolvido', 'massa danificada', 7, 'armamento', 1, 1752517495),
(57, 1, 'a', '2025-07-14 00:00:00', '2025-07-17', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 50, 1752517495),
(60, 1, 'a', '2025-07-16 00:00:00', '2025-07-18', '2025-10-26 02:02:10', 'Devolvido', '', 3, 'armamento', 1, 1752693742),
(61, 1, 'a', '2025-07-16 00:00:00', '2025-07-18', '2025-10-26 02:02:10', 'Devolvido', '', 8, 'equipamento', 60, 1752693742),
(63, 3, 'b', '2025-09-08 00:00:00', '2025-09-10', '2025-10-26 02:02:10', 'Devolvido', '', 3, 'armamento', 1, 1757352650),
(64, 3, 'b', '2025-09-08 00:00:00', '2025-09-10', '2025-10-26 02:02:10', 'Devolvido', '', 1, 'equipamento', 2, 1757352650),
(65, 3, 'b', '2025-09-08 00:00:00', '2025-09-10', '2025-10-26 02:02:10', 'Devolvido', '', 8, 'equipamento', 50, 1757352650),
(66, 2, 'a', '2025-09-08 00:00:00', '2025-09-11', '2025-10-26 02:02:10', 'Devolvido', '', 4, 'armamento', 1, 1757352729),
(67, 3, 'a', '2025-09-08 00:00:00', '2025-09-10', '2025-10-26 02:02:10', 'Devolvido', '', 5, 'armamento', 1, 1757356757),
(68, 3, 'a', '2025-09-08 00:00:00', '2025-09-10', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 50, 1757356757),
(69, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', '2025-10-26 02:02:10', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1758564425),
(70, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 10, 1758564425),
(71, 3, 'a', '2025-09-22 00:00:00', '2025-09-23', '2025-10-26 02:02:10', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1758565092),
(72, 3, 'a', '2025-09-22 00:00:00', '2025-09-23', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 50, 1758565092),
(73, 3, 'a', '2025-09-22 00:00:00', '2025-09-30', '2025-10-26 02:02:10', 'Devolvido', 'massa danificada', 5, 'armamento', 1, 1758565241),
(74, 3, 'a', '2025-09-22 00:00:00', '2025-09-30', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 50, 1758565241),
(75, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', '2025-10-26 02:02:10', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1758565755),
(76, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 40, 1758565755),
(77, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', '2025-10-26 02:02:10', 'Devolvido', 'Coronha arranhada', 5, 'armamento', 1, 1758566049),
(78, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', '2025-10-26 02:02:10', 'Devolvido', '', 6, 'equipamento', 10, 1758566049),
(79, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', '2025-10-26 02:02:10', 'Devolvido', 'massa danificada', 3, 'armamento', 1, 1758566666),
(80, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', '2025-10-26 02:02:10', 'Devolvido', '', 8, 'equipamento', 10, 1758566666),
(81, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', '2025-10-26 02:02:10', 'Devolvido', 'Coronha arranhada', 3, 'armamento', 1, 1758567105),
(82, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', '2025-10-26 02:02:10', 'Devolvido', '', 4, 'equipamento', 10, 1758567105),
(84, 3, 'a', '2025-09-29 00:00:00', '2025-09-30', '2025-10-26 02:02:10', 'Devolvido', '', 5, 'armamento', 1, 1759168400),
(85, 3, 'a', '2025-09-29 00:00:00', '2025-10-01', '2025-10-26 02:02:10', 'Devolvido', '', 5, 'armamento', 1, 1759168467),
(86, 3, 'a', '2025-10-21 00:00:00', '2025-10-28', '2025-10-26 02:02:10', 'Devolvido', 'bom estado', 1, 'armamento', 1, 1761070678),
(87, 3, 'b', '2025-10-21 00:00:00', '2025-10-22', '2025-10-27 16:28:42', 'Devolvido', 'otimo estado', 3, 'armamento', 1, 1761071051),
(88, 3, 'b', '2025-10-21 00:00:00', '2025-10-22', '2025-10-26 02:02:10', 'Devolvido', '', 2, 'armamento', 1, 1761071075),
(89, 2, 'b', '2025-10-21 15:33:16', '2065-08-02', '2025-10-26 02:02:10', 'Devolvido', '', 0, '', 0, NULL),
(90, 2, 'b', '2025-10-21 00:00:00', '2065-08-02', '2025-10-26 02:07:59', 'Devolvido', 'otimo estado', 4, 'armamento', 1, 89),
(91, 7, '3', '2025-10-27 13:33:37', '2025-10-30', '2025-10-27 16:33:37', 'Devolvido', '', 0, '', 0, 116),
(92, 7, '3', '2025-10-27 00:00:00', '2025-10-30', '2025-10-27 16:33:37', 'Devolvido', '', 5, 'armamento', 1, 91),
(93, 7, '3', '2025-10-27 00:00:00', '2025-10-30', '2025-10-27 16:33:37', 'Devolvido', '', 1, 'equipamento', 8, 91),
(94, 7, '3', '2025-10-27 00:00:00', '2025-10-30', '2025-10-27 16:33:37', 'Devolvido', '', 5, 'equipamento', 40, 91),
(95, 3, '3', '2025-10-27 13:43:36', '2025-11-05', '2025-10-27 16:43:36', 'Devolvido', '', 0, '', 0, 117),
(96, 3, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:12:11', 'Devolvido', 'Ótimo estado', 2, 'armamento', 1, 95),
(97, 3, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:12:11', 'Devolvido', '', 7, 'equipamento', 5, 95),
(98, 3, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:12:11', 'Devolvido', '', 11, 'equipamento', 20, 95),
(99, 7, '1', '2025-10-27 13:50:20', '2025-11-06', '2025-10-27 16:50:20', 'Devolvido', '', 0, '', 0, NULL),
(100, 7, '1', '2025-10-27 00:00:00', '2025-11-06', '2025-10-27 16:50:20', 'Devolvido', '', 4, 'armamento', 1, 99),
(101, 7, '1', '2025-10-27 00:00:00', '2025-11-06', '2025-10-27 16:50:20', 'Devolvido', '', 8, 'equipamento', 2, 99),
(102, 4, '3', '2025-10-27 13:55:35', '2025-11-04', '2025-10-27 16:55:35', 'Devolvido', '', 0, '', 0, NULL),
(103, 4, '3', '2025-10-27 00:00:00', '2025-11-04', '2025-10-27 16:55:35', 'Devolvido', '', 3, 'armamento', 1, 102),
(104, 7, '3', '2025-10-27 13:56:14', '2025-11-05', '2025-10-27 16:56:14', 'Devolvido', '', 0, '', 0, NULL),
(105, 7, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 16:56:14', 'Devolvido', '', 5, 'armamento', 1, 104),
(106, 7, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 16:56:14', 'Devolvido', '', 6, 'equipamento', 50, 104),
(107, 7, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 16:56:14', 'Devolvido', '', 12, 'equipamento', 2, 104),
(108, 5, '3', '2025-10-27 13:56:46', '2025-11-05', '2025-10-27 16:56:46', 'Devolvido', '', 0, '', 0, NULL),
(109, 5, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 16:56:46', 'Devolvido', '', 1, 'armamento', 1, 108),
(110, 2, '3', '2025-10-27 14:02:01', '3000-01-22', '2025-10-27 17:02:01', 'Devolvido', '', 0, 'cabecalho', 0, 1761071076),
(111, 2, '3', '2025-10-27 00:00:00', '3000-01-22', '2025-10-27 17:02:01', 'Devolvido', '', 1, 'armamento', 1, 1761071076),
(112, 2, '3', '2025-10-27 00:00:00', '3000-01-22', '2025-10-27 17:02:01', 'Devolvido', '', 3, 'equipamento', 2, 1761071076),
(113, 3, '3', '2025-10-27 14:02:55', '2025-11-05', '2025-10-27 17:02:55', 'Devolvido', '', 0, 'cabecalho', 0, 1761071077),
(114, 3, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:02:55', 'Devolvido', '', 1, 'armamento', 1, 1761071077),
(115, 3, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:02:55', 'Devolvido', '', 12, 'equipamento', 2, 1761071077),
(116, 7, '3', '2025-10-27 14:06:11', '2025-11-05', '2025-10-27 17:06:11', 'Devolvido', '', 1, 'armamento', 1, NULL),
(117, 3, '3', '2025-10-27 14:06:45', '2025-11-05', '2025-10-27 17:06:45', 'Devolvido', '', 1, 'armamento', 1, NULL),
(118, 8, '3', '2025-10-27 14:07:24', '2025-11-04', '2025-10-27 17:07:24', 'Devolvido', '', 0, '', 0, NULL),
(119, 8, '3', '2025-10-27 00:00:00', '2025-11-04', '2025-10-27 17:07:24', 'Devolvido', '', 1, 'armamento', 1, 118),
(120, 3, '3', '2025-10-27 14:07:46', '2025-11-04', '2025-10-27 17:07:46', 'Devolvido', '', 0, '', 0, NULL),
(121, 3, '3', '2025-10-27 00:00:00', '2025-11-04', '2025-10-27 17:07:46', 'Devolvido', '', 1, 'armamento', 1, 120),
(122, 3, '3', '2025-10-27 14:08:45', '2025-11-05', '2025-10-27 17:08:45', 'Devolvido', '', 0, '', 0, NULL),
(123, 3, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:08:45', 'Devolvido', '', 1, 'armamento', 1, 122),
(124, 8, '3', '2025-10-27 14:23:55', '2025-11-05', '2025-10-27 17:23:55', 'Devolvido', '', 0, '', 0, NULL),
(125, 8, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:23:55', 'Devolvido', '', 4, 'armamento', 1, 124),
(126, 8, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:23:55', 'Devolvido', '', 4, 'equipamento', 50, 124),
(127, 7, '1', '2025-10-27 14:30:36', '2025-11-05', '2025-10-27 17:30:36', 'Devolvido', '', 0, '', 0, NULL),
(128, 7, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:30:36', 'Devolvido', '', 4, 'armamento', 1, 127),
(129, 7, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:30:36', 'Devolvido', '', 5, 'equipamento', 20, 127),
(130, 7, '1', '2025-10-27 14:33:28', '2025-11-05', '2025-10-27 17:33:28', 'Devolvido', '', 0, '', 0, NULL),
(131, 7, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:33:28', 'Devolvido', '', 4, 'armamento', 1, 1761586408),
(132, 7, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:33:28', 'Devolvido', '', 5, 'equipamento', 20, 1761586408),
(133, 8, '1', '2025-10-27 14:40:43', '2025-11-05', '2025-10-27 17:40:43', 'Devolvido', '', 0, '', 0, 1761586843),
(134, 8, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:40:43', 'Devolvido', '', 4, 'armamento', 1, 1761586843),
(135, 8, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:40:43', 'Devolvido', '', 5, 'equipamento', 20, 1761586843),
(136, 7, '3', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 17:42:08', 'Devolvido', '', 4, 'armamento', 1, 1761586928),
(137, 7, '3', '2025-10-27 00:00:00', '2025-11-06', '2025-10-27 17:51:24', 'Devolvido', '', 4, 'armamento', 1, 1761587484),
(138, 5, '1', '2025-10-27 00:00:00', '2025-11-01', '2025-10-27 17:53:34', 'Devolvido', '', 2, 'armamento', 1, 1761587614),
(139, 5, '1', '2025-10-27 00:00:00', '2025-11-01', '2025-10-27 17:53:34', 'Devolvido', '', 5, 'equipamento', 20, 1761587614),
(140, 7, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 18:00:36', 'Devolvido', 'Ótimo estado', 2, 'armamento', 1, 1761587782),
(141, 7, '1', '2025-10-27 00:00:00', '2025-11-05', '2025-10-27 18:00:36', 'Devolvido', '', 11, 'equipamento', 50, 1761587782),
(142, 3, '3', '2025-10-27 00:00:00', '2025-11-06', '2025-10-27 17:59:57', 'Negado', '', 1, 'armamento', 1, 1761587997),
(143, 7, '3', '2025-10-30 00:00:00', '2025-11-04', '2025-11-01 17:32:16', 'Devolvido', '', 2, 'equipamento', 2, 1761868175),
(144, 8, '3', '2025-11-01 00:00:00', '2025-11-27', '2025-11-01 17:27:11', 'Devolvido', 'massa danificada', 1, 'armamento', 1, 1762018024),
(145, 8, '3', '2025-11-01 00:00:00', '2025-11-26', '2025-11-01 17:29:35', 'Devolvido', 'otimo estado', 1, 'armamento', 1, 1762018169),
(146, 7, '3', '2025-11-04 00:00:00', '2025-12-03', '2025-11-11 00:33:16', 'Devolvido', 'Ótimo estado', 1, 'armamento', 1, 1762296498),
(147, 7, '3', '2025-11-04 00:00:00', '2025-12-03', '2025-11-11 00:33:16', 'Devolvido', '', 11, 'equipamento', 20, 1762296498),
(148, 8, '1', '2025-11-11 00:00:00', '2025-12-03', '2025-11-11 01:06:11', 'Devolvido', 'bom estado', 2, 'armamento', 1, 1762820995),
(149, 8, '1', '2025-11-11 00:00:00', '2025-11-27', '2025-11-11 00:35:35', 'Devolvido', 'massa danificada', 1, 'armamento', 1, 1762821317),
(150, 8, '1', '2025-11-11 00:00:00', '2025-11-27', '2025-11-11 00:35:35', 'Devolvido', 'bom estado', 3, 'armamento', 1, 1762821317),
(151, 7, '1', '2025-11-11 00:00:00', '2025-12-03', '2025-11-12 18:04:38', 'Devolvido', 'massa danificada', 3, 'armamento', 1, 1762823362),
(152, 3, '1', '2025-11-12 00:00:00', '2025-12-02', '2025-11-12 17:41:28', 'Negado', '', 2, 'armamento', 1, 1762969288),
(153, 10, '1', '2025-11-12 00:00:00', '2025-12-03', '2025-11-12 17:43:21', 'Negado', '', 4, 'armamento', 1, 1762969401),
(154, 10, '1', '2025-11-12 00:00:00', '2025-12-03', '2025-11-12 17:43:21', 'Negado', '', 2, 'equipamento', 2147483647, 1762969401),
(155, 8, '3', '2025-11-13 00:00:00', '2025-11-22', '2025-11-13 18:14:40', 'Devolvido', '', 3, 'equipamento', 2, 1763057604),
(156, 7, '3', '2025-11-13 00:00:00', '2025-11-27', '2025-11-13 18:21:05', 'Aceito', '', 1, 'armamento', 1, 1763058065),
(157, 7, '3', '2025-11-13 00:00:00', '2025-11-27', '2025-11-13 18:21:05', 'Aceito', '', 12, 'equipamento', 15, 1763058065),
(158, 3, '1', '2025-11-20 00:00:00', '2025-11-28', '2025-11-20 18:52:36', 'Pendente', '', 2, 'armamento', 1, 1763664756),
(159, 3, '1', '2025-11-20 00:00:00', '2025-11-28', '2025-11-20 18:52:36', 'Pendente', '', 6, 'equipamento', 50, 1763664756);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao_viatura`
--

DROP TABLE IF EXISTS `solicitacao_viatura`;
CREATE TABLE IF NOT EXISTS `solicitacao_viatura` (
  `id_solicitacao_viatura` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_solicitacao_viatura` datetime NOT NULL,
  `quilometragem` int DEFAULT NULL,
  `placa_veiculo` varchar(10) DEFAULT NULL,
  `observacoes_viatura` text,
  `status_solicitacao_viatura` enum('Pendente','Ativo','Negado','Devolvido') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Pendente',
  PRIMARY KEY (`id_solicitacao_viatura`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `solicitacao_viatura`
--

INSERT INTO `solicitacao_viatura` (`id_solicitacao_viatura`, `id_usuario`, `data_solicitacao_viatura`, `quilometragem`, `placa_veiculo`, `observacoes_viatura`, `status_solicitacao_viatura`) VALUES
(1, 3, '2025-10-30 22:58:17', 123456, 'IZE2B48', '', 'Devolvido'),
(2, 3, '2025-11-04 23:08:03', 123456, 'IZE2B48', '', 'Devolvido'),
(3, 3, '2025-11-12 18:05:13', 852, 'IZE2B48', '', 'Devolvido'),
(4, 3, '2025-11-12 18:18:29', 13, 'IZE2B48', '', 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(255) NOT NULL,
  `identidade_funcional_usuario` int NOT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `perfil_usuario` tinyint(1) NOT NULL,
  `data_cadastro_usuario` datetime NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `identidade_funcional_usuario`, `email_usuario`, `senha_usuario`, `perfil_usuario`, `data_cadastro_usuario`) VALUES
(1, 'Usuário Teste', 1234, 'teste@teste.com', '1234', 1, '0000-00-00 00:00:00'),
(2, 'Jorge', 123, 'jorge@gmail.com', '$2y$10$9ERejWufM7mEw/2X30PT4ezAFKpSYpii2ji/bppA/bZUFHHR5DWba', 1, '0000-00-00 00:00:00'),
(3, 'pedro', 654, 'pedro@gmail.com', '$2y$10$pPuzaZI4rO7BQi2MXqp0mu1Bvw8nIzBk.zraPkykdN/.xkzDICRSq', 2, '0000-00-00 00:00:00'),
(4, 'JorgeReal', 257, 'jorginho@if.com', '$2y$10$GWB1xWHXcL20z.EnJ1gNJe.SDJLfn5J77r7CurOZe7FuKcqZiySTK', 1, '0000-00-00 00:00:00'),
(5, 'jorge', 13, 'd@g.com', '$2y$10$VPPG3cHOhTcAZZcrLeqjp.rR1LRFTZxRm/PXpW5mHDAqECPNEGy9u', 2, '0000-00-00 00:00:00'),
(7, 'Oxford', 987987, 'f@d.cp', '$2y$10$ge2PeeVBLH2lBuqAoOyk7umeC74T4CpBuigv18UiyGBwtGy4Tagf.', 2, '0000-00-00 00:00:00'),
(8, 'mijuji', 257257, 'f@c.c', '$2y$10$vSSEM5.kKKjm6zzi2ocdoOY2rUJGoSdUQUmdlqCm/XSRQLcjWftDu', 1, '0000-00-00 00:00:00'),
(9, 'Régis', 7070, 'regis70@gmail.com', '$2y$10$nUqjUCHcyvUhno6o/YuW8.etGgoiJ9IxXmGQ9PAIho3m.BTHxAEhO', 1, '0000-00-00 00:00:00'),
(10, 'Clara', 987654321, 'clara@c.com', '$2y$10$iXs9rFl9wNrpjU2iy58sBOqa5Lm1PWsr2ka62LwNprMaf0LMzO7w.', 2, '0000-00-00 00:00:00'),
(11, 'pedrinhuu', 258, 'p@g.com', '$2y$10$DALOCXJIF4FFPsOQ74P7xukfVH2bsmSqJJjZlGU52GZCV5Ydmcp3e', 2, '0000-00-00 00:00:00'),
(12, 'Marcelo Fischborn', 852456, 'fish@m.com', '$2y$10$SM4o2JU/OOqDxd0RnVewle6AlVpaFzbk7IPZzTqCpWOC0b5zzZHjG', 1, '0000-00-00 00:00:00'),
(13, 'f', 131, 'f1@fv.vsw', '$2y$10$hxZJTySTHzAiiyDy8C9It.nfBIyNQtOtxMAS1MmuMw6fQgzrQbRsq', 1, '0000-00-00 00:00:00'),
(14, '3egeg', 424, 'herobrineloko257@gmail.com', '$2y$10$rP6FwzCLab6vr0Kucp1L9.yCNlkBWnLXpp5JHPzqqz.6NT.VUS11W', 1, '0000-00-00 00:00:00'),
(15, 'mauricio', 2147483647, 'furry@m.c', '$2y$10$upgpIGFLw.bJk3F53tpnquuxIhBLCVpCVLsvm4PE.GJjWHbeQ3Guu', 2, '0000-00-00 00:00:00');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `logs_sistema`
--
ALTER TABLE `logs_sistema`
  ADD CONSTRAINT `fk_id_usuario_log` FOREIGN KEY (`id_usuario_log`) REFERENCES `usuarios` (`id_usuario`);

--
-- Limitadores para a tabela `solicitacao_itens`
--
ALTER TABLE `solicitacao_itens`
  ADD CONSTRAINT `fk_id_usuario_solicitacao` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
