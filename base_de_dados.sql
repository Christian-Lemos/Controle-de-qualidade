-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01-Dez-2017 às 21:08
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `compa806_qualidade`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `encontrarnomeusuario` (`idgerente` INT) RETURNS VARCHAR(50) CHARSET latin1 BEGIN
	DECLARE med varchar(50);
	SELECT nome INTO med from usuario WHERE id = idgerente;
    RETURN med;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `descricao` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `inspecao`
--

CREATE TABLE `inspecao` (
  `id` int(11) NOT NULL,
  `projeto` int(11) NOT NULL,
  `nome` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_inspecao`
--

CREATE TABLE `item_inspecao` (
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
-- Estrutura da tabela `item_inspecao_dev`
--

CREATE TABLE `item_inspecao_dev` (
  `iditem` int(11) NOT NULL DEFAULT '0',
  `idusuario` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_persona`
--

CREATE TABLE `item_persona` (
  `iditem` int(11) NOT NULL,
  `idpersona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `id` int(11) NOT NULL,
  `gerente` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datainicio` date NOT NULL,
  `datatermino` date DEFAULT NULL,
  `nomegerente` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Acionadores `projeto`
--
DELIMITER $$
CREATE TRIGGER `projeto_atualiza_gerente` BEFORE UPDATE ON `projeto` FOR EACH ROW begin 

if NEW.gerente != OLD.gerente then
	set new.nomegerente = encontrarnomeusuario(new.gerente);
end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_de_inserir_projeto` BEFORE INSERT ON `projeto` FOR EACH ROW begin 

	set new.nomegerente = encontrarnomeusuario(new.gerente);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto_dev`
--

CREATE TABLE `projeto_dev` (
  `idprojeto` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `nomeusuario` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Acionadores `projeto_dev`
--
DELIMITER $$
CREATE TRIGGER `projeto_dev_atualiza_nome_dev` BEFORE UPDATE ON `projeto_dev` FOR EACH ROW begin
	if new.idusuario != old.idusuario THEN
		set new.nomeusuario = encontrarnomeusuario(new.idusuario);
	end if;
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `projeto_dev_insere_nome_dev` BEFORE INSERT ON `projeto_dev` FOR EACH ROW begin
	set new.nomeusuario = encontrarnomeusuario(new.idusuario);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nome`, `email`, `admin`) VALUES
(47, 'windrider', '$2y$10$EPpZTu5U2pmR3HMagy0ppefdNy7g3tHGWBv1ryxWSkqcomlch8arO', 'Christian Lemos', 'christian@compactjr.com', 1),
(49, 'cara1', '$2y$10$nXCwFFqmM.9g69BnCntQKOuGGkHrwhbk08TRaqXSreuILDc1QbNIi', 'cara1', 'cara1@123.com', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_tentativas`
--

CREATE TABLE `usuario_tentativas` (
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tentativas` int(11) NOT NULL,
  `data_hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspecao`
--
ALTER TABLE `inspecao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projeto` (`projeto`);

--
-- Indexes for table `item_inspecao`
--
ALTER TABLE `item_inspecao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ii_idprojeto` (`idprojeto`),
  ADD KEY `fk_ii_idcategoria` (`idcategoria`);

--
-- Indexes for table `item_inspecao_dev`
--
ALTER TABLE `item_inspecao_dev`
  ADD PRIMARY KEY (`iditem`,`idusuario`),
  ADD KEY `fk_iid_idusuario` (`idusuario`);

--
-- Indexes for table `item_persona`
--
ALTER TABLE `item_persona`
  ADD PRIMARY KEY (`iditem`,`idpersona`),
  ADD KEY `fk_ip_idpersona` (`idpersona`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gerente` (`gerente`);

--
-- Indexes for table `projeto_dev`
--
ALTER TABLE `projeto_dev`
  ADD PRIMARY KEY (`idprojeto`,`idusuario`),
  ADD KEY `fk_pdev_idusuario` (`idusuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `usuario_tentativas`
--
ALTER TABLE `usuario_tentativas`
  ADD PRIMARY KEY (`ip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `inspecao`
--
ALTER TABLE `inspecao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_inspecao`
--
ALTER TABLE `item_inspecao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `inspecao`
--
ALTER TABLE `inspecao`
  ADD CONSTRAINT `fk_projeto` FOREIGN KEY (`projeto`) REFERENCES `projeto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `item_inspecao`
--
ALTER TABLE `item_inspecao`
  ADD CONSTRAINT `fk_ii_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ii_idprojeto` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `item_inspecao_dev`
--
ALTER TABLE `item_inspecao_dev`
  ADD CONSTRAINT `fk_iid_idtiem` FOREIGN KEY (`iditem`) REFERENCES `item_inspecao` (`id`),
  ADD CONSTRAINT `fk_iid_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `item_persona`
--
ALTER TABLE `item_persona`
  ADD CONSTRAINT `fk_ip_iditem` FOREIGN KEY (`iditem`) REFERENCES `item_inspecao` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ip_idpersona` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `fk_gerente` FOREIGN KEY (`gerente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `projeto_dev`
--
ALTER TABLE `projeto_dev`
  ADD CONSTRAINT `fk_pdev_idprojeto` FOREIGN KEY (`idprojeto`) REFERENCES `projeto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pdev_idusuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
