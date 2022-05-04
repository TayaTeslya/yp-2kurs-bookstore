-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 04 2022 г., 13:56
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `aquilon`
--
CREATE DATABASE IF NOT EXISTS `aquilon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `aquilon`;

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `ID_Car` int NOT NULL,
  `Number_Car` varchar(10) NOT NULL,
  `Brand_Car` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`ID_Car`, `Number_Car`, `Brand_Car`) VALUES
(1, '-', '-'),
(2, 'с065мк-78', 'КАМАЗ'),
(3, 'а126мм-99', 'ГАЗ'),
(4, 'н700уу-37', 'ГАЗ'),
(5, 'е001кх-77', 'МАЗ'),
(6, 'в333ос-33', 'КАМАЗ');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `ID_City` int NOT NULL,
  `Name_City` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`ID_City`, `Name_City`) VALUES
(1, '-'),
(2, 'Москва'),
(3, 'Санкт-Петербург'),
(4, 'Казань');

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `ID_Client` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Passport` char(10) NOT NULL,
  `Date_Birth` date NOT NULL,
  `Phone_Number` char(11) NOT NULL,
  `ID_User` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`ID_Client`, `FIO`, `Passport`, `Date_Birth`, `Phone_Number`, `ID_User`) VALUES
(1, '-', '0', '2021-01-01', '0', 1),
(2, 'Кривонос Марьяна Макаровна', '4397737765', '1973-12-20', '89076864732', 19),
(3, 'Элькин Геннадий Панкратович', '4981297367', '1962-09-25', '89077658493', 20),
(4, 'Башкатова Ульяна Георгиевна', '4686560813', '1979-12-02', '89076543192', 21),
(5, 'Семёнова Марина Ефимовна', '4229716624', '1963-09-27', '89087776532', 22),
(6, 'Невзоров Петр Львович', '4832987607', '1971-04-22', '89098767744', 23),
(10, 'FIO', '5565890987', '2002-02-02', '89087651029', 24);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `ID_Order` int NOT NULL,
  `ID_Client` int NOT NULL,
  `ID_Driver` int NOT NULL,
  `ID_Car` int NOT NULL,
  `Contract_Number` int NOT NULL,
  `Act_Number` int NOT NULL,
  `ID_Weight` int NOT NULL,
  `ID_Volume` int NOT NULL,
  `ID_Rate` int NOT NULL,
  `Date_Order` date NOT NULL,
  `Order_Status` varchar(10) NOT NULL,
  `Cost` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`ID_Order`, `ID_Client`, `ID_Driver`, `ID_Car`, `Contract_Number`, `Act_Number`, `ID_Weight`, `ID_Volume`, `ID_Rate`, `Date_Order`, `Order_Status`, `Cost`) VALUES
(1, 1, 1, 1, 0, 0, 1, 1, 1, '2021-01-01', '-', 0),
(2, 2, 13, 2, 1, 1, 2, 2, 3, '2021-09-09', 'Выполнен', 4500),
(3, 4, 17, 3, 2, 2, 3, 2, 6, '2020-05-30', 'Выполнен', 3700),
(4, 5, 15, 3, 3, 3, 3, 3, 2, '2021-03-25', 'Выполнен', 2400),
(5, 3, 14, 4, 4, 4, 2, 2, 7, '2021-05-04', 'Выполнен', 3300);

-- --------------------------------------------------------

--
-- Структура таблицы `rates`
--

