-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 21-Out-2025 às 18:49
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
(1, 'T4', 'Fuzil', '5,56', 123564, 1),
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id_equipamento`, `nome_equipamento`, `tipo_equipamento`, `quantidade_equipamento`, `quantidade_disponivel_equipamento`, `ultima_atualizacao_equipamento`, `status_equipamento`) VALUES
(1, 'T4', 'Carregador', 35, 1, '0000-00-00 00:00:00', 0),
(2, 'Cassetete', 'Bastao', 50, 1, '0000-00-00 00:00:00', 0),
(3, 'Capacete', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(4, '12GA', 'Municao', 350, 320, '0000-00-00 00:00:00', 0),
(5, '9mm', 'Municao', 800, 0, '0000-00-00 00:00:00', 0),
(6, '5,56x45mm', 'Municao', 2000, 90, '0000-00-00 00:00:00', 0),
(7, 'Escudo', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(8, 'Granada', 'Disturbios', 50, 0, '0000-00-00 00:00:00', 0),
(11, '7,62x51mm', 'Municao', 0, 0, '2025-10-21 14:51:59', 0),
(12, 'Spark', 'Municao', 80, 0, '2025-10-21 14:52:21', 0);

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
-- Estrutura da tabela `solicitacao_itens`
--

DROP TABLE IF EXISTS `solicitacao_itens`;
CREATE TABLE IF NOT EXISTS `solicitacao_itens` (
  `id_solicitacao_itens` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `motivo_solicitacao` text NOT NULL,
  `data_solicitacao` datetime NOT NULL,
  `data_devolucao_item` date NOT NULL,
  `status_solicitacao` text NOT NULL,
  `observacao_item` varchar(600) NOT NULL,
  `id_item` int NOT NULL,
  `tipo_item` varchar(50) NOT NULL,
  `quantidade` int NOT NULL,
  `id_solicitacao` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitacao_itens`),
  KEY `fk_id_usuario_solicitacao` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `solicitacao_itens`
--

