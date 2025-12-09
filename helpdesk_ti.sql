-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 09/12/2025 às 01:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `helpdesk_ti`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `prioridade` enum('baixa','media','alta') DEFAULT 'baixa',
  `status` enum('aberto','andamento','fechado') DEFAULT 'aberto',
  `data_abertura` datetime DEFAULT current_timestamp(),
  `data_fechamento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`id`, `usuario_id`, `titulo`, `descricao`, `categoria`, `prioridade`, `status`, `data_abertura`, `data_fechamento`) VALUES
(2, 2, 'Chamado sobre Hardware', 'parou tudo', 'Hardware', 'alta', 'fechado', '2025-11-30 22:55:33', '2025-12-01 09:04:17'),
(3, 2, 'Chamado sobre Rede', 'qwqqwq', 'Rede', 'media', 'fechado', '2025-11-30 23:09:40', '2025-12-01 09:04:14'),
(4, 3, 'Chamado sobre Software', 'parou', 'Software', 'baixa', 'fechado', '2025-12-01 09:53:03', '2025-12-01 09:53:47'),
(5, 4, 'Chamado sobre Rede', 'a ineternet da empresa caiu', 'Rede', 'alta', 'fechado', '2025-12-01 10:01:53', '2025-12-01 10:02:32'),
(6, 5, 'Chamado sobre Hardware', 'pwihfhwf', 'Hardware', 'baixa', 'fechado', '2025-12-02 07:39:48', '2025-12-02 08:48:35'),
(7, 3, 'Chamado sobre Hardware', 'PC nao liga', 'Hardware', 'alta', 'fechado', '2025-12-08 18:08:40', '2025-12-08 18:19:07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','user') DEFAULT 'user',
  `data_cadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `data_cadastro`) VALUES
(2, 'Maria Silva', 'maria@empresa.com', '123456', 'user', '2025-11-30 22:40:01'),
(3, 'Márcio Milhomem de Sousa Júnior', 'junior@gmail.com', 'junior123', 'user', '2025-12-01 09:21:48'),
(4, 'Gabriel Sousa sales', 'bagriel@gmail.com', 'bagriel', 'user', '2025-12-01 10:00:38'),
(5, 'daniel ferreira', 'fubokamax@gmail.com', 'soufuboka', 'user', '2025-12-01 18:14:12'),
(10, 'adm', 'admin@gmail.com', 'adm', 'admin', '2025-12-02 08:47:19');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `chamados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;