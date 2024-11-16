-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/11/2024 às 15:29
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_oferta`
--
DROP DATABASE IF EXISTS `db_oferta`;
CREATE DATABASE IF NOT EXISTS `db_oferta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_oferta`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `filial_produto`
--

CREATE TABLE `filial_produto` (
  `fk_produto` int(11) NOT NULL,
  `fk_filial` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `filial_produto`
--

INSERT INTO `filial_produto` (`fk_produto`, `fk_filial`, `status`) VALUES
(1, 1, 1),
(4, 1, 1),
(11, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_filial`
--

CREATE TABLE `tb_filial` (
  `id_filial` int(11) NOT NULL,
  `filial` varchar(2) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_filial`
--

INSERT INTO `tb_filial` (`id_filial`, `filial`, `uf`, `status`) VALUES
(1, 'CP', 'PR', 1),
(2, 'NV', 'MS', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_preco`
--

CREATE TABLE `tb_preco` (
  `id_preco` int(11) NOT NULL,
  `tipo_venda` int(1) NOT NULL DEFAULT 1,
  `valor` double(7,2) NOT NULL,
  `quantidade` int(3) NOT NULL DEFAULT 1,
  `uf` varchar(2) NOT NULL,
  `fk_produto` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_preco`
--

INSERT INTO `tb_preco` (`id_preco`, `tipo_venda`, `valor`, `quantidade`, `uf`, `fk_produto`, `status`) VALUES
(1, 1, 100.90, 1, 'PR', 1, 1),
(2, 1, 110.90, 1, 'MS', 1, 1),
(11, 2, 100.90, 1, 'PR', 4, 1),
(12, 2, 110.90, 1, 'MS', 4, 1),
(13, 2, 95.90, 2, 'PR', 4, 1),
(14, 2, 105.90, 2, 'MS', 4, 1),
(15, 2, 90.90, 3, 'PR', 4, 1),
(16, 2, 100.90, 3, 'MS', 4, 1),
(17, 1, 100.90, 1, 'PR', 5, 1),
(18, 1, 110.90, 1, 'MS', 5, 1),
(19, 2, 53.85, 1, 'PR', 6, 1),
(20, 2, 56.78, 1, 'MS', 6, 1),
(21, 2, 52.50, 2, 'PR', 6, 1),
(22, 2, 55.40, 2, 'MS', 6, 1),
(23, 2, 51.30, 3, 'PR', 6, 1),
(24, 2, 54.80, 3, 'MS', 6, 1),
(25, 1, 110.90, 1, 'PR', 7, 1),
(26, 1, 125.90, 1, 'MS', 7, 1),
(27, 1, 110.90, 1, 'PR', 8, 1),
(28, 1, 125.90, 1, 'MS', 8, 1),
(29, 1, 10.90, 1, 'PR', 9, 1),
(30, 1, 12.90, 1, 'MS', 9, 1),
(31, 1, 10.90, 1, 'PR', 10, 1),
(32, 1, 12.90, 1, 'MS', 10, 1),
(33, 2, 100.90, 1, 'PR', 11, 1),
(34, 2, 110.90, 1, 'MS', 11, 1),
(35, 2, 90.90, 2, 'PR', 11, 1),
(36, 2, 100.90, 2, 'MS', 11, 1),
(37, 2, 80.90, 3, 'PR', 11, 1),
(38, 2, 90.90, 3, 'MS', 11, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_produto`
--

CREATE TABLE `tb_produto` (
  `id_produto` int(11) NOT NULL,
  `cod_produto` int(5) NOT NULL,
  `desc_produto` varchar(100) NOT NULL,
  `tipo_produto` int(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `cod_produto`, `desc_produto`, `tipo_produto`, `status`) VALUES
(1, 11111, 'PRODUTO UNITARIO', 6, 1),
(4, 22222, 'PRODUTO QUANTIDADE', 1, 1),
(5, 33333, 'PRODUTO', 1, 1),
(6, 44444, 'REBIMBOCA DA PARAFUSETA', 8, 1),
(7, 12345, 'PARAFUSETA DA REBIMBOCA', 1, 1),
(8, 12345, 'PARAFUSETA DA REBIMBOCA', 1, 1),
(9, 99999, 'PRODUTO TESTE 999', 1, 1),
(10, 99999, 'PRODUTO TESTE 999', 1, 1),
(11, 11150, 'MACACO HIDRAULICO', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `filial_produto`
--
ALTER TABLE `filial_produto`
  ADD KEY `fk_filial` (`fk_filial`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices de tabela `tb_filial`
--
ALTER TABLE `tb_filial`
  ADD PRIMARY KEY (`id_filial`);

--
-- Índices de tabela `tb_preco`
--
ALTER TABLE `tb_preco`
  ADD PRIMARY KEY (`id_preco`),
  ADD KEY `fk_produto` (`fk_produto`);

--
-- Índices de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_filial`
--
ALTER TABLE `tb_filial`
  MODIFY `id_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_preco`
--
ALTER TABLE `tb_preco`
  MODIFY `id_preco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `filial_produto`
--
ALTER TABLE `filial_produto`
  ADD CONSTRAINT `filial_produto_ibfk_1` FOREIGN KEY (`fk_filial`) REFERENCES `tb_filial` (`id_filial`),
  ADD CONSTRAINT `filial_produto_ibfk_2` FOREIGN KEY (`fk_produto`) REFERENCES `tb_produto` (`id_produto`);

--
-- Restrições para tabelas `tb_preco`
--
ALTER TABLE `tb_preco`
  ADD CONSTRAINT `tb_preco_ibfk_1` FOREIGN KEY (`fk_produto`) REFERENCES `tb_produto` (`id_produto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