INSERT INTO `solicitacao_itens` (`id_solicitacao_itens`, `id_usuario`, `motivo_solicitacao`, `data_solicitacao`, `data_devolucao_item`, `status_solicitacao`, `observacao_item`, `id_item`, `tipo_item`, `quantidade`, `id_solicitacao`) VALUES
(51, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Negado', '', 6, 'equipamento', 30, 1752189962),
(52, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1752190314),
(53, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Devolvido', '', 6, 'equipamento', 50, 1752190314),
(54, 1, 'b', '2025-07-10 00:00:00', '2025-07-31', 'Devolvido', 'Coronha arranhada', 3, 'armamento', 1, 1752190726),
(55, 1, 'b', '2025-07-10 00:00:00', '2025-07-31', 'Devolvido', '', 8, 'equipamento', 80, 1752190726),
(56, 1, 'a', '2025-07-14 00:00:00', '2025-07-17', 'Devolvido', 'massa danificada', 7, 'armamento', 1, 1752517495),
(57, 1, 'a', '2025-07-14 00:00:00', '2025-07-17', 'Devolvido', '', 6, 'equipamento', 50, 1752517495),
(60, 1, 'a', '2025-07-16 00:00:00', '2025-07-18', 'Negado', '', 3, 'armamento', 1, 1752693742),
(61, 1, 'a', '2025-07-16 00:00:00', '2025-07-18', 'Negado', '', 8, 'equipamento', 60, 1752693742),
(63, 3, 'b', '2025-09-08 00:00:00', '2025-09-10', 'Negado', '', 3, 'armamento', 1, 1757352650),
(64, 3, 'b', '2025-09-08 00:00:00', '2025-09-10', 'Negado', '', 1, 'equipamento', 2, 1757352650),
(65, 3, 'b', '2025-09-08 00:00:00', '2025-09-10', 'Negado', '', 8, 'equipamento', 50, 1757352650),
(66, 2, 'a', '2025-09-08 00:00:00', '2025-09-11', 'Negado', '', 4, 'armamento', 1, 1757352729),
(67, 3, 'a', '2025-09-08 00:00:00', '2025-09-10', 'Devolvido', '', 5, 'armamento', 1, 1757356757),
(68, 3, 'a', '2025-09-08 00:00:00', '2025-09-10', 'Devolvido', '', 6, 'equipamento', 50, 1757356757),
(69, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1758564425),
(70, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', 'Devolvido', '', 6, 'equipamento', 10, 1758564425),
(71, 3, 'a', '2025-09-22 00:00:00', '2025-09-23', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1758565092),
(72, 3, 'a', '2025-09-22 00:00:00', '2025-09-23', 'Devolvido', '', 6, 'equipamento', 50, 1758565092),
(73, 3, 'a', '2025-09-22 00:00:00', '2025-09-30', 'Devolvido', 'massa danificada', 5, 'armamento', 1, 1758565241),
(74, 3, 'a', '2025-09-22 00:00:00', '2025-09-30', 'Devolvido', '', 6, 'equipamento', 50, 1758565241),
(75, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', 'Devolvido', 'Ótimo estado', 5, 'armamento', 1, 1758565755),
(76, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', 'Devolvido', '', 6, 'equipamento', 40, 1758565755),
(77, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', 'Devolvido', 'Coronha arranhada', 5, 'armamento', 1, 1758566049),
(78, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', 'Devolvido', '', 6, 'equipamento', 10, 1758566049),
(79, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', 'Devolvido', 'massa danificada', 3, 'armamento', 1, 1758566666),
(80, 3, 'a', '2025-09-22 00:00:00', '2025-09-24', 'Devolvido', '', 8, 'equipamento', 10, 1758566666),
(81, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', 'Devolvido', 'Coronha arranhada', 3, 'armamento', 1, 1758567105),
(82, 3, 'a', '2025-09-22 00:00:00', '2025-10-01', 'Devolvido', '', 4, 'equipamento', 10, 1758567105),
(84, 3, 'a', '2025-09-29 00:00:00', '2025-09-30', 'Negado', '', 5, 'armamento', 1, 1759168400),
(85, 3, 'a', '2025-09-29 00:00:00', '2025-10-01', 'Negado', '', 5, 'armamento', 1, 1759168467),
(86, 3, 'a', '2025-10-21 00:00:00', '2025-10-28', 'Aceito', '', 1, 'armamento', 1, 1761070678),
(87, 3, 'b', '2025-10-21 00:00:00', '2025-10-22', 'Pendente', '', 3, 'armamento', 1, 1761071051),
(88, 3, 'b', '2025-10-21 00:00:00', '2025-10-22', 'Pendente', '', 2, 'armamento', 1, 1761071075),
(89, 2, 'b', '2025-10-21 15:33:16', '2065-08-02', 'Aceito', '', 0, '', 0, NULL),
(90, 2, 'b', '2025-10-21 00:00:00', '2065-08-02', 'Aceito', '', 4, 'armamento', 1, 89);

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao_viatura`
--

DROP TABLE IF EXISTS `solicitacao_viatura`;
CREATE TABLE IF NOT EXISTS `solicitacao_viatura` (
  `id_solicitacao_viatura` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `data_solicitacao_viatura` datetime NOT NULL,
  `check_list_viatura` varchar(255) NOT NULL,
  `observacoes_viatura` varchar(500) NOT NULL,
  `status_solicitacao_viatura` int NOT NULL,
  PRIMARY KEY (`id_solicitacao_viatura`),
  KEY `fk_id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `identidade_funcional_usuario`, `email_usuario`, `senha_usuario`, `perfil_usuario`, `data_cadastro_usuario`) VALUES
(1, 'Usuário Teste', 1234, 'teste@teste.com', '1234', 1, '0000-00-00 00:00:00'),
(2, 'Jorge', 123, 'jorge@gmail.com', '$2y$10$9ERejWufM7mEw/2X30PT4ezAFKpSYpii2ji/bppA/bZUFHHR5DWba', 1, '0000-00-00 00:00:00'),
(3, 'pedro', 654, 'pedro@gmail.com', '$2y$10$pPuzaZI4rO7BQi2MXqp0mu1Bvw8nIzBk.zraPkykdN/.xkzDICRSq', 2, '0000-00-00 00:00:00'),
(4, 'JorgeReal', 257, 'jorginho@if.com', '$2y$10$GWB1xWHXcL20z.EnJ1gNJe.SDJLfn5J77r7CurOZe7FuKcqZiySTK', 1, '0000-00-00 00:00:00');

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

--
-- Limitadores para a tabela `solicitacao_viatura`
--
ALTER TABLE `solicitacao_viatura`
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
