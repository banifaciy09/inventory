-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 06 2021 г., 18:50
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `inventory`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `id_admin` int NOT NULL,
  `login` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `access`
--

INSERT INTO `access` (`id_admin`, `login`, `pass`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE `departments` (
  `id_dept` int NOT NULL,
  `dept_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id_dept`, `dept_name`) VALUES
(1, 'АПР'),
(2, 'АУП'),
(3, 'АСГ АСО'),
(4, 'ГП АСО'),
(5, 'МТО'),
(6, 'ОПВ'),
(7, 'ТГСВ'),
(8, 'ФЭГ');

-- --------------------------------------------------------

--
-- Структура таблицы `devices`
--

CREATE TABLE `devices` (
  `inventory_num` int NOT NULL,
  `device_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `room` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ip_adress` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cartrige` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_date` date NOT NULL,
  `personnel_num` int DEFAULT NULL,
  `id_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `devices`
--

INSERT INTO `devices` (`inventory_num`, `device_name`, `room`, `ip_adress`, `cartrige`, `registration_date`, `personnel_num`, `id_type`) VALUES
(2678, 'nf-182', '409', '192.168.10.212', NULL, '2020-12-17', 260, 1),
(2682, 'Yoga Slim 7 14\"', '511', '', NULL, '2021-02-04', 56, 6),
(2683, 'Triumph-Adler 8057i MFP', '1-ый этаж', '192.168.10.22', NULL, '2021-02-11', 267, 3),
(2684, 'Canon TM-300', '403', '192.168.10.123', NULL, '2021-02-12', NULL, 4),
(2686, 'nf-183', '404', '192.168.10.213', NULL, '2021-02-19', 101, 1),
(3456, 'nf-105', '403', '192.168.10.135', '', '2021-03-01', 345, 1),
(4365, 'HP 2035', '401', '192.168.10.32', 'tk-505x', '2020-12-16', NULL, 2),
(4568, 'nf-101', '511', '192.168.10.131', '', '2021-02-10', 5786, 1),
(6536, 'HP 3015', '407', '192.168.10.22', 'tk-6305', '2020-10-13', NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE `staff` (
  `personnel_num` int NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `post` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_dept` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `staff`
--

INSERT INTO `staff` (`personnel_num`, `surname`, `name`, `patronymic`, `post`, `id_dept`) VALUES
(0, '', '', '', '', 1),
(56, 'Анушкевич', 'Татьяна', 'Александровна', 'Зам. начальника', 2),
(101, 'Яковлева', 'Елена', 'Геннадьевна', 'Главный бухгалтер', 2),
(260, 'Боярина', 'Наталья', 'Николаевна', 'инженер 2 кат.', 7),
(267, 'Байлеванян', 'Роман', 'Георгиевич', 'Рук. группы', 1),
(345, 'Петров', 'Петр', 'Петрович', 'эколог', 6),
(3452, 'ывапывпа', 'выпывпаывывпыв', 'фыапыпыв', 'ыфвлоарло 12 ', 5),
(5786, 'Иванов', 'Иван', 'Иванович', 'инженер-конструктор', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id_type` int NOT NULL,
  `type_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `types`
--

INSERT INTO `types` (`id_type`, `type_name`) VALUES
(1, 'ПЭВМ'),
(2, 'Принтер'),
(3, 'МФУ'),
(4, 'Плоттер'),
(5, 'Сервер'),
(6, 'Ноутбук');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id_admin`);

--
-- Индексы таблицы `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id_dept`);

--
-- Индексы таблицы `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`inventory_num`),
  ADD KEY `personnel_num` (`personnel_num`),
  ADD KEY `id_type` (`id_type`);

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`personnel_num`),
  ADD KEY `ID_dept` (`id_dept`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access`
--
ALTER TABLE `access`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `departments`
--
ALTER TABLE `departments`
  MODIFY `id_dept` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`personnel_num`) REFERENCES `staff` (`personnel_num`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `devices_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `types` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`id_dept`) REFERENCES `departments` (`id_dept`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