CREATE TABLE `rates` (
  `ID_Rate` int NOT NULL,
  `ID_City` int NOT NULL,
  `Second_City_Name` varchar(60) NOT NULL,
  `Price_City` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `rates`
--

INSERT INTO `rates` (`ID_Rate`, `ID_City`, `Second_City_Name`, `Price_City`) VALUES
(1, 1, '-', 0),
(2, 2, 'Санкт-Петербург', 1000),
(3, 2, 'Казань', 2000),
(4, 3, 'Москва', 1000),
(5, 3, 'Казань', 2500),
(6, 4, 'Москва', 2000),
(7, 4, 'Санкт-Петербург', 2500);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_User` int NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Rank_User` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_User`, `Login`, `Password`, `Rank_User`) VALUES
(0, '0', '-', '-'),
(1, '-', '-', '-'),
(2, 'Kozlakova_M_Ph', 'Kozlakova_M_Ph', 'Сотрудник'),
(3, 'Byrtsov_P_D', 'Byrtsov_P_D', 'Сотрудник'),
(4, 'Yakyshkin_D_N', 'Yakyshkin_D_N', 'Сотрудник'),
(5, 'Syrkov_P_N', 'Syrkov_P_N', 'Сотрудник'),
(6, 'Khaninov_I_N', 'Khaninov_I_N', 'Сотрудник'),
(7, 'Gunina_S_A', 'Gunina_S_A', 'Сотрудник'),
(8, 'Teslya_T_E', 'Teslya_T_E', 'Администратор'),
(9, 'Sobolev_L_N', 'Sobolev_L_N', 'Администратор'),
(10, 'Duboladova_K_Ph', 'Duboladova_K_Ph', 'Сотрудник'),
(11, 'Yampolskiy_I_V', 'Yampolskiy_I_V', 'Сотрудник'),
(12, 'Pereverzeva_U_Ya', 'Pereverzeva_U_Ya', 'Сотрудник'),
(13, 'Khovanskaya_Zh_I', 'Khovanskaya_Zh_I', 'Сотрудник'),
(14, 'Maysak_M_I', 'Maysak_M_I', 'Сотрудник'),
(15, 'Vishnevskiy_E_A', 'Vishnevskiy_E_A', 'Сотрудник'),
(16, 'Konno_Ya_E', 'Konno_Ya_E', 'Сотрудник'),
(17, 'Susin_V_E', 'Susin_V_E', 'Сотрудник'),
(18, 'Maslyuk_E_V', 'Maslyuk_E_V', 'Администратор'),
(19, 'Crivonos', 'Crivonos', 'Клиент'),
(20, 'Elkin', 'Elkin', 'Клиент'),
(21, 'Bashkatova', 'Bashkatova', 'Клиент'),
(22, 'Semenova', 'Semenova', 'Клиент'),
(23, 'Nevzorov', 'Nevzorov', 'Клиент'),
(24, 'login', 'login', 'rank user');

-- --------------------------------------------------------

--
-- Структура таблицы `volumes`
--

CREATE TABLE `volumes` (
  `ID_Volume` int NOT NULL,
  `Max_Volume` int NOT NULL,
  `Price_Volume` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `volumes`
--

INSERT INTO `volumes` (`ID_Volume`, `Max_Volume`, `Price_Volume`) VALUES
(1, 0, 0),
(2, 260, 0),
(3, 500, 10),
(4, 750, 25),
(5, 1000, 50),
(6, 1500, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `warehouses`
--

CREATE TABLE `warehouses` (
  `ID_Warehouse` int NOT NULL,
  `Address_Warehouse` varchar(60) NOT NULL,
  `ID_City` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `warehouses`
--

INSERT INTO `warehouses` (`ID_Warehouse`, `Address_Warehouse`, `ID_City`) VALUES
(1, '-', 1),
(2, 'ул. Косиора, 28, 36869', 2),
(3, 'пер. 1905 года, 95, 269742', 2),
(4, 'шоссе Бухарестская, 25, 239008', 2),
(5, 'наб. Чехова, 79, 766098', 3),
(6, 'наб. Ленина, 98, 744641', 3),
(7, 'спуск Домодедовская, 03, 585062', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `weights`
--

CREATE TABLE `weights` (
  `ID_Weight` int NOT NULL,
  `Max_Weight` int NOT NULL,
  `Price_Weight` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `weights`
--

INSERT INTO `weights` (`ID_Weight`, `Max_Weight`, `Price_Weight`) VALUES
(1, 0, 0),
(2, 100, 0),
(3, 1000, 10),
(4, 2000, 25),
(5, 3000, 50),
(6, 10000, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `ID_Worker` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Passport` char(10) NOT NULL,
  `ID_Warehouse` int NOT NULL,
  `Birth_Date` date NOT NULL,
  `Post` varchar(30) NOT NULL,
  `Phone_Number` char(11) NOT NULL,
  `Salary` int NOT NULL,
  `ID_User` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`ID_Worker`, `FIO`, `Passport`, `ID_Warehouse`, `Birth_Date`, `Post`, `Phone_Number`, `Salary`, `ID_User`) VALUES
