-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Май 09 2024 г., 20:12
-- Версия сервера: 8.2.0
-- Версия PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `td_complect`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `user_id` int DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `name`, `description`, `user_id`, `date`, `status`) VALUES
(43, 'фывафыва', '1234', 1, '2024-05-09 19:15:46', 'опубликован'),
(48, '12312345', 'asdfcasdfvc', 2, '2024-05-09 19:15:46', 'ожидает модерации'),
(52, '12312345', 'asdfcasdfvc', 2, '2024-05-09 19:15:46', 'опубликован'),
(55, 'test post', '1234', 4, '2024-05-09 19:52:40', 'ожидает модерации'),
(57, 'ТЕСТ ПОСТЯЧСМasdf', 'ТЕСТ ПОСТasdfa', 4, '2024-05-09 19:52:55', 'ожидает модерации'),
(59, 'asdf', 'asdf', 1, '2024-05-09 19:54:56', 'ожидает модерации');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password`, `role`, `token`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$LAurzVG4K36DuMt7tjlq/OH..s8Y8ZkB2s8ovGRC7/o7gbsBXKuoC', 'admin', 'a84ee59a-7af2-4017-bb87-e552ae4d8909'),
(2, 'user', 'user@user.com', '$2y$10$0w66ecd6LT34ZbvjR10sUO.TrdX9UrjqiSsE8CHt2mS5qmOGJn1dy', 'user', '88ba724e-ac06-4240-9ce0-fde357824b57'),
(3, 'user2', 'user2@user.com', '$2y$10$KawO/8yvAB3IOq0zBm5IHu6NkQ0Go643UUC/9YhZahnmqkzM3FuQq', 'user', '64765b4a-b299-4ba5-9bb0-31b60123ef00'),
(4, 'user23', 'user23@user.com', '$2y$10$p5agkeuCrEmQNLGqaEGBreFC8WPgFMbHoSyazpn153BmzY6AT62XO', 'user', 'd89138ac-de16-40cb-bc4a-4bd825dbb860');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
