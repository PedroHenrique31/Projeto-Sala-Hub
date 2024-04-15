-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Dez-2022 às 05:32
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6


create schema main_hub;
use main_hub;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `main_hub`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbagenda`
--

CREATE TABLE `tbagenda` (
  `idAgenda` int(11) NOT NULL,
  `nomeAgenda` varchar(200) NOT NULL,
  `atividadeAgenda` varchar(500) NOT NULL,
  `cursoAgenda` varchar(100) NOT NULL,
  `dataAgenda` date NOT NULL,
  `horaAgenda` time NOT NULL,
  `bancadaTechAgenda` int(11) NOT NULL,
  `bancadaGeralAgenda` int(11) NOT NULL,
  `idMonitor` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbagenda`
--

INSERT INTO `tbagenda` (`idAgenda`, `nomeAgenda`, `atividadeAgenda`, `cursoAgenda`, `dataAgenda`, `horaAgenda`, `bancadaTechAgenda`, `bancadaGeralAgenda`, `idMonitor`, `idUsuario`) VALUES
(104, 'Administrador', 'Experimentos', 'Marketing', '2022-12-20', '11:00:00', 1, 0, 2, 1),
(105, 'Administrador', 'Experimentos', 'Marketing', '2022-12-15', '10:00:00', 1, 0, 3, 1),
(106, 'Administrador', 'Tarefas', 'Medicina Veterinária', '2022-12-29', '09:00:00', 1, 2, 3, 1),
(107, 'Administrador', 'Imprimir 3D', 'Jornalismo', '2022-12-27', '09:00:00', 2, 0, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbarquivos`
--

CREATE TABLE `tbarquivos` (
  `idArquivo` int(11) NOT NULL,
  `nomeArquivo` varchar(200) NOT NULL,
  `idSeuProjeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbarquivos`
--

INSERT INTO `tbarquivos` (`idArquivo`, `nomeArquivo`, `idSeuProjeto`) VALUES
(1, '778705058_PDF_Teste.pdf', 3),
(2, '293482473_PDF_Teste.pdf', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbimagens`
--

CREATE TABLE `tbimagens` (
  `idImagem` int(11) NOT NULL,
  `nomeImagem` varchar(200) NOT NULL,
  `idSeuProjeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbimagens`
--

INSERT INTO `tbimagens` (`idImagem`, `nomeImagem`, `idSeuProjeto`) VALUES
(3, '50662410_daria-nepriakhina-xY55bL5mZAM-unsplash.jpg', 2),
(4, '232255016_fang-wei-lin-H1IRUS1vEFA-unsplash.jpg', 2),
(5, '665488559_olesia-buyar-ZD03qVhBJZg-unsplash.jpg', 2),
(6, '2002872864_studio-media-9DaOYUYnOls-unsplash.jpg', 2),
(8, '1904959419_denys-nevozhai-z0nVqfrOqWA-unsplash.jpg', 3),
(9, '1104774517_olga-nayda-3TQ8I-sR9a8-unsplash.jpg', 3),
(10, '1838473100_jon-flobrant-_r19nfvS3wY-unsplash.jpg', 3),
(11, '632136231_nong-v-qwvv5QD0It0-unsplash.jpg', 5),
(14, '1574914539_1864543974_pexels-alena-darmel-7750732.jpg', 1),
(15, '1416579270_1426472117_pexels-alena-darmel-7750757.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbimpressora`
--

CREATE TABLE `tbimpressora` (
  `idImpressora` int(11) NOT NULL,
  `nomeImpressora` varchar(200) NOT NULL,
  `cursoImpressora` varchar(100) NOT NULL,
  `semestreImpressora` int(11) NOT NULL,
  `dataImpressora` date NOT NULL,
  `deHoraImpressora` time NOT NULL,
  `ateHoraImpressora` time NOT NULL,
  `qualImpressora` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbimpressora`
--

INSERT INTO `tbimpressora` (`idImpressora`, `nomeImpressora`, `cursoImpressora`, `semestreImpressora`, `dataImpressora`, `deHoraImpressora`, `ateHoraImpressora`, `qualImpressora`, `idUsuario`) VALUES
(3, 'Administrador', 'Direito', 8, '2022-12-07', '12:00:00', '15:00:00', 1, 1),
(4, 'Administrador', 'Ciências Contábeis', 3, '2022-12-07', '13:00:00', '16:00:00', 2, 1),
(6, 'Administrador', 'Enfermagem', 7, '2022-12-07', '11:00:00', '12:00:00', 2, 1),
(7, 'Administrador', 'Ciência da Computação', 5, '2022-12-08', '10:00:00', '18:00:00', 1, 1),
(8, 'Administrador', 'Biomedicina', 5, '2022-12-06', '13:00:00', '19:00:00', 2, 1),
(10, 'Administrador', 'Ciência da Computação', 4, '2022-12-06', '08:00:00', '09:00:00', 1, 1),
(11, 'Administrador', 'Educação Física', 6, '2022-12-06', '08:00:00', '09:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbmonitor`
--

CREATE TABLE `tbmonitor` (
  `idMonitor` int(11) NOT NULL,
  `nomeMonitor` varchar(200) NOT NULL,
  `telefoneMonitor` varchar(20) NOT NULL,
  `deHoraMonitor` time NOT NULL,
  `ateHoraMonitor` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbmonitor`
--

INSERT INTO `tbmonitor` (`idMonitor`, `nomeMonitor`, `telefoneMonitor`, `deHoraMonitor`, `ateHoraMonitor`) VALUES
(1, 'Joaquim', '61922232322', '10:00:00', '12:00:00'),
(2, 'João Paulo Neves', '61822882284', '09:00:00', '13:00:00'),
(3, 'Miguel Santos Pereira', '61987653232', '10:00:00', '13:00:00'),
(5, 'Fernanda Carolina', '11942365458', '15:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbprojetos`
--

CREATE TABLE `tbprojetos` (
  `idProjetos` int(11) NOT NULL,
  `nomeProjetos` varchar(50) NOT NULL,
  `autoresProjetos` varchar(500) NOT NULL,
  `cursoProjetos` varchar(50) NOT NULL,
  `semestreProjetos` int(11) NOT NULL,
  `orientadorProjetos` varchar(50) NOT NULL,
  `resumoProjetos` varchar(2500) NOT NULL,
  `usuarioIdProjetos` int(11) NOT NULL,
  `visivelProjetos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tbprojetos`
--

INSERT INTO `tbprojetos` (`idProjetos`, `nomeProjetos`, `autoresProjetos`, `cursoProjetos`, `semestreProjetos`, `orientadorProjetos`, `resumoProjetos`, `usuarioIdProjetos`, `visivelProjetos`) VALUES
(1, 'Criação de Lego robô', 'Mariana de Souza', 'Biomedicina', 5, 'Gustavo Lima', 'Foi feito um projeto onde montamos um Lego robô que pode detectar calor pelas proximidades.', 1, 0),
(2, 'Coleção de livros', 'Daria Nepria', 'Direito', 4, 'João Neves', 'Coleção de livros onde podemos visualizar várias imagens e letras através dos projetos criados pelo Sistema Sala HUB.', 1, 0),
(3, 'Atlas of Critical Care', 'Mehta Yatin', 'Nutrição', 8, 'Sharma Jeetendra', 'The aim of this atlas book is to focus on the critical care. Critical Care Medicine is a very demanding specialty. It is also rapidly developing and evolving. It is an extremely dynamic field of medicine with a very hectic pace. This book consists of 8 sections that include airway management, respiratory system, cardiology, gastroenterology, neurology, trauma, microbiology, and miscellaneous. Traditionally, the compilation of the training material was collected in textbooks and the textbooks consisted of chapters of written words. With the decline of attention spans of readers and the available time, the need for pictorial assistance has increased. The book has 26 chapters with 1000 images. Visual images always leave a long impression on the mind and their recollection is better. With critical care services increasing exponentially in India and the atmosphere against high end medicine in public and political circles, this book will certainly help in educating critical care and other specialty doctors regarding this vast and expanding field.', 2, 0),
(4, 'Projeto com Imagem Padrão', 'Pedro Borin', 'Marketing', 3, 'Francisco Javier', 'O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum.\r\nAo contrário da crença popular, o Lorem Ipsum não é simplesmente texto aleatório. Tem raízes numa peça de literatura clássica em Latim, de 45 AC, tornando-o com mais de 2000 anos. Richard McClintock, um professor de Latim no Colégio Hampden-Sydney, na Virgínia, procurou uma das palavras em Latim mais obscuras (consectetur) numa passagem Lorem Ipsum, e atravessando as cidades do mundo na literatura clássica, descobriu a sua origem. Lorem Ipsum vem das secções 1.10.32 e 1.10.33 do \"de Finibus Bonorum et Malorum\" (Os Extremos do Bem e do Mal), por Cícero, escrito a 45AC. Este livro é um tratado na teoria da ética, muito popular durante a Renascença. A primeira linha de Lorem Ipsum, \"Lorem ipsum dolor sit amet...\" aparece de uma linha na secção 1.10.32.', 3, 0),
(5, 'Quinto projeto para mostrar quebra de cards', 'Autor X', 'Direito', 3, 'Orientador X', 'Existem muitas variações das passagens do Lorem Ipsum disponíveis, mas a maior parte sofreu alterações de alguma forma, pela injecção de humor, ou de palavras aleatórias que nem sequer parecem suficientemente credíveis. Se vai usar uma passagem do Lorem Ipsum, deve ter a certeza que não contém nada de embaraçoso escondido no meio do texto. Todos os geradores de Lorem Ipsum na Internet acabam por repetir porções de texto pré-definido, como necessário, fazendo com que este seja o primeiro verdadeiro gerador na Internet. Usa um dicionário de 200 palavras em Latim, combinado com uma dúzia de modelos de frases, para gerar Lorem Ipsum que pareçam razoáveis. Desta forma, o Lorem Ipsum gerado é sempre livre de repetição, ou de injecção humorística, etc.', 2, 0),
(6, 'Titulo A', 'Autor A', 'Fisioterapia', 6, 'Orientador A', 'Resumo A', 3, 0),
(7, 'asdasd', 'sadsad', 'Marketing', 3, 'adsasdsd', 'sadsad', 2, 1),
(8, 'asdasdasd', 'asdasd', 'Engenharia Elétrica', 2, 'asdasd', 'asdasd', 1, 1),
(9, 'dasdas', 'dsadsa', 'Marketing', 3, 'dasasd', 'adssad', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario` varchar(200) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `administrador` int(11) NOT NULL,
  `dataLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario`, `nome`, `senha`, `administrador`, `dataLogin`) VALUES
(1, 'admin', 'Administrador', '202cb962ac59075b964b07152d234b70', 1, '2022-12-07 00:14:33'),
(2, 'maria', 'Maria da Silva', '202cb962ac59075b964b07152d234b70', 0, '2022-12-06 21:08:38'),
(3, 'wesley', 'Wesley Moreira', '06afa6c8b54d3cc80d269379d8b6a078', 1, '2022-11-22 00:43:16');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tbagenda`
--
ALTER TABLE `tbagenda`
  ADD PRIMARY KEY (`idAgenda`);

--
-- Índices para tabela `tbarquivos`
--
ALTER TABLE `tbarquivos`
  ADD PRIMARY KEY (`idArquivo`);

--
-- Índices para tabela `tbimagens`
--
ALTER TABLE `tbimagens`
  ADD PRIMARY KEY (`idImagem`);

--
-- Índices para tabela `tbimpressora`
--
ALTER TABLE `tbimpressora`
  ADD PRIMARY KEY (`idImpressora`);

--
-- Índices para tabela `tbmonitor`
--
ALTER TABLE `tbmonitor`
  ADD PRIMARY KEY (`idMonitor`);

--
-- Índices para tabela `tbprojetos`
--
ALTER TABLE `tbprojetos`
  ADD PRIMARY KEY (`idProjetos`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbagenda`
--
ALTER TABLE `tbagenda`
  MODIFY `idAgenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de tabela `tbarquivos`
--
ALTER TABLE `tbarquivos`
  MODIFY `idArquivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbimagens`
--
ALTER TABLE `tbimagens`
  MODIFY `idImagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tbimpressora`
--
ALTER TABLE `tbimpressora`
  MODIFY `idImpressora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tbmonitor`
--
ALTER TABLE `tbmonitor`
  MODIFY `idMonitor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbprojetos`
--
ALTER TABLE `tbprojetos`
  MODIFY `idProjetos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
