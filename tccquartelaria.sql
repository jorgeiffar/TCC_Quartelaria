-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10-Jul-2025 às 23:43
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
(3, 'T4', 'Fuzil', '5,56', 123564, 0),
(4, 'FAL', 'Fuzil', '7,62', 55698, 0),
(5, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 123465, 0),
(6, 'GLOCK', 'Pistola', '9mm', 474956, 0),
(7, 'CBC PUMP Military 3.0', 'Espingarda', '12GA', 789, 0);

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
  `data_cadastro_equipamento` datetime NOT NULL,
  `status_equipamento` int NOT NULL,
  PRIMARY KEY (`id_equipamento`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id_equipamento`, `nome_equipamento`, `tipo_equipamento`, `quantidade_equipamento`, `quantidade_disponivel_equipamento`, `data_cadastro_equipamento`, `status_equipamento`) VALUES
(1, 'T4', 'Carregador', 34, 1, '0000-00-00 00:00:00', 0),
(2, 'Cassetete', 'Bastao', 50, 1, '0000-00-00 00:00:00', 0),
(4, 'Capacete', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(6, '12GA', 'Municao', 800, 50, '0000-00-00 00:00:00', 0),
(7, '9mm', 'Municao', 800, 0, '0000-00-00 00:00:00', 0),
(8, '5,56x45mm', 'Municao', 1000, 80, '0000-00-00 00:00:00', 0),
(9, 'Escudo', 'Disturbios', 80, 0, '0000-00-00 00:00:00', 0),
(10, 'Granada', 'Disturbios', 50, 0, '0000-00-00 00:00:00', 0);

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
(1, 'Oxford', 'Apoio a Outro Órgão', 'Itaqui', 'Birubiri', '2025-05-26 15:00:00', 'Em Andamento'),
(3, 'Mijunomuro', 'Patrulhamento', 'Uruguaiana - Cohab 2', 'Subiro', '2025-05-26 15:05:00', 'Concluída');

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `solicitacao_itens`
--

INSERT INTO `solicitacao_itens` (`id_solicitacao_itens`, `id_usuario`, `motivo_solicitacao`, `data_solicitacao`, `data_devolucao_item`, `status_solicitacao`, `observacao_item`, `id_item`, `tipo_item`, `quantidade`, `id_solicitacao`) VALUES
(1, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 3, 'armamento', 0, 4),
(2, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 4, 'armamento', 0, 4),
(3, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 5, 'armamento', 0, 4),
(4, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 6, 'armamento', 0, 4),
(5, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 1, 'equipamento', 0, 4),
(6, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 2, 'equipamento', 0, 4),
(7, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 3, 'armamento', 0, 4),
(8, 1, 'a', '2025-06-09 00:00:00', '2025-06-26', 'Aceito', '', 5, 'armamento', 0, 4),
(11, 1, 'a', '2025-06-10 00:00:00', '2025-06-26', 'Aceito', '', 3, 'armamento', 0, 3),
(12, 1, 'a', '2025-06-10 00:00:00', '2025-06-26', 'Aceito', '', 5, 'armamento', 0, 3),
(13, 1, 'a', '2025-06-10 00:00:00', '2025-06-26', 'Aceito', '', 6, 'armamento', 0, 3),
(14, 1, 'a', '2025-06-10 00:00:00', '2025-06-26', 'Aceito', '', 2, 'equipamento', 0, 3),
(15, 1, 'a', '2025-06-10 00:00:00', '2025-06-26', 'Aceito', '', 1, 'equipamento', 0, 3),
(16, 1, '', '2025-06-17 00:00:00', '0000-00-00', 'Aceito', '', 4, 'armamento', 0, 2),
(17, 1, '', '2025-06-17 00:00:00', '0000-00-00', 'Aceito', '', 5, 'armamento', 0, 2),
(18, 1, '', '2025-06-17 00:00:00', '0000-00-00', 'Aceito', '', 2, 'equipamento', 0, 2),
(19, 1, '', '2025-06-17 00:00:00', '0000-00-00', 'Aceito', '', 7, 'equipamento', 0, 2),
(20, 1, 'a', '2025-06-19 00:00:00', '2025-06-27', 'Pendente', '', 3, 'armamento', 0, 1),
(21, 1, 'a', '2025-06-19 00:00:00', '2025-06-27', 'Pendente', '', 5, 'armamento', 0, 1),
(22, 1, 'a', '2025-06-19 00:00:00', '2025-06-27', 'Pendente', '', 4, 'equipamento', 0, 1),
(23, 1, 'a', '2025-06-19 00:00:00', '2025-06-27', 'Pendente', '', 9, 'equipamento', 0, 1),
(24, 1, '', '2025-06-19 00:00:00', '0000-00-00', 'Pendente', '', 3, 'armamento', 0, 1),
(25, 1, 'a', '2025-06-26 00:00:00', '2025-06-07', 'Aceito', '', 3, 'armamento', 0, 1750965991),
(26, 1, 'a', '2025-06-26 00:00:00', '2025-06-07', 'Aceito', '', 1, 'equipamento', 0, 1750965991),
(27, 1, 'a', '2025-06-26 00:00:00', '2025-06-07', 'Aceito', '', 2, 'equipamento', 0, 1750965991),
(28, 1, '', '2025-07-04 00:00:00', '0000-00-00', 'Pendente', '', 5, 'armamento', 0, 1751663971),
(29, 1, '', '2025-07-04 00:00:00', '0000-00-00', 'Pendente', '', 3, 'armamento', 0, 1751663971),
(30, 1, 'a', '2025-07-07 00:00:00', '2025-07-31', 'Pendente', '', 3, 'armamento', 0, 1751914370),
(31, 1, 'a', '2025-07-07 00:00:00', '2025-07-31', 'Pendente', '', 6, 'armamento', 0, 1751914370),
(32, 1, 'a', '2025-07-07 00:00:00', '2025-07-31', 'Pendente', '', 2, 'equipamento', 0, 1751914370),
(33, 1, 'a', '2025-07-07 00:00:00', '2025-07-31', 'Pendente', '', 7, 'equipamento', 0, 1751914370),
(34, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 3, 'armamento', 0, 1751917274),
(35, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 5, 'armamento', 0, 1751917274),
(36, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 4, 'equipamento', 0, 1751917274),
(37, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 9, 'equipamento', 0, 1751917274),
(38, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 2, 'equipamento', 0, 1751917274),
(39, 1, 'a', '2025-07-07 00:00:00', '2025-07-25', 'Pendente', '', 3, 'armamento', 0, 1751917416),
(40, 1, 'a', '2025-07-07 00:00:00', '2025-07-25', 'Pendente', '', 5, 'armamento', 0, 1751917416),
(41, 1, 'a', '2025-07-07 00:00:00', '2025-07-25', 'Pendente', '', 1, 'equipamento', 0, 1751917416),
(42, 1, 'a', '2025-07-07 00:00:00', '2025-07-25', 'Pendente', '', 2, 'equipamento', 0, 1751917416),
(43, 1, 'a', '2025-07-07 00:00:00', '2025-07-25', 'Pendente', '', 9, 'equipamento', 0, 1751917416),
(44, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 4, 'armamento', 0, 1751918322),
(45, 1, 'a', '2025-07-07 00:00:00', '2025-07-23', 'Pendente', '', 3, 'armamento', 0, 1751918322),
(46, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Pendente', '', 5, 'armamento', 0, 1752189632),
(47, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Pendente', '', 5, 'armamento', 0, 1752189869),
(48, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Pendente', '', 5, 'armamento', 0, 1752189887),
(49, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Pendente', '', 5, 'armamento', 0, 1752189896),
(50, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Negado', '', 5, 'armamento', 0, 1752189962),
(51, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Negado', '', 6, 'equipamento', 30, 1752189962),
(52, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Aceito', '', 5, 'armamento', 1, 1752190314),
(53, 1, 'a', '2025-07-10 00:00:00', '2025-07-11', 'Aceito', '', 6, 'equipamento', 50, 1752190314),
(54, 1, 'b', '2025-07-10 00:00:00', '2025-07-31', 'Aceito', '', 3, 'armamento', 1, 1752190726),
(55, 1, 'b', '2025-07-10 00:00:00', '2025-07-31', 'Aceito', '', 8, 'equipamento', 80, 1752190726);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `identidade_funcional_usuario`, `email_usuario`, `senha_usuario`, `perfil_usuario`, `data_cadastro_usuario`) VALUES
(1, 'Usuário Teste', 1234, 'teste@teste.com', '1234', 1, '0000-00-00 00:00:00');

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
