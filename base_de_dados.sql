-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 09/11/2017 às 10:07
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `projeto`
--

INSERT INTO `projeto` (`id`, `gerente`, `nome`, `datainicio`, `datatermino`, `nomegerente`) VALUES
(36, 26, 'Christian Lemos', '2017-11-08', NULL, 'Eduardo Lara'),
(37, 26, 'Tower Service', '2017-10-12', NULL, 'Eduardo Lara'),
(38, 30, 'Teste', '2017-11-08', NULL, 'Giancarlo Ribeiro'),
(39, 16, 'Termo Frio', '2017-11-07', NULL, 'RenÃ© Ferarri');

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

--
-- Fazendo dump de dados para tabela `projeto_dev`
--

INSERT INTO `projeto_dev` (`idprojeto`, `idusuario`) VALUES
(36, 18),
(37, 18),
(39, 18),
(37, 19),
(36, 20),
(39, 21);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nome`, `email`, `admin`) VALUES
(15, 'windrider', 'be6c6b21a2c83cd6b6b410cb98ef2d7c4b2596d5c586d72f8ca6be64c00df2f65df29692ec4b74b8f27e8c643a90a68192853e48f23833de30b9c9361d2cdd45', 'Christian Lemos', 'christian@compactjr.com', 1),
(16, 'rene', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'RenÃ© Ferarri', 'rene@compactjr.com', 0),
(17, 'adriana', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Adriana Soares', 'adriana@compactjr.com', 0),
(18, 'xandao', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Alexandre Medina', 'alexandre@compactjr.com', 0),
(19, 'rovadder', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Arthur Rovedder', 'arthurrovedder@compactjr.com', 0),
(20, 'soccal', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Bernardo  Soccal', 'bernardo.soccal@compactjr.com', 0),
(21, 'bernardo', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Bernardo da Costa', 'bernardosidom@hotmail.com', 0),
(22, 'coletto', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Carlos Coletto', 'carlos@compactjr.com', 0),
(23, 'christo', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Douglas Christo', 'douglas@compactjr.com', 0),
(24, 'nedel', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Eduardo Nedel', 'eduardo.nedel@compactjr.com', 0),
(25, 'hirt', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Eduardo Hirt', 'eduardohirt@compactjr.com', 0),
(26, 'lara', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Eduardo Lara', 'eduardoschmlara@compactjr.com', 0),
(27, 'edyson', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Edyson Sebastiany', 'edyson@compactjr.com', 0),
(28, 'fernanda', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Fernanda Rieffel', 'fernanda@compactjr.com', 0),
(29, 'doyle', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Gabriel Balk', 'gabriel.doyle@compactjr.com', 0),
(30, 'giancarlo', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Giancarlo Ribeiro', 'giancarlo@compactjr.com', 0),
(31, 'sacchet', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Giovanni Sacchet', 'giovanni@compactjr.com', 0),
(32, 'giu', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Giuliano Benedetti', 'giuliano@compactjr.com', 0),
(33, 'martins', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Henrique Martins', 'henrique@compactjr.com', 0),
(34, 'stalker', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Henrique Rodrigues', 'henrique.rodrigres@compactjr.com', 0),
(35, 'isadora', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Isadora Stangarlin', 'isadora@compactjr.com', 0),
(36, 'jennifer', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Jennifer Carvalho', 'jennifer@compactjr.com', 0),
(37, 'victor', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'JosÃ© Viriato', 'jose@compactjr.com', 0),
(38, 'joao', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'JoÃ£o VÃ­tor', 'joao.magalhaes@compactjr.com', 0),
(39, 'kelvin', '05df7da6cbbba6e72e05f85fe2557a83894d128c1b4b82ee30881c47c130bf2c42fb6933415ece42185a26694874e35e85c2d6c9949bb7df31930d862edbb5f3', 'Kelvin Pirolla', 'kelvin@compactjr.com', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
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