(1, '-', '0', 1, '2021-01-01', '-', '0', 0, 0),
(2, 'Козлакова Мария Феликсовна', '4799584808', 2, '1960-05-22', 'Оператор склада', '83917277309', 50000, 2),
(3, 'Бурцов Павел Даниилович', '4481631616', 3, '1961-11-02', 'Оператор склада', '88121435181', 50000, 3),
(4, 'Якушкин Давид Николаевич', '4412508828', 4, '1987-08-24', 'Оператор склада', '83439991696', 50000, 4),
(5, 'Сурков Прохор Никитьевич', '4849798920', 5, '1966-09-22', 'Оператор склада', '84965218207', 50000, 5),
(6, 'Ханинов Илья Львович', '4647348767', 6, '1980-01-09', 'Оператор склада', '83831890564', 50000, 6),
(7, 'Гунина София Александровна', '4229948715', 7, '1984-06-01', 'Оператор склада', '83471775066', 50000, 7),
(8, 'Тесля Таисия Евгеньевна', '5565897647', 1, '2003-03-24', 'Администратор БД', '89028238429', 150000, 8),
(9, 'Соболев Лев Николаевич', '4498768565', 1, '2003-11-18', 'Администратор ИС', '89652010991', 150000, 9),
(10, 'Дуболадова Клара Фадеевна', '4616957373', 1, '1992-06-01', 'Менеджер', '89076584732', 100000, 10),
(11, 'Ямпольский Игнат Валерьевич', '4573937237', 1, '1972-10-26', 'Менеджер', '89007654352', 100000, 11),
(12, 'Переверзева Юлиана Якоковна', '4010883134', 1, '1960-04-19', 'Менеджер', '89765678493', 100000, 12),
(13, 'Хованская Жанна Ивановна', '4692287235', 1, '1982-11-01', 'Водитель', '89028761888', 200000, 13),
(14, 'Майсак Марина Никандровна', '4335561435', 1, '1994-08-22', 'Водитель', '89096541726', 200000, 14),
(15, 'Вишневский Евгений Аркадинович', '4779327217', 1, '1960-12-21', 'Водитель', '89098786542', 200000, 15),
(16, 'Конно Яков Эмельянович', '4048480122', 1, '1977-01-16', 'Водитель', '89765647382', 200000, 16),
(17, 'Сюсин Виктор Эфимович', '4722717331', 1, '1981-04-23', 'Водитель', '89998728321', 200000, 17),
(18, 'Маслюк Евгения Викторовна', '5117717331', 1, '1971-08-08', 'Директор', '89059435195', 300000, 18);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`ID_Car`),
  ADD UNIQUE KEY `Number_Car` (`Number_Car`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`ID_City`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ID_Client`),
  ADD UNIQUE KEY `Passport` (`Passport`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`),
  ADD UNIQUE KEY `ID_User` (`ID_User`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID_Order`),
  ADD UNIQUE KEY `Contract_Number` (`Contract_Number`),
  ADD UNIQUE KEY `Act_Number` (`Act_Number`),
  ADD KEY `ID_Client` (`ID_Client`),
  ADD KEY `ID_Driver` (`ID_Driver`),
  ADD KEY `ID_Car` (`ID_Car`),
  ADD KEY `ID_Weight` (`ID_Weight`),
  ADD KEY `ID_Volume` (`ID_Volume`),
  ADD KEY `ID_Rate` (`ID_Rate`);

--
-- Индексы таблицы `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`ID_Rate`),
  ADD KEY `ID_City` (`ID_City`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_User`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Индексы таблицы `volumes`
--
ALTER TABLE `volumes`
  ADD PRIMARY KEY (`ID_Volume`);

--
-- Индексы таблицы `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`ID_Warehouse`),
  ADD KEY `ID_City` (`ID_City`);

