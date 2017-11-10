-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 10/11/2017 às 09:35
-- Versão do servidor: 5.5.51-38.2
-- Versão do PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `compa806_qualidade`
--

DELIMITER $$
--
-- Funções
--
CREATE DEFINER=`compa806`@`localhost` FUNCTION `encontrarnomegerente`(idgerente int) RETURNS varchar(50) CHARSET utf8 COLLATE utf8_unicode_ci
BEGIN
	DECLARE med varchar(50);
	SELECT nome INTO med from usuario WHERE id = idgerente;
    RETURN med;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL,
  `descricao` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inspecao`
--

CREATE TABLE IF NOT EXISTS `inspecao` (
  `id` int(11) NOT NULL,
  `projeto` int(11) NOT NULL,
  `nome` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_inspecao`
--

CREATE TABLE IF NOT EXISTS `item_inspecao` (
  `id` int(11) NOT NULL,
  `idprojeto` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `local_problema` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `problema` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `solucao` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `obs` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prioridade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_inspecao_dev`
--

CREATE TABLE IF NOT EXISTS `item_inspecao_dev` (
  `iditem` int(11) NOT NULL DEFAULT '0',
  `idusuario` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `item_persona`
--

CREATE TABLE IF NOT EXISTS `item_persona` (
  `iditem` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto`
--

CREATE TABLE IF NOT EXISTS `projeto` (
  `id` int(11) NOT NULL,
  `gerente` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datainicio` date NOT NULL,
  `datatermino` date DEFAULT NULL,
  `nomegerente` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gatilhos `projeto`
--
DELIMITER $$
CREATE TRIGGER `projeto_atualiza_gerente` BEFORE UPDATE ON `projeto`
 FOR EACH ROW begin 

if NEW.gerente != OLD.gerente then
	set new.nomegerente = encontrarnomegerente(new.gerente);
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_de_inserir_projeto` BEFORE INSERT ON `projeto`
 FOR EACH ROW begin 

	set new.nomegerente = encontrarnomegerente(new.gerente);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto_dev`
--

CREATE TABLE IF NOT EXISTS `projeto_dev` (
  `idprojeto` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nome`, `email`, `admin`) VALUES
(47, 'windrider', '$2y$10$EPpZTu5U2pmR3HMagy0ppefdNy7g3tHGWBv1ryxWSkqcomlch8arO', 'Christian Lemos', 'christian@compactjr.com', 1),
(48, 'cara2', '$2y$10$3OERU4ncW6gyfNw5CakUjeSZeOk8t4m.aPCdYik/DvU.uDd9mDNVa', 'teste', 'christian2@compactjr.com', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_tentativas`
--

CREATE TABLE IF NOT EXISTS `usuario_tentativas` (
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tentativas` int(11) NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `inspecao`
--
ALTER TABLE `inspecao`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_projeto` (`projeto`);

--
-- Índices de tabela `item_inspecao`
--
ALTER TABLE `item_inspecao`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_ii_idprojeto` (`idprojeto`), ADD KEY `fk_ii_idcategoria` (`idcategoria`);

--
-- Índices de tabela `item_inspecao_dev`
--
ALTER TABLE `item_inspecao_dev`
  ADD PRIMARY KEY (`iditem`,`idusuario`), ADD KEY `fk_iid_idusuario` (`idusuario`);

--
-- Índices de tabela `item_persona`
--
ALTER TABLE `item_persona`
  ADD PRIMARY KEY (`iditem`,`idpersona`), ADD KEY `fk_ip_idpersona` (`idpersona`);

--
-- Índices de tabela `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_gerente` (`gerente`);

--
-- Índices de tabela `projeto_dev`
--
ALTER TABLE `projeto_dev`
  ADD PRIMARY KEY (`idprojeto`,`idusuario`), ADD KEY `fk_pdev_idusuario` (`idusuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`), ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuario_tentativas`
--
ALTER TABLE `usuario_tentativas`
  ADD PRIMARY KEY (`ip`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `inspecao`
--
ALTER TABLE `inspecao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `item_inspecao`
--
ALTER TABLE `item_inspecao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `inspecao`
--
ALTER TABLE `inspecao`
ADD CONSTRAINT `fk_projeto` FOREIGN KEY (`projeto`) REFERENCES `projeto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `item_inspecao`
--
ALTER TABLE `item_inspecao`
ADD CONSTRAINT `fk_ii_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_ii_idprojeto` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `item_inspecao_dev`
--
ALTER TABLE `item_inspecao_dev`
ADD CONSTRAINT `fk_iid_idtiem` FOREIGN KEY (`iditem`) REFERENCES `item_inspecao` (`id`),
ADD CONSTRAINT `fk_iid_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `item_persona`
--
ALTER TABLE `item_persona`
ADD CONSTRAINT `fk_ip_idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_ip_iditem` FOREIGN KEY (`iditem`) REFERENCES `item_inspecao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `projeto`
--
ALTER TABLE `projeto`
ADD CONSTRAINT `fk_gerente` FOREIGN KEY (`gerente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `projeto_dev`
--
ALTER TABLE `projeto_dev`
ADD CONSTRAINT `fk_pdev_idprojeto` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_pdev_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
