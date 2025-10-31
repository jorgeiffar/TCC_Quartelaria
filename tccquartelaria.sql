-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 31-Out-2025 às 22:04
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `armamentos`
--

INSERT INTO `armamentos` (`id_armamento`, `nome_armamento`, `tipo_armamento`, `calibre_armamento`, `codigo_armamento`, `status_armamento`) VALUES
(1, 'T4', 'Fuzil', '5,56', 123564, 0),
(2, 'FAL', 'Fuzil', '7,62', 55698, 0),
(3, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 123465, 0),
(4, 'GLOCK', 'Pistola', '9mm', 474956, 0),
(5, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 789, 0);

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
  `ultima_atualizacao_equipamento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_equipamento` int NOT NULL,
  PRIMARY KEY (`id_equipamento`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id_equipamento`, `nome_equipamento`, `tipo_equipamento`, `quantidade_equipamento`, `quantidade_disponivel_equipamento`, `ultima_atualizacao_equipamento`, `status_equipamento`) VALUES
(1, 'Carregador T4', 'Outros', 35, 0, '0000-00-00 00:00:00', 0),
(2, 'Cassetete', 'Bastao', 50, 2, '0000-00-00 00:00:00', 0),
(3, 'Capacete', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(4, '12GA', 'Municao', 80000, 0, '0000-00-00 00:00:00', 0),
(5, '9mm', 'Municao', 800, 0, '0000-00-00 00:00:00', 0),
(6, '5,56x45mm', 'Municao', 2000, 0, '0000-00-00 00:00:00', 0),
(7, 'Escudo', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(8, 'Granada', 'Disturbios', 50, 0, '0000-00-00 00:00:00', 0),
(11, '7,62x51mm', 'Municao', 500, 0, '2025-10-21 14:51:59', 0),
(12, 'Spark', 'Municao', 80, 0, '2025-10-21 14:52:21', 0),
(14, 'Carregador FAL', 'Outros', 20, 0, '2025-10-25 22:40:47', 0),
(15, 'Bandoleira CBC PUMP', 'Outros', 30, 0, '2025-10-25 22:43:11', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `operacoes`
--

INSERT INTO `operacoes` (`id_operacao`, `nome_operacao`, `tipo_operacao`, `local_operacao`, `descricao_operacao`, `data_inicio_operacao`, `status_operacao`) VALUES
(1, 'Oxforf', 'Cerco', 'Itaqui', 'ddefwregg', '2025-10-24 22:28:00', 'Em Andamento'),
(3, 'Minumoro', 'Patrulhamento', 'Uruguaiana - Cohab 2', 'Subiro', '2025-05-26 15:05:00', 'Concluída');

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(23, 1, 23, 0, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(143, 7, '3', '2025-10-30 00:00:00', '2025-11-04', '2025-10-30 23:49:35', 'Aceito', '', 2, 'equipamento', 2, 1761868175);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `solicitacao_viatura`
--

INSERT INTO `solicitacao_viatura` (`id_solicitacao_viatura`, `id_usuario`, `data_solicitacao_viatura`, `quilometragem`, `placa_veiculo`, `observacoes_viatura`, `status_solicitacao_viatura`) VALUES
(1, 3, '2025-10-30 22:58:17', 123456, 'IZE2B48', '', 'Devolvido');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(8, 'mijuji', 257257, 'f@c.c', '$2y$10$vSSEM5.kKKjm6zzi2ocdoOY2rUJGoSdUQUmdlqCm/XSRQLcjWftDu', 1, '0000-00-00 00:00:00');

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
