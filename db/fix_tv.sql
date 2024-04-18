-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 18 2024 г., 20:47
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fix_tv`
--

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `id_master` text DEFAULT NULL,
  `id_client` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `model_name` text NOT NULL,
  `type_of_backlight` text NOT NULL,
  `screen_diagonal` int(11) NOT NULL,
  `screen_refresh_rate` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `id_master`, `id_client`, `company_name`, `model_name`, `type_of_backlight`, `screen_diagonal`, `screen_refresh_rate`, `status`, `price`) VALUES
(2, '1', 3, 'Привет', 'Модель 1', 'Тип 1', 24, 60, 4, 3500),
(3, '2', 3, 'Привет 1', 'Модель 2', 'Тип 2', 42, 70, 4, 5000);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `fullname` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `role`, `login`, `email`, `fullname`, `password`) VALUES
(1, 1, 'asd', 'asd@asd', 'Иван Иванович Иванов', '$2y$10$nb/qzirnC9Hy40DV3eHEFeMVHWmIIdZEtUHIf/xXnOfMQtdcIWgT2'),
(2, 1, 'qwerty', 'qwerty@qwerty', 'Василий Васильевич Васильев', '$2y$10$krbb8I8O8wJTSmYeKsoVre53AZ.e1GA5Nyv.sdL70GInctnw9eLm.'),
(3, 2, 'zxc', 'zxc@zxc.ru', 'Артем Артемович Артемов', '$2y$10$NzSmoaAQcAiPUXdA8/RIUO0dFqlbZRYqa7xMTsyKmkgyFRvyMzbOG');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