--
-- Индексы таблицы `weights`
--
ALTER TABLE `weights`
  ADD PRIMARY KEY (`ID_Weight`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`ID_Worker`),
  ADD UNIQUE KEY `Passport` (`Passport`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`),
  ADD UNIQUE KEY `ID_User` (`ID_User`),
  ADD KEY `ID_Warehouse` (`ID_Warehouse`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID_User`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `clients` (`ID_Client`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ID_Driver`) REFERENCES `workers` (`ID_Worker`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`ID_Car`) REFERENCES `cars` (`ID_Car`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`ID_Weight`) REFERENCES `weights` (`ID_Weight`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`ID_Volume`) REFERENCES `volumes` (`ID_Volume`),
  ADD CONSTRAINT `orders_ibfk_6` FOREIGN KEY (`ID_Rate`) REFERENCES `rates` (`ID_Rate`);

--
-- Ограничения внешнего ключа таблицы `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_ibfk_1` FOREIGN KEY (`ID_City`) REFERENCES `cities` (`ID_City`);

--
-- Ограничения внешнего ключа таблицы `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `warehouses_ibfk_1` FOREIGN KEY (`ID_City`) REFERENCES `cities` (`ID_City`);

--
-- Ограничения внешнего ключа таблицы `workers`
--
ALTER TABLE `workers`
  ADD CONSTRAINT `workers_ibfk_1` FOREIGN KEY (`ID_Warehouse`) REFERENCES `warehouses` (`ID_Warehouse`),
  ADD CONSTRAINT `workers_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID_User`);
--
-- База данных: `bookshop`
--
CREATE DATABASE IF NOT EXISTS `bookshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `bookshop`;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `ID_Book` int NOT NULL,
  `Name_Book` varchar(100) NOT NULL,
  `Author` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Year` char(4) NOT NULL,
  `Pages` int NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Quantity` int NOT NULL,
  `ID_Publisher` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`ID_Book`, `Name_Book`, `Author`, `Description`, `Year`, `Pages`, `Price`, `Quantity`, `ID_Publisher`) VALUES
(1, 'УДАЛЕНО', '-', '-', '0000', 0, '0.00', 0, 1),
(2, 'Метро. Трилогия под одной обложкой', 'Дмитрий Глуховский', '«Метро» Дмитрия Глуховского переведено на 37 языков мира и издано двухмиллионным тиражом.\r\nТретья мировая стерла человечество с лица Земли. Планета опустела. Мегаполисы обращены в прах и пепел. Железные дороги ржавеют. Спутники одиноко болтаются на орбите. Радио молчит на всех частотах. Выжили только те, кто услышав сирены тревоги, успел добежать до дверей московского метро. Там, на глубине в десятки метров, на станциях и в туннелях, люди пытаются переждать конец света. Там они создали новый мирок вместо потерянного огромного мира. Они цепляются за жизнь изо всех сил и отказываются сдаваться. Они мечтают однажды вернуться наверх – когда радиационный фон от ядерных бомбардировок спадет. И не оставляют надежды найти других выживших…\r\nПеред вами – наиболее полное коллекционное издание трилогии «Метро». Впервые «Метро 2033», «Метро 2034», «Метро 2035» и новелла «Евангелие от Артема» выходят под одной обложкой. Дмитрий Глуховский ставит точку в саге, над которой работал двадцать лет.\r\nНовелла «Евангелие от Артема» представлена эпилогом к роману «Метро 2033»', '2015', 1460, '789.00', 0, 4),
(3, 'Кровь эльфов', 'Анджей Сапковский', 'Цинтра захвачено Нильфгаардской империей. Всюду пламя и разрушения, сотни погибших. Прекрасное королевство пало.\r\nНаследнице Цири чудом удается спастись. Напуганную, потерявшую близких и дом девочку Геральт доставляет в убежище ведьмаков. Неожиданно для всех у принцессы открываются магические способности.\r\nЧтобы понять их природу, Геральт обращается за помощью к чародейке. Однако она советует ведьмаку призвать свою бывшую возлюбленную Йеннифэр. Ибо только она сможет научить девочку пользоваться ее даром…', '1994', 330, '279.00', 2, 2),
(4, 'НОВАЯ КНИГА', 'Сергей Лукьяненко', 'Дознаватель Денис Симонов прибывает в квартиру Виктора Томилина, где застает его и еще одного мужчину восставшими после смерти. Денис убивает обоих. Свидетелем происходящего становится таинственный кваzи (разумный зомби), который скрывается с места происшествия.\r\nНесмотря на произошедшее, Симонов продолжает вести расследование гибели профессора. Но не один, а с напарником – Михаилом Бедренцем, который оказывается тем самым кваzи, сбежавшим из квартиры Томилина.\r\nСыщики выясняют, что убийцу наняла жена профессора, Виктория. Она хотела помочь супругу возвыситься и стать кваzи. Преступнице удается скрыться от правосудия.\r\nА тем временем гибелью Томилина заинтересовывается госбезопасность. И не просто так, ведь вскоре становится известно о существовании вирусов, способных уничтожить и людей, и кваzи. И кое-кто очень заинтересован в распространении этих вирусов…', '2016', 320, '269.00', 4, 4),
(5, 'После тяжелой продолжительной болезни. История Российского государства. Время Николая II', 'Акунин Б.', 'Этой эпохе посвящено больше литературы, чем всей остальной отечественной истории вместе взятой. Целые академические институты занимались «историей революции» — в сущности, очень коротким периодом.\r\nПожалуй, можно сказать, что предыдущие тома «Истории российского государства» являлись подготовкой к этому. Попробуем разобраться в причинах гибели государства. Была — и остается — надежда, что если правильно проанализировать анамнез болезни, то, может быть, удастся с ней справиться при следующем обострении.', '2022', 384, '1669.00', 7, 1),
(6, 'Новому человеку - новая смерть? Похоронная культура раннего СССР', 'Соколова А.', 'История СССР часто измеряется десятками и сотнями миллионов трагических и насильственных смертей — от голода, репрессий, войн, а также катастрофических издержек социальной и экономической политики советской власти. Но огромное число жертв советского эксперимента окружала еще более необъятная смерть: речь о миллионах и миллионах людей, умерших от старости, болезней и несчастных случаев. Книга историка и антрополога Анны Соколовой представляет собой анализ государственной политики в отношении смерти и погребения, а также причудливых метаморфоз похоронной культуры в крупных городах СССР. Эта тема долгое время оставалась в тени исследований о политических репрессиях и войнах, а также работ по традиционной деревенской похоронной культуре. Если эти аспекты советской мортальности исследованы неплохо, то вопрос о том, что представляли собой в материальном и символическом измерениях смерть и похороны рядового советского горожанина, изучен мало. Между тем он очень важен для понимания того, кем был (или должен был стать) «новый советский человек», провозглашенный революцией. Анализ трансформаций в сфере похоронной культуры проливает свет и на другой вопрос: был ли опыт радикального реформирования общества в СССР абсолютно уникальным или же, несмотря на весь свой радикализм, он был частью масштабного модернизационного перехода к индустриальным обществам? Анна Соколова — кандидат исторических наук, научный сотрудник Института этнологии и антропологии РАН, преподаватель программы «История советской цивилизации» МВШСЭН.', '2022', 256, '969.00', 18, 3),
(7, 'Разум убийцы. Как работает мозг тех, кто совершает преступления', 'Тейлор Р.', 'Главный вопрос, которым на протяжении всей своей карьеры задавался судебный психиатр Ричард Тейлор, мог бы звучать так: зачем люди убивают? В своей книге он рассказывает о преступлениях на сексуальной почве и в состоянии аффекта, финансово мотивированных, психотических и массовых, о детоубийствах и убийствах, связанных с терроризмом. Это взгляд изнутри на одну из самых редкий профессий, а также попытка разгадать мотивы людей, совершающих тяжкие преступления. Как решается, что будет с человеком после обвинения? Как судебный психиатр работает с преступником и что случается с теми, кто признан невменяемым? Что можно сделать, чтобы предотвратить повторение трагических событий? Вы узнаете, как происходит психиатрическая оценка преступника, а также о нашумевших делах, в которых автор принимал участие в качестве судебного психиатра.', '2021', 432, '587.00', 6, 2),
(8, 'Нержавеющий Сталин', 'Вассерман А., Гончаренко С.', 'Предлагаемая вашему вниманию книга — плод коллективного труда компетентных, увлеченных и знающих авторов. Едва ли не каждая глава здесь — результат обсуждения соответствующей темы с неангажированными профессиональными исследователями, что делает книгу глубоко проработанной, цельной и непредвзятой.\r\nБлагодаря кропотливой работе по поиску и обобщению информации, в том числе взятой из зарубежных источников, книга дает цельное и многогранное представление не только о затрагиваемых в ней событиях, но и об эпохе в целом.\r\nКнига предназначена для широкого круга читателей и всех интересующихся отечественной историей.', '2022', 384, '719.00', 8, 2),
(9, '1795. Роман', 'Натт-о-Даг Н.', 'Романы «1793» и «1794» в одночасье стали мировыми бестселлерами. А их автор – шведский писатель Никлас Натт-о-Даг получил премию Crimetime Specsavers Award за лучший дебют в криминальной прозе и был удостоен Почетной премии Стокгольма в области литературы. Роман «1795» завершает трилогию о мрачном мире XVIII века, где сплелись жестокость и милосердие, унижение и гордость, безобразие и красота.\r\nМрачный, жестокий, кровавый Стокгольм. Полный несправедливости и абсолютно к ней безразличный. Смерть поджидает здесь на каждом шагу и заберет с собой любого, кому не посчастливилось с ней встретиться. Но порою смерть может стать спасением. По Городу между мостами бродят заблудшие души, которые не могут обрести покой. Живой мертвец, обрекший сотню судеб на раннюю кончину. Молодой охотник, угнетенный тенью покойного брата. И цель его охоты: загнанный зверь, от злодеяний которого содрогнется весь город. В холодном Стокгольме одни пытаются искупить грехи, другие – скрыть свои проступки. Все они ищут избавления, но не каждый сумеет его заслужить…', '2021', 528, '844.00', 2, 1),
(10, 'Дерево-призрак', 'Генри К.', 'Лорен и Миранда все детство провели под сенью старого призрачного дерева, и даже загадочное убийство отца Лорен неподалеку не смогло изменить их традицию. Время шло, и, кажется, все жители города, включая полицейских, позабыли о трагедии и спокойно живут дальше.\r\nГод спустя в городке случается еще одно убийство, и на этот раз жертвами становятся две девочки. Картина преступления своей странностью очень напоминает события прошлого года, но Лорен уже и не надеется, что полиция найдет убийцу.\r\nПоэтому, когда девочку посещает видение о монстре, таскающем мертвые тела через лес, она решает разгадать эту тайну во что бы то ни стало, даже если всему остальному городу нет до нее никакого дела.', '2021', 448, '518.00', 7, 3),
(11, 'Мутный', 'Стеффи Л.', '\"ОТ АВТОРА НАШУМЕВШЕГО БЕСТСЕЛЛЕРА «ОРЛЕАН»\r\nВозлюбленный Евы четыре года назад разбился на мотоцикле во время гонки в Токио. Все это время Ева не жила, а существовала. Дни, похожие один на другой. Люди, не имеющие никакого значения. Но однажды она встретила его — того, кто вернул ее к жизни и сделал по-настоящему счастливой… а потом…\r\nрастоптал…\r\nРастоптал все человеческое, что в ней еще осталось.', '2022', 416, '564.00', 5, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `buys`
--

CREATE TABLE `buys` (
  `ID_Buy` int NOT NULL,
  `ID_Client` int NOT NULL,
  `ID_Worker` int NOT NULL,
  `Date_Buy` date NOT NULL,
  `Cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `buys`
--

INSERT INTO `buys` (`ID_Buy`, `ID_Client`, `ID_Worker`, `Date_Buy`, `Cost`) VALUES
(1, 1, 5, '2021-12-09', '678.99'),
(2, 2, 3, '2021-12-12', '678.99'),
(3, 1, 3, '2022-01-03', '466.99'),
(4, 4, 4, '2022-01-06', '876.99'),
(5, 3, 3, '2022-01-14', '544.99'),
(6, 3, 2, '2022-01-28', '3636.51'),
(8, 3, 2, '2022-01-28', '7948.56');

-- --------------------------------------------------------

--
-- Структура таблицы `buys_contents`
--

CREATE TABLE `buys_contents` (
  `ID_Content` int NOT NULL,
  `ID_Buy` int NOT NULL,
  `ID_Book` int NOT NULL,
  `Quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `buys_contents`
--

INSERT INTO `buys_contents` (`ID_Content`, `ID_Buy`, `ID_Book`, `Quantity`) VALUES
(2, 1, 11, 1),
(3, 2, 2, 2),
(4, 2, 4, 3),
(5, 3, 3, 1),
(6, 3, 6, 1),
(7, 3, 5, 1),
(8, 4, 7, 3),
(9, 4, 8, 2),
(10, 5, 9, 1),
(11, 5, 10, 3),
(12, 5, 4, 4),
(13, 5, 9, 2),
(14, 6, 3, 5),
(15, 6, 2, 1),
(16, 6, 7, 3),
(18, 8, 5, 4),
(19, 8, 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `ID_Client` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Phone_Number` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`ID_Client`, `FIO`, `Phone_Number`) VALUES
(1, 'УДАЛЕНО', '00000000000'),
(2, 'Малышева Ксения Артёмовна', '89028239485'),
(3, 'Хомяков Тимофей Даниилович', '89602039488'),
(4, 'Федорова Марина Леонидовна', '89059435196'),
(5, 'Кузьмина Алия Савельевна', '89508374587'),
(6, 'Никольский Кирилл Матвеевич', '89628767564'),
(7, 'ДОПОЛНИТЕЛЬНО', '89028238428');

-- --------------------------------------------------------

--
-- Структура таблицы `discounts`
--

CREATE TABLE `discounts` (
  `ID_Discount` int NOT NULL,
  `ID_Book` int NOT NULL,
  `Discount` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `discounts`
--

INSERT INTO `discounts` (`ID_Discount`, `ID_Book`, `Discount`) VALUES
(1, 3, 5),
(2, 2, 6),
(3, 3, 4),
(4, 4, 7),
(5, 5, 8),
(6, 6, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `publishers`
--

CREATE TABLE `publishers` (
  `ID_Publisher` int NOT NULL,
  `Name_Publisher` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `publishers`
--

INSERT INTO `publishers` (`ID_Publisher`, `Name_Publisher`) VALUES
(4, 'АСТ'),
(2, 'ЛитРес'),
(3, 'Просвещение'),
(1, 'УДАЛЕНО');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_User` int NOT NULL,
  `ID_Worker` int NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_User`, `ID_Worker`, `Login`, `Password`) VALUES
(1, 1, 'УДАЛЕНО', '336d5ebc5436534e61d16e63ddfca327'),
(2, 2, 'Administrator', '7b7bc2512ee1fedcd76bdc68926d4f7b'),
(3, 3, 'Philatov_I_M', 'Philatov_I_M'),
(4, 4, 'Sotrydnik', '92294134218ef81ff11945df001a0b79'),
(5, 5, 'Kostina_A_D', 'Kostina_A_D'),
(6, 6, 'tayateslya', '480721159b92688a8032c93e7f47a817');

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `ID_Worker` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Passport` char(10) NOT NULL,
  `Date_Birth` date NOT NULL,
  `Phone_Number` char(11) NOT NULL,
  `Date_Accept` date NOT NULL,
  `Post` varchar(20) NOT NULL,
  `Salary` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`ID_Worker`, `FIO`, `Passport`, `Date_Birth`, `Phone_Number`, `Date_Accept`, `Post`, `Salary`) VALUES
(1, 'УДАЛЕНО', '0000000000', '2022-01-01', '00000000000', '2022-01-01', 'УДАЛЕНО', '0.00'),
(2, 'Сухарик Игнат Андреевич', '9999999999', '2002-11-19', '89167702520', '2021-04-01', 'Администратор', '100005.00'),
(3, 'Филатов Иван Максимович', '4560509254', '1970-11-14', '89768574653', '2021-09-01', 'Сотрудник', '30002.00'),
(4, 'Иванов Матвей Дмитриевич', '4821811662', '1982-02-16', '89028237564', '2019-07-08', 'Сотрудник', '350001.00'),
(5, 'Костина Алина Данииловна', '4473212471', '1996-09-03', '89028237651', '2022-02-01', 'Сотрудник', '29001.00'),
(6, 'Таисия Тесля Евгеньевна', '5545678765', '2021-12-30', '89028237465', '2022-01-28', 'Администратор', '12000.12');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ID_Book`),
  ADD KEY `ID_Publisher` (`ID_Publisher`);

--
-- Индексы таблицы `buys`
--
ALTER TABLE `buys`
  ADD PRIMARY KEY (`ID_Buy`),
  ADD KEY `ID_Client` (`ID_Client`),
  ADD KEY `ID_Worker` (`ID_Worker`);

--
-- Индексы таблицы `buys_contents`
--
ALTER TABLE `buys_contents`
  ADD PRIMARY KEY (`ID_Content`),
  ADD KEY `ID_Buy` (`ID_Buy`),
  ADD KEY `ID_Book` (`ID_Book`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ID_Client`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`);

--
-- Индексы таблицы `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`ID_Discount`),
  ADD KEY `ID_Book` (`ID_Book`);

--
-- Индексы таблицы `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`ID_Publisher`),
  ADD UNIQUE KEY `Name_Publisher` (`Name_Publisher`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_User`),
  ADD UNIQUE KEY `ID_Worker` (`ID_Worker`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`ID_Worker`),
  ADD UNIQUE KEY `Passport` (`Passport`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `ID_Book` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `buys`
--
ALTER TABLE `buys`
  MODIFY `ID_Buy` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `buys_contents`
--
ALTER TABLE `buys_contents`
  MODIFY `ID_Content` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `ID_Client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `discounts`
--
ALTER TABLE `discounts`
  MODIFY `ID_Discount` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `publishers`
--
ALTER TABLE `publishers`
  MODIFY `ID_Publisher` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_User` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `ID_Worker` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`ID_Publisher`) REFERENCES `publishers` (`ID_Publisher`);

--
-- Ограничения внешнего ключа таблицы `buys`
--
ALTER TABLE `buys`
  ADD CONSTRAINT `buys_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `clients` (`ID_Client`),
  ADD CONSTRAINT `buys_ibfk_2` FOREIGN KEY (`ID_Worker`) REFERENCES `workers` (`ID_Worker`);

--
-- Ограничения внешнего ключа таблицы `buys_contents`
--
ALTER TABLE `buys_contents`
  ADD CONSTRAINT `buys_contents_ibfk_1` FOREIGN KEY (`ID_Buy`) REFERENCES `buys` (`ID_Buy`),
  ADD CONSTRAINT `buys_contents_ibfk_2` FOREIGN KEY (`ID_Book`) REFERENCES `books` (`ID_Book`);

--
-- Ограничения внешнего ключа таблицы `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`ID_Book`) REFERENCES `books` (`ID_Book`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_Worker`) REFERENCES `workers` (`ID_Worker`);
--
-- База данных: `bookstore`
--
CREATE DATABASE IF NOT EXISTS `bookstore` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `bookstore`;

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `ID_Basket` int NOT NULL,
  `ID_User` int NOT NULL,
  `ID_Book` int NOT NULL,
  `Quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `ID_Book` int NOT NULL,
  `Name_Book` varchar(255) NOT NULL,
  `Author` varchar(255) NOT NULL,
  `Year` int NOT NULL,
  `Genres` varchar(255) NOT NULL,
  `Description` mediumtext NOT NULL,
  `Pages` int NOT NULL,
  `Price` float NOT NULL,
  `ID_Shop` int NOT NULL,
  `Quantity` int NOT NULL,
  `ID_Supplier` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `ID_Basket` int NOT NULL,
  `ID_Order` int NOT NULL,
  `ID_User` int NOT NULL,
  `ID_Shop` int NOT NULL,
  `Date_Order` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personnel`
--

CREATE TABLE `personnel` (
  `ID_Personnel` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Passport` int NOT NULL,
  `Passport_Date_Issue` date NOT NULL,
  `Passport_Place_Issue` varchar(255) NOT NULL,
  `Date_Birth` date NOT NULL,
  `Phone_Number` char(16) NOT NULL,
  `Salary` float NOT NULL,
  `Post` varchar(50) NOT NULL,
  `ID_Shop` int NOT NULL
) ;

-- --------------------------------------------------------

--
-- Структура таблицы `shops`
--

CREATE TABLE `shops` (
  `ID_Shop` int NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone_Number` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `suppliers`
--

CREATE TABLE `suppliers` (
  `ID_Supplier` int NOT NULL,
  `Organization` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Phone_Number` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_User` int NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Rank_User` varchar(10) NOT NULL
) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`ID_Basket`),
  ADD UNIQUE KEY `ID_User` (`ID_User`),
  ADD UNIQUE KEY `ID_Book` (`ID_Book`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ID_Book`),
  ADD UNIQUE KEY `ID_Shop` (`ID_Shop`),
  ADD UNIQUE KEY `ID_Supplier` (`ID_Supplier`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID_Basket`),
  ADD KEY `ID_User` (`ID_User`),
  ADD KEY `ID_Shop` (`ID_Shop`);

--
-- Индексы таблицы `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`ID_Personnel`),
  ADD UNIQUE KEY `Passport` (`Passport`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`),
  ADD UNIQUE KEY `ID_Shop` (`ID_Shop`);

--
-- Индексы таблицы `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`ID_Shop`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`);

--
-- Индексы таблицы `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`ID_Supplier`),
  ADD UNIQUE KEY `Organization` (`Organization`),
  ADD UNIQUE KEY `Phone_Number` (`Phone_Number`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_User`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID_User`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`ID_Book`) REFERENCES `books` (`ID_Book`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`ID_Shop`) REFERENCES `shops` (`ID_Shop`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`ID_Supplier`) REFERENCES `suppliers` (`ID_Supplier`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`ID_Basket`) REFERENCES `basket` (`ID_Basket`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID_User`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`ID_Shop`) REFERENCES `shops` (`ID_Shop`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`ID_Personnel`) REFERENCES `users` (`ID_User`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `personnel_ibfk_2` FOREIGN KEY (`ID_Shop`) REFERENCES `shops` (`ID_Shop`) ON DELETE RESTRICT ON UPDATE CASCADE;
--
-- База данных: `hair_salon`
--
CREATE DATABASE IF NOT EXISTS `hair_salon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `hair_salon`;

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `ID_Client` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Gender` char(1) NOT NULL,
  `Phone_Number` char(11) NOT NULL,
  `ID_User` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`ID_Client`, `FIO`, `Gender`, `Phone_Number`, `ID_User`) VALUES
(1, 'Морозова Анастасия Юрьевна', 'Ж', '89078695847', 6),
(2, 'Степанова Арина Кирилловна', 'Ж', '89987657463', 7),
(3, 'Жданов Артём Семёнович', 'М', '89652019876', 8),
(4, 'Беспалов Владислав Антонович', 'М', '89028796543', 9),
(5, 'Антонова Алёна Арсеньевна', 'Ж', '89078900098', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `haircuts`
--

CREATE TABLE `haircuts` (
  `ID_Haircut` int NOT NULL,
  `Name_Haircut` varchar(100) NOT NULL,
  `Price` int NOT NULL,
  `Execute_Time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `haircuts`
--

INSERT INTO `haircuts` (`ID_Haircut`, `Name_Haircut`, `Price`, `Execute_Time`) VALUES
(1, 'Каре', 400, '40 минут'),
(2, 'Подровнять кончики', 200, '15 минут'),
(3, 'На лысо', 250, '1 час'),
(4, 'Короткая мужская машинкой', 250, '15 минут'),
(5, 'Срезать длину', 200, '30 минут');

-- --------------------------------------------------------

--
-- Структура таблицы `hairdressers`
--

CREATE TABLE `hairdressers` (
  `ID_Hairdresser` int NOT NULL,
  `FIO` varchar(255) NOT NULL,
  `Gender` char(1) NOT NULL,
  `Experience` varchar(20) NOT NULL,
  `ID_User` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `hairdressers`
--

INSERT INTO `hairdressers` (`ID_Hairdresser`, `FIO`, `Gender`, `Experience`, `ID_User`) VALUES
(1, 'Косарев Егор Александрович', 'М', 'С 2014 года', 2),
(2, 'Новикова Фатима Макаровна', 'Ж', 'С 2002 года', 3),
(3, 'АДМИНИСТРАТОР', 'М', 'АДМИНИСТРАТОР', 4),
(4, 'СОТРУДНИК', 'М', 'СОТРУДНИК', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `records`
--

CREATE TABLE `records` (
  `ID_Record` int NOT NULL,
  `ID_Client` int NOT NULL,
  `ID_Hairdresser` int NOT NULL,
  `ID_Haircut` int NOT NULL,
  `Date_Record` date NOT NULL,
  `Time_Record` char(5) NOT NULL,
  `Status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `records`
--

INSERT INTO `records` (`ID_Record`, `ID_Client`, `ID_Hairdresser`, `ID_Haircut`, `Date_Record`, `Time_Record`, `Status`) VALUES
(1, 2, 1, 1, '2021-10-31', '14:40', 'Выполнен'),
(2, 3, 2, 4, '2021-11-20', '19:30', 'Не выполнен'),
(3, 1, 2, 2, '2021-11-18', '10:45', 'Выполнен'),
(4, 5, 1, 2, '2021-11-07', '17:50', 'Выполнен'),
(5, 4, 2, 3, '2021-11-11', '18:30', 'Выполнен');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_User` int NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Rank_User` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_User`, `Login`, `Password`, `Rank_User`) VALUES
(2, 'Kosarev_E_A', 'Kosarev_E_A', 'Парикмахер'),
(3, 'Novikova_F_M', 'Novikova_F_M', 'Парикмахер'),
(4, 'Administrator', 'Administrator', 'Админ'),
(5, 'Sotrydnik', 'Sotrydnik', 'Сотрудник'),
(6, 'Morozova_A_U', 'Morozova_A_U', 'Клиент'),
(7, 'Stepanova_A_K', 'Stepanova_A_K', 'Клиент'),
(8, 'Zhdanov_A_S', 'Zhdanov_A_S', 'Клиент'),
(9, 'Bespalov_V_A', 'Bespalov_V_A', 'Клиент'),
(10, 'Antonova_A_A', 'Antonova_A_A', 'Клиент');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ID_Client`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Индексы таблицы `haircuts`
--
ALTER TABLE `haircuts`
  ADD PRIMARY KEY (`ID_Haircut`),
  ADD UNIQUE KEY `Name_Haircut` (`Name_Haircut`);

--
-- Индексы таблицы `hairdressers`
--
ALTER TABLE `hairdressers`
  ADD PRIMARY KEY (`ID_Hairdresser`),
  ADD UNIQUE KEY `ID_User` (`ID_User`);

--
-- Индексы таблицы `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`ID_Record`),
  ADD KEY `ID_Client` (`ID_Client`),
  ADD KEY `ID_Hairdresser` (`ID_Hairdresser`),
  ADD KEY `ID_Haircut` (`ID_Haircut`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_User`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID_User`);

--
-- Ограничения внешнего ключа таблицы `hairdressers`
--
ALTER TABLE `hairdressers`
  ADD CONSTRAINT `hairdressers_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID_User`);

--
-- Ограничения внешнего ключа таблицы `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `clients` (`ID_Client`),
  ADD CONSTRAINT `records_ibfk_2` FOREIGN KEY (`ID_Hairdresser`) REFERENCES `hairdressers` (`ID_Hairdresser`),
  ADD CONSTRAINT `records_ibfk_3` FOREIGN KEY (`ID_Haircut`) REFERENCES `haircuts` (`ID_Haircut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
