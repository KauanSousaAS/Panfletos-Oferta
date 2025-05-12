-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/05/2025 às 19:54
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
(2, 'RD', 'PR', 1),
(3, 'MX', 'PR', 1),
(4, 'NV', 'MS', 1),
(5, 'NA', 'MS', 1);

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
  MODIFY `id_filial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_preco`
--
ALTER TABLE `tb_preco`
  MODIFY `id_preco` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_produto`
--
ALTER TABLE `tb_produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT;

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
