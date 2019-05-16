-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 15 2016 г., 00:20
-- Версия сервера: 5.5.50
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `1valak-shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_id` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `cat_id`) VALUES
(1, 'Ноутбуки', 'notebook'),
(2, 'Персональные компьютеры', 'pc');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) unsigned NOT NULL,
  `product` varchar(100) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `post_index` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(100) NOT NULL,
  `cat` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `image`, `cat`) VALUES
(1, 'DELL N5050', 'Описание', '235.00', '1.png', 'notebook'),
(2, 'Acer Aspire 5349', 'Описание', '655.55', '2.png', 'notebook'),
(3, 'Asus X54C', 'Описание', '577.00', '3.png', 'notebook'),
(4, 'Toshiba C660', 'Описание', '855.00', '4.png', 'notebook'),
(5, 'i5 Gaming GTX2', 'Описание', '1000.00', '5.png', 'pc'),
(6, 'DELL  Aurora', 'Описание', '1200.00', '6.png', 'pc'),
(7, 'i7 Storm Enforcer', 'Описание', '1400.00', '7.png', 'pc'),
(8, 'i7 Predator GTX', 'Описание', '1500.00', '8.png', 'pc');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;--
-- База данных: `6yariko-shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_callback`
--

CREATE TABLE IF NOT EXISTS `yariko_callback` (
  `call_name` varchar(255) NOT NULL,
  `call_phone` varchar(255) NOT NULL,
  `call_email` varchar(255) NOT NULL,
  `call_message` text NOT NULL,
  `call_date` datetime NOT NULL,
  `call_id` int(11) unsigned NOT NULL,
  `call_proof` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_callback`
--

INSERT INTO `yariko_callback` (`call_name`, `call_phone`, `call_email`, `call_message`, `call_date`, `call_id`, `call_proof`) VALUES
('qweqw', '+7(123) 123-12-31', '', '', '2016-06-22 08:53:31', 2, 0),
('Султан', '+7(985) 956-21-36', '', '', '2016-06-26 18:02:45', 3, 0),
('Владимир', '+7(988) 999-55-66', '', '', '2016-06-26 18:03:11', 4, 0),
('Варта', '+7(999) 999-99-99', '', '', '2016-07-26 00:01:47', 5, 0),
('Варта', '+7(999) 999-99-99', '', '', '2016-07-26 00:01:49', 6, 0),
('Варта', '+7(999) 999-99-99', '', '', '2016-07-26 00:01:54', 7, 0),
('Варта', '+7(999) 999-99-99', '', '', '2016-07-26 00:01:59', 8, 0),
('Варта', '+7(555) 555-55-55', '', '', '2016-07-26 00:02:31', 9, 0),
('Эльдар', '+7(999) 999-99-99', '', '', '2016-07-26 00:06:38', 10, 0),
('Эльдао', '+7(222) 222-22-22', '', '', '2016-07-26 00:09:19', 11, 0),
('zzzzzzzz', '+7(999) 999-99-99', '', '', '2016-07-26 00:10:05', 12, 0),
('Блаблабла', '+7(555) 555-55-55', '', '', '2016-07-26 00:11:05', 13, 0),
('Блаблабла', '+7(555) 555-55-55', '', '', '2016-07-26 00:11:07', 14, 0),
('Блаблабла', '+7(555) 555-55-55', '', '', '2016-07-26 00:11:25', 15, 0),
('Блаблабла', '+7(555) 555-55-55', '', '', '2016-07-26 00:11:25', 16, 0),
('Блаблабла', '+7(555) 555-55-55', '', '', '2016-07-26 00:11:26', 17, 0),
('Шами', '+7(999) 999-99-99', '', '', '2016-07-26 00:14:50', 18, 1),
('Шами', '+7(999) 999-99-99', '', '', '2016-07-26 00:15:39', 19, 1),
('Шами', '+7(999) 999-99-99', '', '', '2016-07-26 00:16:56', 20, 1),
('Шами', '+7(999) 999-99-99', '', '', '2016-07-26 00:18:00', 21, 1),
('Шами', '+7(999) 999-99-99', '', '', '2016-07-26 00:18:44', 22, 1),
('Роксана', '+7(852) 632-15-26', '', '', '2016-07-26 00:19:40', 23, 1),
('Блаблабла', '+7(888) 888-88-88', '', '', '2016-07-26 15:57:24', 24, 1),
('Шамиль', '+7(999) 999-99-99', '', '', '2016-07-26 15:58:23', 25, 1),
('Шапи', '+7(999) 999-99-99', '', '', '2016-07-26 15:59:43', 26, 1),
('Шапии', '+7(999) 999-99-99', '', '', '2016-07-26 16:03:13', 27, 1),
('Шапии', '+7(999) 999-99-99', '', '', '2016-07-26 16:03:25', 28, 1),
('ulogin', '+7(888) 888-88-88', '', '', '2016-07-26 16:04:29', 29, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_cats`
--

CREATE TABLE IF NOT EXISTS `yariko_cats` (
  `cat_id` int(11) unsigned NOT NULL,
  `cat_title` varchar(255) NOT NULL,
  `cat_slug` varchar(255) NOT NULL,
  `cat_fullslug` varchar(255) NOT NULL,
  `cat_parent` int(11) unsigned NOT NULL,
  `cat_keywords` text NOT NULL,
  `cat_description` text NOT NULL,
  `cat_text` text NOT NULL,
  `cat_datecreate` datetime NOT NULL,
  `cat_dateupdate` datetime NOT NULL,
  `cat_params` text NOT NULL,
  `cat_visible` tinyint(1) NOT NULL DEFAULT '1',
  `catpicture_path` varchar(255) NOT NULL,
  `catpicture` varchar(255) NOT NULL,
  `catgallery_path` varchar(255) NOT NULL,
  `catgallery` varchar(255) NOT NULL,
  `cat_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_cats`
--

INSERT INTO `yariko_cats` (`cat_id`, `cat_title`, `cat_slug`, `cat_fullslug`, `cat_parent`, `cat_keywords`, `cat_description`, `cat_text`, `cat_datecreate`, `cat_dateupdate`, `cat_params`, `cat_visible`, `catpicture_path`, `catpicture`, `catgallery_path`, `catgallery`, `cat_mediafields`) VALUES
(16, 'Зима', 'zima', 'zima', 0, '', '', '', '2016-06-21 08:57:13', '2016-06-21 08:57:13', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(17, 'Байка', 'bayka', 'bayka', 0, '', '', '', '2016-06-21 08:57:25', '2016-06-21 08:57:25', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(18, 'Кроссовки', 'krossovki', 'krossovki', 0, '', '', '', '2016-06-21 08:57:43', '2016-06-21 08:57:43', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(19, 'Link', 'link', 'krossovki/link', 18, '', '', '', '2016-06-21 08:57:53', '2016-06-21 08:57:53', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(20, 'Ботинки (комфорт)', 'botinki_komfort', 'botinki_komfort', 0, '', '', '', '2016-06-21 08:58:12', '2016-06-21 08:58:12', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(21, 'Туфли мужские', 'tufli_muzhskie', 'tufli_muzhskie', 0, '', '', '', '2016-06-21 08:58:24', '2016-06-21 08:58:24', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(22, 'Мокасины', 'mokasiny', 'mokasiny', 0, '', '', '', '2016-06-21 08:58:37', '2016-06-21 08:58:37', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(23, 'Большой размер', 'bolshoy_razmer', 'bolshoy_razmer', 0, '', '', '', '2016-06-21 08:58:46', '2016-06-21 08:58:46', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(24, 'Тапки', 'tapki', 'tapki', 0, '', '', '', '2016-06-21 08:58:55', '2016-06-21 08:58:55', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(25, 'Летняя обувь', 'letnyaya_obuv', 'letnyaya_obuv', 0, '', '', '', '2016-06-21 08:59:05', '2016-06-21 08:59:05', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(26, 'Берцы', 'bercy', 'bercy', 0, '', '', '', '2016-06-21 08:59:15', '2016-06-21 08:59:15', 'a:0:{}', 1, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_delivery`
--

CREATE TABLE IF NOT EXISTS `yariko_delivery` (
  `delivery_id` int(11) unsigned NOT NULL,
  `delivery_title` varchar(255) NOT NULL,
  `delivery_name` varchar(255) NOT NULL,
  `delivery_description` text NOT NULL,
  `delivery_datecreate` datetime NOT NULL,
  `delivery_dateupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_menus`
--

CREATE TABLE IF NOT EXISTS `yariko_menus` (
  `menu_id` int(11) unsigned NOT NULL,
  `menu_title` varchar(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_datecreate` datetime NOT NULL,
  `menu_dateupdate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_menus`
--

INSERT INTO `yariko_menus` (`menu_id`, `menu_title`, `menu_name`, `menu_datecreate`, `menu_dateupdate`) VALUES
(10, 'Категории товаров', 'menu-main-sidebar', '2016-06-26 14:43:54', '2016-06-26 14:43:54'),
(13, 'Главное меню', 'menu-main-header', '2016-08-03 15:02:12', '2016-08-03 15:02:12');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_menus_objects`
--

CREATE TABLE IF NOT EXISTS `yariko_menus_objects` (
  `object_id` int(11) unsigned NOT NULL,
  `object_mid` int(11) unsigned NOT NULL DEFAULT '0',
  `object_position` int(11) unsigned NOT NULL,
  `object_oid` int(11) unsigned NOT NULL,
  `object_parent` int(11) unsigned NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_tid` int(11) NOT NULL DEFAULT '0',
  `object_title` varchar(255) NOT NULL,
  `object_url` varchar(255) NOT NULL,
  `object_alt` varchar(255) NOT NULL,
  `object_blank` tinyint(1) NOT NULL DEFAULT '0',
  `object_description` text NOT NULL,
  `object_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_menus_objects`
--

INSERT INTO `yariko_menus_objects` (`object_id`, `object_mid`, `object_position`, `object_oid`, `object_parent`, `object_type`, `object_tid`, `object_title`, `object_url`, `object_alt`, `object_blank`, `object_description`, `object_mediafields`) VALUES
(72, 10, 1, 1, 0, 'cat', 16, 'Зима', '/category/zima/', '', 0, '', 'a:0:{}'),
(73, 10, 2, 2, 0, 'cat', 17, 'Байка', '/category/bayka/', '', 0, '', 'a:0:{}'),
(74, 10, 3, 3, 0, 'cat', 18, 'Кроссовки', '/category/krossovki/', '', 0, '', 'a:0:{}'),
(75, 10, 4, 5, 0, 'cat', 20, 'Ботинки (комфорт)', '/category/botinki_komfort/', '', 0, '', 'a:0:{}'),
(76, 10, 5, 6, 0, 'cat', 21, 'Туфли мужские', '/category/tufli_muzhskie/', '', 0, '', 'a:0:{}'),
(77, 10, 6, 7, 0, 'cat', 22, 'Мокасины', '/category/mokasiny/', '', 0, '', 'a:0:{}'),
(78, 10, 7, 8, 0, 'cat', 23, 'Большой размер', '/category/bolshoy_razmer/', '', 0, '', 'a:0:{}'),
(79, 10, 8, 9, 0, 'cat', 24, 'Тапки', '/category/tapki/', '', 0, '', 'a:0:{}'),
(80, 10, 9, 10, 0, 'cat', 25, 'Летняя обувь', '/category/letnyaya_obuv/', '', 0, '', 'a:0:{}'),
(81, 10, 10, 11, 0, 'cat', 26, 'Берцы', '/category/bercy/', '', 0, '', 'a:0:{}'),
(94, 13, 1, 2, 0, 'url', 0, 'Главная', '/', '', 0, '', 'a:0:{}'),
(95, 13, 2, 1, 0, 'page', 11, 'О нас', '/page/o_nas/', '', 0, '', 'a:0:{}'),
(96, 13, 3, 3, 0, 'url', 0, 'Оптовикам', 'http://89308955111.ru/', '', 1, '', 'a:0:{}'),
(97, 13, 4, 4, 0, 'page', 12, 'Оплата и Доставка', '/page/oplata_i_dostavka/', '', 0, '', 'a:0:{}'),
(98, 13, 5, 7, 0, 'url', 0, 'Блог', '/term/', '', 0, '', 'a:0:{}'),
(99, 13, 6, 5, 0, 'page', 13, 'Контакты', '/page/kontakty/', '', 0, '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_orders`
--

CREATE TABLE IF NOT EXISTS `yariko_orders` (
  `order_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `order_name` varchar(255) NOT NULL,
  `order_address` text NOT NULL,
  `order_phone` varchar(255) NOT NULL,
  `order_email` varchar(255) NOT NULL,
  `order_message` text NOT NULL,
  `order_date` datetime NOT NULL,
  `order_products` text NOT NULL,
  `order_proof` int(1) unsigned NOT NULL DEFAULT '0',
  `order_sum` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_orders`
--

INSERT INTO `yariko_orders` (`order_id`, `user_id`, `order_name`, `order_address`, `order_phone`, `order_email`, `order_message`, `order_date`, `order_products`, `order_proof`, `order_sum`) VALUES
(4, 1, 'Генерал Адмирал Алладин', 'РД, г.Махачкала ул.Дахадаева 48', '+7(989) 880-07-02', 'ex3xeng@yandex.ru', 'yalalala', '2016-06-26 10:47:04', '13|2,14|3,12|1', 1, 29000),
(5, 4, 'Шамиль', 'Кизилюрт', '+7(928) 984-11-63', 'aaa@mail.ru', 'Можете поставить ещё пару обуви?', '2016-06-26 14:42:19', '13|1', 0, 4750),
(6, 4, 'Логотип', 'Кизилюрт', '+7(222) 222-22-22', 'a_shoma@mail.ru', 'Тестовое примечание', '2016-06-26 16:03:30', '12|1,13|1,14|1', 1, 14250),
(7, 13, 'Магомедов Рустам', 'asd', '+7(234) 234-23-42', 'sdfsdfsd@sdfgsdfg.ru', 'gsdfgsdfg', '2016-07-24 15:29:39', '12|1', 1, 4500),
(8, 4, 'Шамиль', 'Кизилюрт', '+7(999) 999-99-99', 'project.local@domain.com', 'ффффффффффффффффффффффффффффффффффффффффффффф', '2016-07-25 23:46:41', '12|1', 1, 4500),
(9, 13, 'Магомедов Рустам', 'dfg', '+7(342) 342-34-23', 'sdfsdfsd@sdfgsdfg.ru', 'sdfg', '2016-07-25 23:47:41', '12|1', 0, 4500),
(10, 4, 'Логотип', 'Кизилюрт', '+7(999) 999-99-99', 'project.local@domain.com', 'asaasaaaaaaaaaaaaaaaaaaa', '2016-07-25 23:51:35', '13|1,12|1', 0, 9500),
(11, 4, 'Логотип', 'Кизилюрт', '+7(555) 555-55-55', 'project.local@domain.com', 'фффффффффффффффффф', '2016-07-26 00:13:55', '12|1', 1, 4500),
(12, 0, 'Шамиль', 'Кизилюрт', '+7(999) 999-99-99', 'shoma.alisultanov@yandex.ru', 'aaaa', '2016-07-27 20:27:48', '12|1,14|2', 1, 15000),
(13, 0, 'Интернет эксплорер тест', 'Интернет эксплорер тест', '+7(888) 888-88-88', 'aa@ie.ru', 'Интернет эксплорер тест', '2016-07-27 21:23:53', '16|2', 0, 31996),
(14, 19, 'Алисултанов Шамиль Нурмагомедович', 'Москва', '+7(892) 887-32-46', 'shoma.alisultanov@yandex.ru', 'Примечение', '2016-07-30 12:15:51', '12|1,14|1', 1, 10000),
(15, 19, 'Алисултанов Шамиль Нурмагомедович', 'Москва', '+7(892) 887-32-46', 'shoma.alisultanov@yandex.ru', 'Вася как ты брат?', '2016-08-02 19:20:48', '18|4', 1, 4800),
(17, 20, 'Заманский Дмитрий', 'Израиль, Реховот', '+7(985) 111-44-22', 'aa11a@mail.ru', 'БЕРУ!', '2016-08-02 21:06:31', '16|1,14|1', 1, 20998),
(18, 20, 'Заманский Дмитрий', 'Израиль, Рехоовт', '+7(880) 035-07-00', 'aaaa@gmail.com', 'Б Е Р У!', '2016-08-02 21:09:31', '17|1,18|1,19|3,16|1', 1, 35798);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_pages`
--

CREATE TABLE IF NOT EXISTS `yariko_pages` (
  `page_id` int(11) unsigned NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_fullslug` varchar(255) NOT NULL,
  `page_parent` int(11) unsigned NOT NULL,
  `page_keywords` text NOT NULL,
  `page_description` text NOT NULL,
  `page_text` text NOT NULL,
  `page_datecreate` datetime NOT NULL,
  `page_dateupdate` datetime NOT NULL,
  `page_params` text NOT NULL,
  `page_visible` tinyint(1) NOT NULL DEFAULT '1',
  `pagepicture_path` varchar(255) NOT NULL,
  `pagepicture` varchar(255) NOT NULL,
  `pagegallery_path` varchar(255) NOT NULL,
  `pagegallery` varchar(255) NOT NULL,
  `page_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_pages`
--

INSERT INTO `yariko_pages` (`page_id`, `page_title`, `page_slug`, `page_fullslug`, `page_parent`, `page_keywords`, `page_description`, `page_text`, `page_datecreate`, `page_dateupdate`, `page_params`, `page_visible`, `pagepicture_path`, `pagepicture`, `pagegallery_path`, `pagegallery`, `page_mediafields`) VALUES
(11, 'О нас', 'o_nas', 'o_nas', 0, '', '', '&lt;p&gt;&lt;img style=&quot;float: left; margin-right: 10px;&quot; src=&quot;/files/uploads/2416830421_6.jpg?1467310163795&quot; alt=&quot;&quot; width=&quot;360&quot; height=&quot;270&quot; /&gt;&lt;/p&gt;\r\n&lt;p&gt;Компания Yariko основана в 2010 году и представляет собой стремительно развивающееся предприятие, которое на сегодняшний день занимает лидирующие позиции в области разработки, производства и продажи качественной и стильной обуви для мужчин.&amp;nbsp;Основная цель компании &amp;ndash; угодить каждому покупателю, предлагая оптимальное соотношение цены и качества. &amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Благодаря тщательному подходу к выбору материалов, высокому контролю качества на всех этапах производства, подбору исключительно высококвалифицированных специалистов с многолетним опытом работы, компания Yariko гарантирует своим покупателям разнообразный ассортимент качественной обуви. &amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Мы предлагаем Вам мужскую обувь оптом без размерных рядов универсальных повседневных или спортивных моделей зимнего и летнего сезона, так же в нашем каталоге представлены редкие модные новинки, которые Вы сможете заказать только здесь. К тому же, просматривая ассортимент, Вы встретите популярные модели прошлых и самые горячие новинки последних коллекций демисезонной обуви. &amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Разнообразие моделей, оригинальный стиль, неизменно высокое качество каждой единицы товара, гибкая ценовая политика &amp;ndash; вот, что выгодно отличает нас от конкурентов.&lt;/p&gt;', '2016-06-21 09:12:47', '2016-06-30 21:10:54', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(12, 'Оплата и Доставка', 'oplata_i_dostavka', 'oplata_i_dostavka', 0, '', '', '&lt;p&gt;&lt;img style=&quot;display: block; margin-left: auto; margin-right: auto;&quot; src=&quot;/files/uploads/2416196221_5.jpg?1467310294312&quot; alt=&quot;&quot; width=&quot;180&quot; height=&quot;135&quot; /&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;УСЛОВИЯ ДОСТАВКИ&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;Мы доставляем заказы БЕСПЛАТНО до любой из нижеперечисленных транспортных компаний:&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://www.jde.ru/&quot;&gt;Желдор&lt;/a&gt;&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://www.dellin.ru/&quot; target=&quot;_blank&quot;&gt;Деловые линии&amp;nbsp;&lt;/a&gt;&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://pecom.ru/ru/&quot; target=&quot;_blank&quot;&gt;ПЭК&lt;/a&gt;&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://www.dpd.ru/&quot; target=&quot;_blank&quot;&gt;DPD&lt;/a&gt;&lt;/p&gt;\r\n&lt;p style=&quot;text-align: center;&quot;&gt;&lt;a href=&quot;http://www.baikalsr.ru/&quot; target=&quot;_blank&quot;&gt;Байкал-Сервис&lt;/a&gt;&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://www.rateksib.ru/&quot; target=&quot;_blank&quot;&gt;Ратэк&lt;/a&gt;&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://www.ae5000.ru/&quot; target=&quot;_blank&quot;&gt;Автотрейдинг&lt;/a&gt;&lt;/p&gt;\r\n&lt;p align=&quot;center&quot;&gt;&lt;a href=&quot;http://tk-kit.ru/&quot; target=&quot;_blank&quot;&gt;КИТ&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;Все&amp;nbsp;товары, раз&amp;shy;ме&amp;shy;щен&amp;shy;ные на&amp;nbsp;сайте, есть на&amp;nbsp;нашем складе и&amp;nbsp;готовы к&amp;nbsp;отгруз&amp;shy;ке. Отгрузка про&amp;shy;из&amp;shy;во&amp;shy;дится сразу после под&amp;shy;твер&amp;shy;жде&amp;shy;ния заказа и оплаты 100 % его стоимости.&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 18pt;&quot;&gt;О службе доставки&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;Мы&amp;nbsp;сотруд&amp;shy;ни&amp;shy;чаем с&amp;nbsp;лучшими курьер&amp;shy;скими служ&amp;shy;бами для&amp;nbsp;того, чтобы сделать доставку мак&amp;shy;си&amp;shy;мально удоб&amp;shy;ной. Ваши отзывы имеют большое зна&amp;shy;че&amp;shy;ние для&amp;nbsp;нас. Пожа&amp;shy;луй&amp;shy;ста, рас&amp;shy;ска&amp;shy;жи&amp;shy;те, что&amp;nbsp;Вам хотелось бы&amp;nbsp;изменить или&amp;nbsp;доба&amp;shy;вить, для&amp;nbsp;улуч&amp;shy;ше&amp;shy;ния каче&amp;shy;ства предо&amp;shy;став&amp;shy;ля&amp;shy;е&amp;shy;мых товаров: &lt;a href=&quot;mailto:yariko86@mail.ru&quot;&gt;yariko86@mail.ru&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-size: 18pt;&quot;&gt;СПОСОБЫ ОПЛАТЫ&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;Понра&amp;shy;вив&amp;shy;ши&amp;shy;еся модели обуви Вы&amp;nbsp;можете опла&amp;shy;тить пере&amp;shy;чис&amp;shy;лен&amp;shy;ными ниже спо&amp;shy;со&amp;shy;ба&amp;shy;ми *.&lt;/p&gt;\r\n&lt;p&gt;1.Банковская карта&lt;/p&gt;\r\n&lt;p&gt;Вы можете опла&amp;shy;тить Ваш&amp;nbsp;заказ бан&amp;shy;ков&amp;shy;ской картой (Visa&amp;nbsp;и&amp;nbsp;MasterCard); осуществить перевод (через систему Сбербанк-онлайн) с карты Сбербанка на карту Сбербанка; оплата через квитанцию в отделении Сбербанка&amp;nbsp; &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;2. Безналичный расчет&lt;/p&gt;\r\n&lt;p&gt;Вы можете оплатить Ваш заказ путем перечисления денежных средств с вашего счета на счет нашей компании. После того как вы сформируете ваш заказ, мы выставляем счет, который вы оплачиваете.&lt;/p&gt;\r\n&lt;p&gt;3. Оплата электронными деньгами: &amp;laquo;Яндекс-деньги&amp;raquo;, &amp;laquo;Киви-кошелек&amp;raquo;&lt;/p&gt;\r\n&lt;p&gt;* Обращаем Ваше внимание на то, что комплектация заказа и доставка до ТК производится в срок не более 3 дней после оплаты 100 % стоимости заказа. &amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Бес&amp;shy;плат&amp;shy;ный телефон для&amp;nbsp;справок 8 (800) 775-30-83&lt;/p&gt;\r\n&lt;p style=&quot;display: inline !important;&quot; align=&quot;center&quot;&gt;Надеемся на взаимопонимание и дальнейшее сотрудничество!&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '2016-06-21 09:13:52', '2016-06-30 21:14:49', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(13, 'Контакты', 'kontakty', 'kontakty', 0, '', '', '&lt;p&gt;Телефон:8 (800) 775-30-83-звонок по России бесплатный&lt;br /&gt;&amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; 8 (499) 403-36-05&lt;/p&gt;\r\n&lt;p&gt;&lt;br /&gt;&lt;span data-mce-mark=&quot;1&quot;&gt;Адрес: г. Москва&lt;/span&gt;&lt;span data-mce-mark=&quot;1&quot;&gt;&amp;nbsp;ул. Абрамцевская д. 1&lt;/span&gt;&lt;/p&gt;\r\n&lt;p&gt;Время работы: понедельник-суббота&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Прием звонков с 09:00 до 14:00&lt;/p&gt;\r\n&lt;p&gt;Прием заявок: круглосуточно!&lt;br /&gt;&lt;br /&gt;E-mail: &lt;a href=&quot;mailto:Yariko86@mail.ru&quot;&gt;Yariko86@mail.ru&lt;/a&gt;&lt;/p&gt;\r\n&lt;p&gt;Наши реквизиты :&lt;/p&gt;\r\n&lt;p&gt;ИП Умалхатова Карина Джанбулатовна, ИНН 055202207560&lt;/p&gt;\r\n&lt;p&gt;Юридический адрес: Респ.Дагестан, Кумторкалинский район, с. Коркмаскала, ул. Сталина, д.189&lt;/p&gt;\r\n&lt;p&gt;Фактический адрес: г. Москва, ул. Абрамцевская, д. 1&lt;/p&gt;\r\n&lt;p&gt;Банк получателя:&amp;nbsp; ОАО Акционерный коммерческий Сберегательный банк РФ Адрес: г. Ставрополь. БИК 040702660к/с30101810600000000660р/с 40802810860320002695 ОГРНИП &amp;nbsp;1020500000619, ИНН 055202207560&lt;/p&gt;', '2016-06-21 09:14:25', '2016-06-30 21:20:59', 'a:0:{}', 1, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_posts`
--

CREATE TABLE IF NOT EXISTS `yariko_posts` (
  `post_id` int(11) unsigned NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_author` int(11) unsigned NOT NULL,
  `post_keywords` text NOT NULL,
  `post_description` text NOT NULL,
  `post_text` text NOT NULL,
  `post_quote` text NOT NULL,
  `post_datecreate` datetime NOT NULL,
  `post_datepublic` datetime NOT NULL,
  `post_dateupdate` datetime NOT NULL,
  `post_params` text NOT NULL,
  `post_visible` tinyint(1) NOT NULL DEFAULT '1',
  `post_special` tinyint(1) NOT NULL DEFAULT '0',
  `postpicture_path` varchar(255) NOT NULL,
  `postpicture` varchar(255) NOT NULL,
  `postgallery_path` varchar(255) NOT NULL,
  `postgallery` varchar(255) NOT NULL,
  `post_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_posts`
--

INSERT INTO `yariko_posts` (`post_id`, `post_title`, `post_name`, `post_slug`, `post_author`, `post_keywords`, `post_description`, `post_text`, `post_quote`, `post_datecreate`, `post_datepublic`, `post_dateupdate`, `post_params`, `post_visible`, `post_special`, `postpicture_path`, `postpicture`, `postgallery_path`, `postgallery`, `post_mediafields`) VALUES
(1, 'ДЛЯ БЕРЕМЕННЫХ', '', 'dlya_beremennyh', 4, '', '', '&lt;p&gt;Полная запись&lt;/p&gt;', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti eius, eligendi ipsa iure laborum quibusdam sunt vel? Cumque cupiditate, eos error incidunt laborum maiores minus officiis praesentium quas sapiente.&lt;/p&gt;', '2016-06-02 21:36:32', '0000-00-00 00:00:00', '2016-06-25 17:44:13', 'a:0:{}', 1, 1, '/files/posts/postpicture/2016/06/25/6/1/', '0_1.jpg', '', '', 'a:0:{}'),
(2, 'РЕЛЛАКС', '', 'rellaks', 4, '', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti eius, eligendi ipsa iure laborum quibusdam sunt vel? Cumque cupiditate, eos error incidunt laborum maiores minus officiis praesentium quas sapiente.&lt;/p&gt;', '2016-06-02 21:38:31', '0000-00-00 00:00:00', '2016-06-25 17:44:31', 'a:0:{}', 1, 1, '/files/posts/postpicture/2016/06/25/6/2/', '0_2.jpg', '', '', 'a:0:{}'),
(3, 'WELLNESS', '', 'wellness', 4, '', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti eius, eligendi ipsa iure laborum quibusdam sunt vel? Cumque cupiditate, eos error incidunt laborum maiores minus officiis praesentium quas sapiente.&lt;/p&gt;', '2016-06-02 21:39:18', '0000-00-00 00:00:00', '2016-06-25 17:44:46', 'a:0:{}', 1, 1, '/files/posts/postpicture/2016/06/25/6/3/', '0_3.jpg', '', '', 'a:0:{}'),
(4, 'AЮРВЕДА', '', 'ayurveda', 4, '', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti eius, eligendi ipsa iure laborum quibusdam sunt vel? Cumque cupiditate, eos error incidunt laborum maiores minus officiis praesentium quas sapiente.&lt;/p&gt;', '2016-06-02 21:40:08', '0000-00-00 00:00:00', '2016-06-25 17:45:03', 'a:0:{}', 1, 1, '/files/posts/postpicture/2016/06/25/6/4/', '0_4.jpg', '', '', 'a:0:{}'),
(5, 'ЭНЕРГИЯ', '', 'energiya', 19, '', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti eius, eligendi ipsa iure laborum quibusdam sunt vel? Cumque cupiditate, eos error incidunt laborum maiores minus officiis praesentium quas sapiente.&lt;/p&gt;', '2016-06-02 21:41:04', '0000-00-00 00:00:00', '2016-08-02 21:13:58', 'a:0:{}', 1, 1, '/files/posts/postpicture/2016/06/25/6/5/', '0_5.jpg', '', '', 'a:0:{}'),
(6, 'АНТИЦЕЛЛЮЛИТ', '', 'anticellyulit', 4, '', '', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum deleniti eius, eligendi ipsa iure laborum quibusdam sunt vel? Cumque cupiditate, eos error incidunt laborum maiores minus officiis praesentium quas sapiente.&lt;/p&gt;', '2016-06-02 21:41:34', '0000-00-00 00:00:00', '2016-06-25 17:45:36', 'a:0:{}', 1, 1, '/files/posts/postpicture/2016/06/25/6/6/', '0_6.jpg', '', '', 'a:0:{}'),
(8, 'Тестовая запись в СПА', 'Тестовая запись в СПАТестовая запись в СПА', 'testovaya_zapis_v_spa', 19, 'Тестовая запись в СПА, Тестовая запись в СПА2', 'Тестовая запись в СПАТестовая запись в СПАТестовая запись в СПА', '&lt;p&gt;&lt;img style=&quot;float: left;&quot; src=&quot;/files/uploads/menu.jpg?1466945933932&quot; width=&quot;246&quot; height=&quot;303&quot; /&gt;&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil tenetur nostrum dignissimos ullam modi provident, fugiat perspiciatis enim ipsa, illum dolor, quam, laborum impedit hic? Corrupti quisquam alias est laboriosam ut consequuntur nemo ducimus, perferendis sed, excepturi aliquam recusandae consequatur distinctio libero soluta delectus adipisci non minus porro officia amet necessitatibus natus cumque? Consequatur voluptatum, repellendus sequi iusto facilis excepturi maxime magni quibusdam at facere eius temporibus quos ratione iure ea sint animi quaerat! Voluptatibus tempore non architecto vero veritatis sapiente blanditiis recusandae suscipit tenetur necessitatibus. Nam laudantium, voluptatibus rem deserunt odit mollitia odio fugiat provident harum asperiores perferendis ex pariatur obcaecati nihil officia repellendus dolorem, cumque aspernatur sapiente deleniti et delectus unde dignissimos eos maxime! Iusto nesciunt soluta laborum quasi, dignissimos, nisi aliquam maxime odio id quibusdam, reiciendis natus numquam voluptatem minus quisquam neque et? Consectetur odit quod voluptate explicabo, non earum suscipit est cum ullam esse neque aliquid excepturi voluptas, nihil facilis! Odit neque voluptas facere earum soluta, quasi suscipit sapiente pariatur qui incidunt deserunt ab nesciunt nulla, temporibus quaerat voluptatibus voluptatem dolor, omnis recusandae aliquam repudiandae hic dignissimos! Inventore molestias amet quo accusantium quae est, ullam, quod quos dicta magnam quaerat consequatur delectus natus commodi sint neque earum iusto dolores placeat non aliquam reiciendis id a! Illo veniam ducimus suscipit non pariatur, optio inventore molestiae praesentium dolores hic a facilis excepturi, velit necessitatibus similique nisi amet, fugit quia enim, illum! Ratione illo, veritatis ullam aperiam laudantium dicta a distinctio laborum quasi perferendis! Ullam aperiam in tenetur, deleniti nulla quisquam. Voluptatem dolorem, architecto distinctio cupiditate officiis aperiam excepturi eum, ullam enim similique est, ipsum! Excepturi voluptatibus repudiandae facere, tempore eum illo architecto veritatis assumenda molestias cupiditate deserunt aut laboriosam officiis at sed obcaecati amet. Adipisci dignissimos quidem ullam voluptas vel sequi, aspernatur quibusdam perferendis nisi delectus quia consequuntur?&lt;/p&gt;', '&lt;p&gt;Тестовая запись в СПА&lt;/p&gt;', '2016-06-26 15:58:20', '0000-00-00 00:00:00', '2016-07-27 21:29:38', 'a:0:{}', 1, 0, '/files/posts/postpicture/2016/06/25/7/8/', '0_8.jpg', '', '', 'a:0:{}'),
(9, 'Добавить запись', 'Добавить запись Добавить запись', 'dobavit_zapis', 19, 'Добавить запись', 'Добавить запись', '&lt;h1 class=&quot;page-header&quot;&gt;Добавить запись&lt;/h1&gt;\r\n&lt;h1 class=&quot;page-header&quot;&gt;Добавить запись&lt;/h1&gt;\r\n&lt;h1 class=&quot;page-header&quot;&gt;Добавить запись&lt;/h1&gt;', '&lt;h1 class=&quot;page-header&quot;&gt;Добавить запись&lt;/h1&gt;', '2016-07-30 12:16:45', '0000-00-00 00:00:00', '2016-07-30 12:16:45', 'a:0:{}', 1, 0, '', '', '', '', 'a:0:{}'),
(10, 'Ботинки', 'Ботинки', 'botinki', 20, 'Обувь, ботинки, мужская обувь, зимняя обувь, осення обувь', '', '&lt;p&gt;В современных ботинках часто используется &lt;a title=&quot;Застёжка-молния&quot; href=&quot;https://ru.wikipedia.org/wiki/%D0%97%D0%B0%D1%81%D1%82%D1%91%D0%B6%D0%BA%D0%B0-%D0%BC%D0%BE%D0%BB%D0%BD%D0%B8%D1%8F&quot;&gt;застёжка-молния&lt;/a&gt; вместо шнурков (или вместе с ними). Кроме того, у некоторых ботинок (например челси) шнуровки нет вообще, а вместо неё используются две резиновые вставки по бокам. На каждый сезон свои ботинки. Обычно ботинки применяются зимой (для защиты от снега), весной и осенью (для защиты от грязи и глубоких луж). Существуют также специальные ботинки, например лыжные.&lt;/p&gt;\r\n&lt;p&gt;Летние могут быть сделаны из пористого материала для вентиляции, но обычно вместо них летом носят &lt;a title=&quot;Туфли&quot; href=&quot;https://ru.wikipedia.org/wiki/%D0%A2%D1%83%D1%84%D0%BB%D0%B8&quot;&gt;туфли&lt;/a&gt;. Ботинки подвержены моде, которая определяет их &lt;a class=&quot;new&quot; title=&quot;Фасон (страница отсутствует)&quot; href=&quot;https://ru.wikipedia.org/w/index.php?title=%D0%A4%D0%B0%D1%81%D0%BE%D0%BD&amp;amp;action=edit&amp;amp;redlink=1&quot;&gt;фасон&lt;/a&gt;(форму носков, высоту каблуков и&amp;nbsp;т.&amp;nbsp;д.). Зимние ботинки отличаются от демисезонных тем, что они гораздо теплее.&lt;/p&gt;', '&lt;p&gt;&lt;strong&gt;Боти́нки&lt;/strong&gt;, &lt;strong&gt;полусапо́жки&lt;/strong&gt;&amp;nbsp;&amp;mdash; обувь, закрывающая ногу по лодыжку, чаще мужская, чем женская. Классические ботинки изготовлены из кожи и завязываются &lt;a title=&quot;Шнурки&quot; href=&quot;https://ru.wikipedia.org/wiki/%D0%A8%D0%BD%D1%83%D1%80%D0%BA%D0%B8&quot;&gt;шнурками&lt;/a&gt;. Однако возможны вариации формы, материала и способа завязывания.&lt;/p&gt;', '2016-08-02 21:14:25', '0000-00-00 00:00:00', '2016-08-02 21:14:25', 'a:0:{}', 1, 0, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_posts_relationships`
--

CREATE TABLE IF NOT EXISTS `yariko_posts_relationships` (
  `post_id` int(11) unsigned NOT NULL,
  `term_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_posts_relationships`
--

INSERT INTO `yariko_posts_relationships` (`post_id`, `term_id`) VALUES
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 5),
(6, 4),
(8, 1),
(9, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_products`
--

CREATE TABLE IF NOT EXISTS `yariko_products` (
  `product_id` int(11) unsigned NOT NULL,
  `product_article` varchar(255) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_slug` varchar(255) NOT NULL,
  `product_author` int(11) unsigned NOT NULL,
  `product_keywords` text NOT NULL,
  `product_description` text NOT NULL,
  `product_text` text NOT NULL,
  `product_quote` text NOT NULL,
  `product_datecreate` datetime NOT NULL,
  `product_dateupdate` datetime NOT NULL,
  `product_params` text NOT NULL,
  `product_visible` tinyint(1) NOT NULL DEFAULT '1',
  `product_special` tinyint(1) NOT NULL DEFAULT '0',
  `product_views` int(11) unsigned NOT NULL DEFAULT '0',
  `product_rating` int(11) unsigned NOT NULL DEFAULT '0',
  `product_price` int(11) unsigned NOT NULL DEFAULT '0',
  `product_pricewithdiscount` int(11) unsigned NOT NULL,
  `product_sales` int(11) unsigned NOT NULL DEFAULT '0',
  `product_discount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `product_simular` varchar(255) NOT NULL,
  `productpicture_path` varchar(255) NOT NULL,
  `productpicture` varchar(255) NOT NULL,
  `productgallery_path` varchar(255) NOT NULL,
  `productgallery` varchar(255) NOT NULL,
  `product_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_products`
--

INSERT INTO `yariko_products` (`product_id`, `product_article`, `product_title`, `product_slug`, `product_author`, `product_keywords`, `product_description`, `product_text`, `product_quote`, `product_datecreate`, `product_dateupdate`, `product_params`, `product_visible`, `product_special`, `product_views`, `product_rating`, `product_price`, `product_pricewithdiscount`, `product_sales`, `product_discount`, `product_simular`, `productpicture_path`, `productpicture`, `productgallery_path`, `productgallery`, `product_mediafields`) VALUES
(12, 'as23-45', 'Наименование товара', 'as23-45', 18, '', '', '', '', '2016-06-21 11:56:34', '2016-07-26 15:51:33', 'a:5:{s:6:"param1";s:33:"Производитель|Reebok";s:6:"param2";s:25:"Материал|Кожа";s:6:"param3";s:35:"Размер|38, 39, 40, 41, 42, 43";s:6:"param4";s:46:"Внутренний материал|Кожа";s:6:"param5";s:35:"Цвета|Белый, черный";}', 1, 0, 0, 0, 5000, 5000, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/06/25/2/12/', '0_12.jpg', '/files/products/productgallery/2016/06/25/2/12/', '0_12.jpg|1_12.jpg|2_12.jpg', 'a:0:{}'),
(13, 'as23-14', 'Наименование товара', 'as13-14', 18, '', '', '', '', '2016-06-21 11:59:19', '2016-07-26 15:50:06', 'a:6:{s:6:"param1";s:33:"Производитель|Reebok";s:6:"param2";s:25:"Материал|Кожа";s:6:"param3";s:35:"Размер|38, 39, 40, 41, 42, 43";s:6:"param4";s:46:"Внутренний материал|Кожа";s:6:"param5";s:35:"Цвета|Белый, черный";s:29:"Другой параметр";s:29:"Другое значение";}', 0, 0, 0, 0, 5000, 5000, 1, 0, 'a:0:{}', '/files/products/productpicture/2016/06/25/2/13/', '0_13.jpg', '/files/products/productgallery/2016/06/25/2/13/', '0_13.jpg|1_13.jpg|2_13.jpg', 'a:0:{}'),
(14, 'as23-54', 'Наименование товара', 'as33-54', 4, '', '', '', '', '2016-06-21 12:00:11', '2016-06-25 16:07:16', 'a:0:{}', 1, 0, 0, 0, 5000, 5000, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/06/25/2/14/', '0_14.jpg', '', '', 'a:0:{}'),
(16, '2323232323', 'Кроссовки Reebok мужские', '2323232323', 4, 'кросы, кросы2', 'Описание кроссовок', '&lt;p&gt;Добавляю описание&lt;/p&gt;', '', '2016-06-30 21:02:38', '2016-07-26 21:55:46', 'a:0:{}', 1, 1, 0, 0, 15998, 15998, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/06/26/4/16/', '0_16.jpg', '/files/products/productgallery/2016/06/26/4/16/', '0_16.jpg|1_16.jpg|2_16.jpg|3_16.jpg|4_16.jpg', 'a:0:{}'),
(17, '23235262', 'Тестовое название обуви', '23235262', 16, 'ыф', 'фыыффы', '', '', '2016-07-26 00:22:26', '2016-07-26 00:31:07', 'a:0:{}', 1, 0, 0, 0, 15000, 15000, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/07/30/2/17/', '0_17.jpg', '/files/products/productgallery/2016/07/30/2/17/', '0_17.jpg|1_17.jpg|2_17.jpg', 'a:0:{}'),
(18, 'new111', 'Новый товар 111', 'new111', 19, '', '', '&lt;p&gt;ыфффффффффффффффф&lt;/p&gt;\r\n&lt;p&gt;фыыыыыыыыыыыыыыыыыыыыыыыыыыыыыыыыыыы&lt;/p&gt;\r\n&lt;p&gt;фыыфыфыфыфыфыфыыыыыыыыыыыыыыыыыыы&lt;/p&gt;\r\n&lt;p&gt;фыыыыыыыыыыыыыыыыыыыыыыыыыыыыыы&lt;/p&gt;\r\n&lt;p&gt;фыыыыыыыыыыыыыыыыыыыыыыыыыыыыы&lt;/p&gt;', '', '2016-07-26 00:30:47', '2016-07-31 13:19:41', 'a:0:{}', 1, 0, 0, 0, 1200, 1200, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/07/30/2/18/', '0_18.jpg', '/files/products/productgallery/2016/07/30/2/18/', '0_18.jpg|1_18.jpg', 'a:0:{}'),
(19, 'zima05', 'Новый тестовый товар', 'zima05', 19, 'кл1, кл2', 'четкое описание', '&lt;p&gt;Описание - это наше все и это довольно круто&lt;/p&gt;\r\n&lt;p&gt;&lt;img src=&quot;/files/uploads/2416196221_5.jpg?1470154773677&quot; alt=&quot;2416196221_5&quot; /&gt;&lt;/p&gt;', '', '2016-07-30 12:12:16', '2016-08-02 19:19:36', 'a:3:{s:6:"param1";s:33:"Производитель|Reebok";s:6:"param5";s:51:"Цвета|Красный, Синий, Черный";s:7:"param50";s:33:"Производитель|Reebok";}', 1, 0, 0, 0, 1200, 1200, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/07/30/6/19/', '0_19.jpg', '/files/products/productgallery/2016/07/30/6/19/', '0_19.jpg|1_19.jpg', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_products_relationships`
--

CREATE TABLE IF NOT EXISTS `yariko_products_relationships` (
  `product_id` int(11) unsigned NOT NULL,
  `cat_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_products_relationships`
--

INSERT INTO `yariko_products_relationships` (`product_id`, `cat_id`) VALUES
(12, 20),
(13, 18),
(14, 19),
(16, 18),
(19, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_sliders`
--

CREATE TABLE IF NOT EXISTS `yariko_sliders` (
  `slider_id` int(11) unsigned NOT NULL,
  `slider_name` varchar(255) NOT NULL,
  `slider_callname` varchar(255) NOT NULL,
  `slider_params` text NOT NULL,
  `slider_datecreate` datetime NOT NULL,
  `slider_dateupdate` datetime NOT NULL,
  `slider_visible` tinyint(1) NOT NULL DEFAULT '1',
  `slider_sliders` text NOT NULL,
  `slider_path` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_sliders`
--

INSERT INTO `yariko_sliders` (`slider_id`, `slider_name`, `slider_callname`, `slider_params`, `slider_datecreate`, `slider_dateupdate`, `slider_visible`, `slider_sliders`, `slider_path`) VALUES
(1, 'Слайдер на главной11', 'homeslider', 'a:0:{}', '2016-06-13 14:29:29', '2016-08-03 15:17:53', 1, 'a:3:{i:0;a:7:{s:5:"title";s:0:"";s:4:"link";s:1:"#";s:4:"text";s:0:"";s:5:"video";i:0;s:5:"blank";i:0;s:8:"videourl";s:0:"";s:6:"slider";s:7:"0_1.jpg";}i:1;a:7:{s:5:"title";s:0:"";s:4:"link";s:1:"#";s:4:"text";s:0:"";s:5:"video";i:0;s:5:"blank";i:0;s:8:"videourl";s:0:"";s:6:"slider";s:7:"1_1.jpg";}i:2;a:7:{s:5:"title";s:0:"";s:4:"link";s:1:"#";s:4:"text";s:0:"";s:5:"video";i:0;s:5:"blank";i:0;s:8:"videourl";s:0:"";s:6:"slider";s:7:"2_1.jpg";}}', '/files/sliders/2016/06/25/2/1/');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_terms`
--

CREATE TABLE IF NOT EXISTS `yariko_terms` (
  `term_id` int(11) unsigned NOT NULL,
  `term_title` varchar(255) NOT NULL,
  `term_slug` varchar(255) NOT NULL,
  `term_fullslug` varchar(255) NOT NULL,
  `term_parent` int(11) unsigned NOT NULL,
  `term_keywords` text NOT NULL,
  `term_description` text NOT NULL,
  `term_text` text NOT NULL,
  `term_datecreate` datetime NOT NULL,
  `term_dateupdate` datetime NOT NULL,
  `term_params` text NOT NULL,
  `term_visible` tinyint(1) NOT NULL DEFAULT '1',
  `termpicture_path` varchar(255) NOT NULL,
  `termpicture` varchar(255) NOT NULL,
  `termgallery_path` varchar(255) NOT NULL,
  `termgallery` varchar(255) NOT NULL,
  `term_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_terms`
--

INSERT INTO `yariko_terms` (`term_id`, `term_title`, `term_slug`, `term_fullslug`, `term_parent`, `term_keywords`, `term_description`, `term_text`, `term_datecreate`, `term_dateupdate`, `term_params`, `term_visible`, `termpicture_path`, `termpicture`, `termgallery_path`, `termgallery`, `term_mediafields`) VALUES
(1, 'SPA', 'spa', 'spa', 0, '', '', '', '2016-06-02 21:27:27', '2016-06-02 21:27:27', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(2, 'Массаж', 'massazh', 'massazh', 0, '', '', '', '2016-06-02 21:28:32', '2016-06-02 21:28:32', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(3, 'Гидротерапия', 'gidroterapiya', 'gidroterapiya', 0, '', '', '', '2016-06-02 21:28:55', '2016-06-02 21:28:55', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(4, 'VIP', 'vip', 'vip', 0, '', '', '', '2016-06-02 21:29:02', '2016-06-02 21:29:02', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(5, 'Косметология', 'kosmetologiya', 'kosmetologiya', 0, '', '', '', '2016-06-02 21:29:14', '2016-06-02 21:29:14', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(6, 'hydroclean', 'hydroclean', 'hydroclean', 0, '', '', '', '2016-06-02 21:29:27', '2016-06-02 21:29:27', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(7, 'педикюр', 'pedikyur', 'pedikyur', 0, '', '', '', '2016-06-02 21:29:31', '2016-06-02 21:29:31', 'a:0:{}', 1, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_users`
--

CREATE TABLE IF NOT EXISTS `yariko_users` (
  `user_id` int(11) unsigned NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_surname` varchar(100) NOT NULL,
  `user_middlename` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_address` text NOT NULL,
  `user_about` text NOT NULL,
  `user_status` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `user_date` datetime NOT NULL,
  `user_network` varchar(255) NOT NULL,
  `user_identity` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_users`
--

INSERT INTO `yariko_users` (`user_id`, `user_login`, `user_password`, `user_name`, `user_surname`, `user_middlename`, `user_email`, `user_phone`, `user_address`, `user_about`, `user_status`, `user_date`, `user_network`, `user_identity`) VALUES
(1, 'root', '776b153e48474f60d843395d6b946eb2', 'Адмирал', 'Генерал', 'Алладин', 'ex3xeng@yandex.ru', '+7 (989) 880-07-02', 'РД, г.Махачкала ул.Дахадаева 48', 'it&#039;s work!', '3', '2016-06-14 07:30:05', '', ''),
(4, 'admin', 'bdfadba395c5ce90607f06699051c84d', 'Шамиль', 'Алисултанов', 'Нурмагомедович', 'project.local@domain.com', '', 'Россия', 'Секретно', '3', '2016-07-27 18:08:54', '', ''),
(18, 'admin_yarahmed', 'd3ae169ba8a775686932619ec128abc8', 'Ярахмед', '', '', 'yariko@mail.ru', '+7 930 895-51-11', 'Москва', 'Хозяин всея Магазина и бизнеса', '4', '2016-07-26 15:46:44', '', ''),
(19, 'prototype1992', '31096550860f406da4179f45115d540c', 'Шамиль', 'Алисултанов', 'Нурмагомедович', 'shoma.alisultanov@yandex.ru', '89288732467', 'Москва', ':-)', '3', '2016-07-27 18:09:46', '', ''),
(21, 'yariko_manager1', 'b0bc59184a9f4fcec3a34e35505c3d21', 'Менеджер 1', 'Менеджер 1', 'Менеджер 1', 'aaa@mail.ru', '89889999999', 'Менеджер 1', 'Менеджер 1', '4', '2016-08-03 17:00:35', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `yariko_callback`
--
ALTER TABLE `yariko_callback`
  ADD PRIMARY KEY (`call_id`);

--
-- Индексы таблицы `yariko_cats`
--
ALTER TABLE `yariko_cats`
  ADD PRIMARY KEY (`cat_id`);

--
-- Индексы таблицы `yariko_delivery`
--
ALTER TABLE `yariko_delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Индексы таблицы `yariko_menus`
--
ALTER TABLE `yariko_menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Индексы таблицы `yariko_menus_objects`
--
ALTER TABLE `yariko_menus_objects`
  ADD PRIMARY KEY (`object_id`);

--
-- Индексы таблицы `yariko_orders`
--
ALTER TABLE `yariko_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `yariko_pages`
--
ALTER TABLE `yariko_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Индексы таблицы `yariko_posts`
--
ALTER TABLE `yariko_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `yariko_posts_relationships`
--
ALTER TABLE `yariko_posts_relationships`
  ADD UNIQUE KEY `post_id` (`post_id`,`term_id`);

--
-- Индексы таблицы `yariko_products`
--
ALTER TABLE `yariko_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `yariko_products_relationships`
--
ALTER TABLE `yariko_products_relationships`
  ADD UNIQUE KEY `product_id` (`product_id`,`cat_id`);

--
-- Индексы таблицы `yariko_sliders`
--
ALTER TABLE `yariko_sliders`
  ADD PRIMARY KEY (`slider_id`);

--
-- Индексы таблицы `yariko_terms`
--
ALTER TABLE `yariko_terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Индексы таблицы `yariko_users`
--
ALTER TABLE `yariko_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `yariko_callback`
--
ALTER TABLE `yariko_callback`
  MODIFY `call_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT для таблицы `yariko_cats`
--
ALTER TABLE `yariko_cats`
  MODIFY `cat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `yariko_delivery`
--
ALTER TABLE `yariko_delivery`
  MODIFY `delivery_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `yariko_menus`
--
ALTER TABLE `yariko_menus`
  MODIFY `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `yariko_menus_objects`
--
ALTER TABLE `yariko_menus_objects`
  MODIFY `object_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT для таблицы `yariko_orders`
--
ALTER TABLE `yariko_orders`
  MODIFY `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT для таблицы `yariko_pages`
--
ALTER TABLE `yariko_pages`
  MODIFY `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `yariko_posts`
--
ALTER TABLE `yariko_posts`
  MODIFY `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `yariko_products`
--
ALTER TABLE `yariko_products`
  MODIFY `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `yariko_sliders`
--
ALTER TABLE `yariko_sliders`
  MODIFY `slider_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `yariko_terms`
--
ALTER TABLE `yariko_terms`
  MODIFY `term_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `yariko_users`
--
ALTER TABLE `yariko_users`
  MODIFY `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;--
-- База данных: `7alisultanov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `portfolio`
--

CREATE TABLE IF NOT EXISTS `portfolio` (
  `portfolio_id` int(10) unsigned NOT NULL,
  `portfolio_img` varchar(200) NOT NULL,
  `portfolio_title` varchar(200) NOT NULL,
  `portfolio_link` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `portfolio`
--

INSERT INTO `portfolio` (`portfolio_id`, `portfolio_img`, `portfolio_title`, `portfolio_link`) VALUES
(1, '1teamkhabib.jpg', 'Сайт для Хабиба Нурмагомедова (боец UFC)', 'http://teamkhabib.ru/'),
(2, '2yariko.jpg', 'Интернет магазин Yariko', 'http://beats-pro.ru/'),
(3, '3sprosimedica.jpg', 'Sprosimedica - медицинский проект помощи людям', 'http://sprosimedica.ru/'),
(4, '5krasota-zara.jpg', 'krasota-zara.ru - парикмахерская с Москвы', 'http://krasota-zara.ru/'),
(5, '45-89308955111.jpg', '89308955111.ru - оптовая продажа обуви', 'http://89308955111.ru/'),
(6, '6easystep.jpg', 'Верстка Интернет магазина мужской обуви "Easy Step"', 'http://easy-st.ru'),
(7, '7era-potolok.jpg', 'Адаптивная верстка сайта компании "ЭРА потолков"', 'http://era-potolok.ru/'),
(8, '8gamma-potolkov.jpg', 'Адаптивная верстка сайта компании "Гамма потолков"', 'http://gamma-potolkov.ru/'),
(9, '9karatjewellery.jpg', 'Адаптивная верстка сайта компании "KaratJewellery Italy"', 'http://karatjewellery.ru/'),
(10, '4cs-artshop.jpg', 'Верстка интернет магазина "Искуство кавказа"', 'http://new.cs-artshop.ru/'),
(11, '10bytehouse.jpg', 'Вестка сайта bytehouse', 'http://bytehouse.ru/'),
(12, '13golden-yasmin.jpg', 'Верстка сайта golden-yasmin', 'http://golden-yasmin.ru/'),
(13, '14platinumdom.jpg', 'Верстка сайта platinumdom', 'http://platinumdom.ru/'),
(14, '15ooo-ssm.jpg', 'Верстка сайта OOO-SSM', 'http://ooo-ssm.ru/'),
(15, '16potolki-sezar.jpg', 'Верстка сайта Потолки сезар', 'http://potolki-sezar.ru/'),
(16, '17strong05.jpg', 'Верстка сайта Strong05', 'http://strong05.ru/'),
(17, '18zashita-kuzova.jpg', 'Верстка сайта "Защита Кузова"', 'http://zashita-kuzova.ru/'),
(18, '20stavmebel.jpg', 'Верстка сайта "Став Мебель"', 'http://stavmebel.com/'),
(19, '21warta.jpg', 'Разработка сайта Warta.su', 'http://warta.su/'),
(20, '22yoowoman.jpg', 'Адаптивная верстка сайта YooWoman - женский портал', 'http://yoowoman.ru/'),
(21, '47promostroy.jpg', 'Верстка макета сайта Промострой Энерго', 'projects/24promostroy/index.html'),
(22, '24shop-mobile.jpg', 'Верстка макета интернет магазина телефонов', 'projects/23shopmobile/index.html'),
(23, '25armata-fin.jpg', 'Верстка макета Armata Financical Group', 'projects/22armata-fin-group/index.html'),
(24, '26prokurs.jpg', 'Верстка макета ProKurs', 'projects/21prokurs/index.html'),
(25, '27karatj-promo.jpg', 'Презентационный сайт KaratJewellery', 'projects/20karatjewelleryru/index.html'),
(26, '28extended.jpg', 'Верстка макета Extended', 'projects/19extended/index.html'),
(27, '29fashion-photo.jpg', 'Верстка макета Fashion Photographer', 'projects/18аashion-photografer/index.html'),
(28, '30cleanmag.jpg', 'Верстка макета CleanMag', 'projects/17cleanmag/index.html'),
(29, '31autohall.jpg', 'Верстка макета Autohall', 'projects/16avtohall/index.html'),
(30, '32elitmontazh.jpg', 'Верстка интернет магазина ЭлитМонтаж', 'projects/12elitmontazh/index.html'),
(31, '33eventide.jpg', 'Верстка Лендинга Eventide', 'projects/14eventide/index.html'),
(32, '34styletour.jpg', 'Верстка макета интернет магазина Styletour', 'projects/13styletour/index.html'),
(33, '48gllacy.jpg', 'Верстка макета Gllacy', 'projects/25glaccy/index.html'),
(34, '36sedona.jpg', 'Верстка макета Sedona', 'projects/9sedona/index.html'),
(35, '35technomart.jpg', 'Верстка макета Техномарт', 'projects/10technomart/index.html'),
(36, '37nerds.jpg', 'Верстка макета Nerds', 'projects/8nerds/index.html'),
(37, '38barbershop-borodinsky.jpg', 'Верстка макета Barbershop Borodinski', 'projects/7barbershop-borodinski/index.html'),
(38, '39creative-plus.jpg', 'Верстка макета Creative+', 'projects/6creative-plus/index.html'),
(39, '40appix.jpg', 'Верстка макета APPIX', 'projects/5appix/index.html'),
(40, '41vopros-vrachu.jpg', 'Верстка макета Вопрос Врачу', 'projects/4vopros-vrachu/index.html'),
(41, '42rubl-by.jpg', 'Верстка макета Rubl.by', 'projects/3rubl-by/index.html'),
(42, '43buket-by.jpg', 'Верстка макета Buket.by', 'projects/2buket/index.html'),
(43, '44viacon.jpg', 'Верстка макета Viacon', 'projects/1viacon/index.html'),
(44, '46vs-electro.jpg', 'Верстка интернет магазина Vs-electro', 'http://vs-electro.ru/');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`portfolio_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `portfolio_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;--
-- База данных: `9yoowoman`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `title_url` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `text` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `blog`
--

INSERT INTO `blog` (`id`, `title`, `title_url`, `description`, `text`, `image`, `date`, `meta_d`, `meta_k`, `views`) VALUES
(1, 'Название записи 1', 'nazvanie_zapisi_1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:06', 'Описание записи блога', 'ключ1, ключ2', 0),
(2, 'Название записи 2', 'nazvanie_zapisi_2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:22:59', 'Описание записи блога', 'ключ1, ключ2', 0),
(3, 'Название записи 3', 'nazvanie_zapisi_3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:02', 'Описание записи блога', 'ключ1, ключ2', 0),
(4, 'Название записи 4', 'nazvanie_zapisi_4', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:10', 'Описание записи блога', 'ключ1, ключ2', 0),
(5, 'Название записи 5', 'nazvanie_zapisi_5', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:12', 'Описание записи блога', 'ключ1, ключ2', 0),
(6, 'Название записи 6', 'nazvanie_zapisi_6', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:15', 'Описание записи блога', 'ключ1, ключ2', 0),
(7, 'Название записи 7', 'nazvanie_zapisi_7', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:18', 'Описание записи блога', 'ключ1, ключ2', 0),
(8, 'Название записи 8', 'nazvanie_zapisi_8', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:21', 'Описание записи блога', 'ключ1, ключ2', 0),
(9, 'Название записи 9', 'nazvanie_zapisi_9', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:24', 'Описание записи блога', 'ключ1, ключ2', 0),
(10, 'Название записи 10', 'nazvanie_zapisi_10', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<img src="static/media/5.png" alt="" class="img-left">\n                        <p>\n                            Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <blockquote>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </blockquote>\n                        <img src="static/media/5.png" alt="" class="img-right">\n                        <p>\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\n                        </p>\n                        <ul>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Animi cumque, incidunt?</li>\n                            <li>Quia, sequi temporibus.</li>\n                            <li>A autem, dolore!</li>\n                            <li>Eligendi, itaque, sequi.</li>\n                        </ul>\n                        <ol>\n                            <li>Lorem ipsum dolor.</li>\n                            <li>Expedita, facere repudiandae?</li>\n                            <li>Deleniti earum, reiciendis!</li>\n                            <li>Ex, laboriosam laudantium!</li>\n                            <li>Aspernatur, nesciunt tempore.</li>\n                        </ol>', '5.jpg', '2016-09-01 08:23:26', 'Описание записи блога', 'ключ1, ключ2', 0),
(11, 'Название записи 11', 'nazvanie_zapisi_11', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, ', '<p>Lorem ipsum dolor sit amet, <a href="">consectetur</a> adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur <strong>adipisicing</strong> elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                        </p>\r\n                        <blockquote>\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                        </blockquote>\r\n                        <p>\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, voluptas?\r\n                        </p>\r\n                        <ul>\r\n                            <li>Lorem ipsum dolor.</li>\r\n                            <li>Animi cumque, incidunt?</li>\r\n                            <li>Quia, sequi temporibus.</li>\r\n                            <li>A autem, dolore!</li>\r\n                            <li>Eligendi, itaque, sequi.</li>\r\n                        </ul>\r\n                        <ol>\r\n                            <li>Lorem ipsum dolor.</li>\r\n                            <li>Expedita, facere repudiandae?</li>\r\n                            <li>Deleniti earum, reiciendis!</li>\r\n                            <li>Ex, laboriosam laudantium!</li>\r\n                            <li>Aspernatur, nesciunt tempore.</li>\r\n                        </ol>', '5.jpg', '2016-09-01 17:30:51', 'Описание записи блога', 'ключ1, ключ2', 0),
(12, 'Блаблабла', 'blablabla', '<p>saassasaassasaassasaassasaassasaassasaassasaassasaassasaassa saassasaassasaassa saassasaassa saassasaassa saassasaassa saassasaassa</p>', '<p>asssssssssssssssssssssssssssssssssss</p>\r\n<p>asssssssssssssssssssssssssssssssssss</p>\r\n<p>asssssssssssssssssssssssssssssssssss</p>\r\n<p>asssssssssssssssssssssssssssssssssss</p>', '5.jpg', '2016-09-01 19:55:40', 'asas', 'asas', 0),
(13, 'Марина пошла какать в туалет', 'marina_poshla_kakat_v_tualet', '<p>Короткая запись</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aperiam beatae, iure molestias quo quod. Dignissimos exercitationem expedita explicabo, hic ipsa iusto necessitatibus quia repellendus rerum tempore temporibus vel voluptatibus.</p>', '2.jpg', '2016-09-01 19:56:11', 'Описание страницы', 'Описание страницы', 0),
(14, 'Подслушано Дагестан | ПД', 'podslushano_dagestan__pd', '<p>Поставила вопрос о мужской психологии,а в комментариях гастрит обсуждают))Народ ,готовить и слушаться умеют почти все ,я хотела услышать другое ))жаль ,ничего нового не узнала?\nСпасибо ,До Свидания!</p>', '<p>Ас Саламу Алейкум<br />Хочу спросить совета у мужской половины. Безумно понравился один парень, до этого никто не был интересен и ни с кем не общалась, но тут по ходу любовь... Нашла его в вк и хочу начать общение, но не знаю как он отреагирует. В общем, ребят, как вы относитесь к тому, чтобы девушка первая написала и пыталась познакомиться поближе? Заранее спасибо за искренние ответы)</p>', '1.jpg', '2016-09-01 20:19:22', 'Описание страницы', 'Описание страницы', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `guestbook`
--

CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `guestbook`
--

INSERT INTO `guestbook` (`id`, `name`, `user_image`, `text`, `date`, `email`) VALUES
(1, 'Румина', '2.jpg', 'Доброго времени суток! Ребята, спасибо вам за все)))\r\n', '2016-08-30 09:16:27', 'aaa@mail.ru'),
(2, 'Марина Александрова', '3.jpg', 'Доброго времени суток! Ребята, спасибо вам за все)))\r\n', '2016-08-30 09:16:27', 'a11a1a2a@mail.ru'),
(3, 'Администратор', 'default.jpg', 'Спасибо)))', '2016-08-30 09:17:14', 'yoowoman@yandex.ru'),
(4, '111', 'default.jpg', 'guestbook__btn', '2016-08-30 10:28:07', 'aaaa@asaas.rr'),
(5, '111', 'default.jpg', 'height', '2016-08-30 10:38:58', 'aaaa@asaas.rr'),
(6, 'Гостевая', 'default.jpg', 'sasasaassasasa', '2016-08-30 10:39:57', 'aaaa@asaas.rr'),
(7, 'Гостевая', 'default.jpg', '$result_add_gb', '2016-08-30 10:53:53', 'aaaa@asaas.rr'),
(8, '$result_add_gb', 'default.jpg', '$result_add_gb', '2016-08-30 10:54:10', 'aaaa@asaas.rr'),
(9, 'Рита', 'default.jpg', 'Классненький сайтик', '2016-08-30 11:04:01', 'rita@mail.ru'),
(10, 'ыффыыф', 'default.jpg', 'ыфыфыффы', '2016-08-31 13:30:00', 'aaaa@asaas.rr');

-- --------------------------------------------------------

--
-- Структура таблицы `secrets`
--

CREATE TABLE IF NOT EXISTS `secrets` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_image` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `secrets`
--

INSERT INTO `secrets` (`id`, `name`, `user_image`, `text`, `date`, `email`) VALUES
(1, 'Шамиль Алисултанов', '1.jpg', 'Секрет 1', '2016-08-30 09:14:51', 'shoma.alisultanov@yandex.ru'),
(2, 'Аида Абакарова', '2.jpg', 'По каналу Карусель идёт мультфильм "Барби-русалка" , дочка увидела главную героиню и говорит : Мама , смотри какая она красивая , как Я !', '2016-08-30 09:14:30', 'ss@mail.ru'),
(3, 'Шамиль Алисултанов', '1.jpg', 'Секрет 3', '2016-08-30 09:14:55', 'shoma.alisultanov@yandex.ru'),
(4, 'Аида Абакарова', '2.jpg', 'Секрет 4. По каналу Карусель идёт мультфильм "Барби-русалка" , дочка увидела главную героиню и говорит : Мама , смотри какая она красивая , как Я !', '2016-08-30 09:14:33', 'ss@mail.ru'),
(5, 'Шамиль Алисултанов', '1.jpg', 'Секрет 5', '2016-08-30 09:14:57', 'shoma.alisultanov@yandex.ru'),
(6, 'Аида Абакарова', '2.jpg', 'Секрет 5. По каналу Карусель идёт мультфильм "Барби-русалка" , дочка увидела главную героиню и говорит : Мама , смотри какая она красивая , как Я ! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, animi architecto aspernatur aut dicta fuga incidunt ipsum molestias necessitatibus nostrum odio officiis perferendis qui reiciendis repellat repudiandae, voluptas voluptates! Accusamus adipisci amet consectetur doloribus ducimus explicabo facere, impedit inventore itaque nam odit perferendis, quisquam sapiente sed temporibus velit, voluptatum? Aut commodi, cupiditate, dolore eius eligendi est explicabo facere fugiat harum hic labore modi nisi porro quidem rem sint, voluptatum. A debitis dolores esse et eveniet excepturi facere fugiat illo inventore ipsam iusto labore, laboriosam magni modi molestiae mollitia neque nulla odit optio perferendis porro provident quis ratione repudiandae sed sint, velit voluptas. Ad eaque mollitia natus officia perspiciatis porro possimus quam quos. Amet architecto aspernatur aut, autem cum dolor ducimus earum et, eum ex explicabo in laudantium maiores minus nulla odit officiis optio provident quibusdam reiciendis repudiandae rerum sit velit. ', '2016-08-30 10:18:19', 'ss@mail.ru'),
(7, 'Моеимя', 'default.jpg', 'Мой тестовый текст', '2016-08-30 09:44:08', 'mail@mail.ru'),
(8, 'тест1', 'default.jpg', 'Текст 1', '2016-08-30 10:03:47', 'sss@mama.ru'),
(9, 'тест1', 'default.jpg', 'Текст 1', '2016-08-30 10:04:00', 'sss@mama.ru'),
(10, 'тест2', 'default.jpg', 'Текст 2', '2016-08-30 10:05:19', 'sss@mama.ru'),
(12, 'Анонимно', 'default.jpg', 'Какой то секрет Эльдара', '2016-09-14 18:27:35', 'anonim@mail.ru');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `secrets`
--
ALTER TABLE `secrets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `secrets`
--
ALTER TABLE `secrets`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;--
-- База данных: `apple`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `parent`) VALUES
(685, 'Комплектующие к Apple', 0),
(691, 'Запчасти iPad', 685),
(692, 'Запчасти iPhone', 685),
(693, 'Запчасти iPod', 685),
(694, 'Запчасти Mac', 685),
(695, 'iPad', 691),
(696, 'iPad 2', 691),
(697, 'iPad NEW (iPad 3)', 691),
(698, 'iPad 4', 691),
(699, 'iPad mini', 691),
(700, 'iPhone', 692),
(701, 'iPhone 3G/3GS', 692),
(702, 'iPhone 4', 692),
(703, 'iPhone 4S', 692),
(704, 'iPhone 5', 692),
(705, 'Микросхемы Apple', 685),
(836, 'Защитные плёнки на Apple', 0),
(840, 'iPad', 836),
(841, 'iPhone', 836),
(842, 'iPod', 836),
(843, 'Mac', 836),
(853, 'Оборудование для ремонта Apple', 0),
(876, 'Аксессуары для Apple', 0),
(877, 'Аксессуары iPad', 876),
(878, 'Аксессуары iPhone', 876),
(879, 'Аксессуары iPod', 876),
(880, 'Аксессуары Mac', 876),
(881, 'iPad', 877),
(882, 'iPad 2', 877),
(883, 'iPad NEW 3 / iPad 4', 877),
(884, 'iPad mini', 877),
(885, 'iPhone 3G / 3GS', 878),
(886, 'iPhone 4 / 4S', 878),
(887, 'iPhone 5', 878),
(888, 'Аксессуары для Apple', 876),
(895, 'iPhone 5 Lamborghini', 878);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`page_id`, `title`, `alias`, `description`, `keywords`, `text`, `position`) VALUES
(1, 'Главная', 'index', 'Описание главной', 'ключевики главной', 'Текст главной страницы', 1),
(2, 'О компании', 'about', 'Описание о компании', 'ключевики о компании', 'Текст страницы о компании', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'empty_thumb.jpg',
  `price` float NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13612 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `parent`, `content`, `image`, `price`) VALUES
(7582, 'LCD iPod Touch ', 693, '', 'empty_thumb.jpg', 22),
(7583, 'Len+Touchscreen iPod Touch ', 693, '', 'empty_thumb.jpg', 12),
(8833, 'Аккумулятор iPod Touch 1G ', 693, '', 'empty_thumb.jpg', 7.3),
(8834, 'Аккумулятор iPod Touch 2G ', 693, '', 'empty_thumb.jpg', 7.7),
(8935, 'Len+Touchscreen iPod Touch 2G', 693, '', 'empty_thumb.jpg', 15),
(8989, 'LCD iPod Touch 2G', 693, '', 'empty_thumb.jpg', 12),
(9087, 'Buzzer iPod Nano 5G', 693, '', 'empty_thumb.jpg', 2.7),
(9352, 'LCD iPod Nano 4G', 693, '', 'empty_thumb.jpg', 14),
(9353, 'Len iPod Nano 4G', 693, '', 'empty_thumb.jpg', 5.3),
(9508, 'Аккумулятор iPod Nano 2G', 693, '', 'empty_thumb.jpg', 7),
(9509, 'Аккумулятор iPod Nano 3G', 693, '', 'empty_thumb.jpg', 8.5),
(9918, 'LCD iPod Touch 4G+Touchscreen (black)', 693, '', 'empty_thumb.jpg', 24),
(9967, 'LCD iPod Nano 5G', 693, '', 'empty_thumb.jpg', 14),
(10390, 'LCD iPod Nano 6G', 693, '<p>\r\n	only lcd</p>\r\n', 'empty_thumb.jpg', 16),
(10486, 'Flat сable iPod nano 6G with on/off button and volume', 693, '', 'empty_thumb.jpg', 10.1),
(10733, 'Housing Cover iPod nano 3G (silver)', 693, '', 'empty_thumb.jpg', 8.5),
(11062, 'LCD iPod Touch 4G+Touchscreen (white)', 693, '', 'empty_thumb.jpg', 23),
(11629, 'Flat Cable on/off iPod touch 4G', 693, '', 'empty_thumb.jpg', 8.5),
(11630, 'Аккумулятор iPod Classic 616-0232(160gb)', 693, '', 'empty_thumb.jpg', 9),
(12100, 'LCD iPod Nano 2G', 693, '', 'empty_thumb.jpg', 14),
(12145, 'LCD iPod Nano 6G module', 693, '', 'empty_thumb.jpg', 50),
(12147, 'On/off outside home iPod Touch 4G (black)', 693, '', 'empty_thumb.jpg', 4),
(12148, 'On/off outside home iPod Touch 4G (white)', 693, '', 'empty_thumb.jpg', 4),
(12217, 'Аккумулятор iPod Nano 6G', 693, '', 'empty_thumb.jpg', 10.5),
(13219, 'Camera iPod Touch 4G', 693, '', 'empty_thumb.jpg', 12),
(12915, 'Housing iPod Touch 4G 32G/64G (silver)', 693, '', 'empty_thumb.jpg', 17.5),
(13003, 'Скотч для Touchscreen iPod Touch 4G', 693, '', 'empty_thumb.jpg', 1.1),
(13065, 'Аккумулятор iPod Classic 616-0229 (80gb/120gb)', 693, '', 'empty_thumb.jpg', 9),
(13094, 'Аккумулятор iPod Touch 4G', 693, '', 'empty_thumb.jpg', 13.4),
(13220, 'Hands-free connector iPod Touch 4G', 693, '', 'empty_thumb.jpg', 6.5),
(13295, 'LCD iPod Nano 7G', 693, '', 'empty_thumb.jpg', 20),
(10621, 'Glass Screen Cover for MacBook Pro 13.3"', 694, 'защитное стекло экрана', 'empty_thumb.jpg', 59),
(10622, 'Glass Screen Cover for MacBook Pro 15.4"', 694, 'защитное стекло экрана ', 'empty_thumb.jpg', 69),
(10623, 'Glass Screen Cover for MacBook Pro 17.1"', 694, 'защитное стекло экрана', 'empty_thumb.jpg', 77),
(9639, 'Клипсы для дисплея iPad ', 695, '', 'empty_thumb.jpg', 0.3),
(9780, 'Housing iPad 3G (silver)', 695, 'Корпус на iPad 3G серебристый', 'empty_thumb.jpg', 55),
(10162, 'Аккумулятор iPad ', 695, '', 'empty_thumb.jpg', 30),
(10373, 'Housing iPad  Wi-Fi', 695, 'Корпус для iPad 3 Wi-Fi', 'empty_thumb.jpg', 75),
(10462, 'Flat Cable iPad + HF connector', 695, 'Шлейф с разъёмом наушников на iPad', 'empty_thumb.jpg', 8.8),
(10131, 'Flat Cable iPad 2 with charger connector', 696, 'Шлейф на iPad 2 с системным разьемом.', 'empty_thumb.jpg', 8.5),
(10132, 'Flat Cable iPad 2 with switch on/off & switch vibro', 696, 'Шлейф с кнопками громкости и кнопкой включения', 'empty_thumb.jpg', 13.5),
(10133, 'Двухсторонний скотч для iPad 2 (комплект)', 696, '', 'empty_thumb.jpg', 3),
(10134, 'Flat Cable iPad 2 3G with sim & HF connector (black)', 696, 'Шлейф в комплекте с SIM-держателем и разьемом гарнитуры черного цвета ', 'empty_thumb.jpg', 9.99),
(10135, 'Flat Cable iPad 2 3G with sim & HF connector (white)', 696, 'Шлейф в комплекте с SIM-держателем и разьемом гарнитуры белого цвета ', 'empty_thumb.jpg', 9.99),
(10136, 'Flat Cable iPad 2 Wi-Fi with HF connector', 696, '', 'empty_thumb.jpg', 10),
(10161, 'LCD iPad 2  only lcd', 696, 'AB0970003013', 'empty_thumb.jpg', 70),
(10163, 'Touchscreen + Len iPad 2 (black)', 696, 'сенсорное стекло с чёрной рамкой', 'empty_thumb.jpg', 36),
(10164, 'Touchscreen + Len iPad 2 (white)', 696, 'сенсорное стекло с белой рамкой', 'empty_thumb.jpg', 36),
(10375, 'Camera iPad 2 big (front)', 696, 'камера передняя', 'empty_thumb.jpg', 4.8),
(10461, 'Mic iPad 2 (микрофон)', 696, 'микрофон на шлейфе с разъёмом для iPad 2', 'empty_thumb.jpg', 4.8),
(10463, 'Camera iPad 2 small (back)', 696, 'камера задняя', 'empty_thumb.jpg', 4.8),
(10563, 'On/off inside Home iPad 2', 696, 'центральная кнопка  (внутреняя) на плате для iPad 2.', 'empty_thumb.jpg', 3.99),
(10564, 'Button Home iPad 2 (black)', 696, 'Наружная кнопка главного меню на iPad 2 WiFi/iPad 2 WiFi+3G, чёрного цвета.', 'empty_thumb.jpg', 1.99),
(10565, 'Antenna iPad 2 bluetooth', 696, 'антенна блютуз', 'empty_thumb.jpg', 6.8),
(10566, 'Antenna iPad 2 Wi-Fi', 696, 'антенна Wi-Fi', 'empty_thumb.jpg', 6.2),
(10734, 'Touch socket iPad 2 (black) ', 696, 'Рамка под дисплей на iPad 2 чёрного цвета', 'empty_thumb.jpg', 3.9),
(10735, 'Touch socket iPad 2 (white) ', 696, 'Рамка под дисплей на iPad 2 белого цвета', 'empty_thumb.jpg', 3.9),
(10786, 'Sim card holder outside iPad 2', 696, '', 'empty_thumb.jpg', 3.5),
(10880, 'Аккумулятор iPad 2', 696, '', 'empty_thumb.jpg', 29),
(11061, 'Button Home iPad 2 (white)', 696, 'Наружная кнопка главного меню на iPad 2 WiFi/iPad 2 WiFi+3G, белого цвета.', 'empty_thumb.jpg', 1.99),
(12972, 'Touchscreen + Len iPad 2 (black) copy', 696, 'сенсорное стекло с чёрной рамкой', 'empty_thumb.jpg', 29),
(13211, 'Flat Cable iPad 2 on LCD', 696, 'дисплейный шлейф', 'empty_thumb.jpg', 5.99),
(13402, 'Housing iPad 2', 696, '', 'empty_thumb.jpg', 85),
(12149, 'LCD iPad NEW 3/4 only lcd', 697, '<p>\r\n	дисплей для iPad NEW 3 без сенсора</p>\r\n', 'empty_thumb.jpg', 72),
(12154, 'Touchscreen + Len iPad NEW 3/4 (black)', 697, 'Сенсорное стекло черного цвета для iPad 3', 'empty_thumb.jpg', 58),
(12263, 'Touchscreen + Len iPad NEW 3/4 (white)', 697, '<p>\r\n	Сенсорное стекло белого цвета для iPad 3</p>\r\n', 'empty_thumb.jpg', 58),
(12836, 'Camera iPad New 3 back', 697, 'камера задняя', 'empty_thumb.jpg', 25.5),
(12922, 'Housing iPad NEW 3 Wi-Fi 3G', 697, '<p>\r\n	Задняя крышка корпуса для iPad 3 WiFi серебристого цвета</p>\r\n', 'empty_thumb.jpg', 105),
(13118, 'Flat Cable NEW iPad 3 with switch volume on/off &amp; switch vibro', 697, '<p>\r\n	Шлейф для iPad New 3 с кнопками регулировки громкости и включения</p>\r\n', 'empty_thumb.jpg', 6),
(13209, 'Flat Cable iPad 3 with HF connector', 697, '', 'empty_thumb.jpg', 39.9),
(13251, 'Touchscreen + Len iPad NEW 3/4 (black) copy', 697, '', 'empty_thumb.jpg', 45),
(13252, 'Touchscreen + Len iPad NEW 3/4 (white) copy ', 697, '', 'empty_thumb.jpg', 45),
(13408, 'Flat Cable iPad NEW 3 with charger connector', 697, '<p>\r\n	Шлейф с системным коннектором для iPad NEW (iPad 3)</p>\r\n', 'empty_thumb.jpg', 7.4),
(13409, 'Buzzer iPad NEW 3 (2pcs) with frame', 697, '<p>\r\n	Динамик полифонический для iPad New 3 (2 шт) в рамке</p>\r\n', 'empty_thumb.jpg', 15.9),
(13417, 'Antenna iPad NEW 3 bluetooth', 697, '<p>\r\n	Антенна з блютузом для iPad 3</p>\r\n', 'empty_thumb.jpg', 4.8),
(13418, 'Antenna iPad NEW 3 GPS', 697, '<p>\r\n	Антенна для iPad 3 GPS</p>\r\n', 'empty_thumb.jpg', 4.8),
(13420, 'Antenna 3G iPad NEW 3 (2pcs)', 697, '<p>\r\n	Антенна 3G для iPad New 3 (правая и левая)</p>\r\n', 'empty_thumb.jpg', 6.8),
(13422, 'Flat Cable iPad NEW 3 with microphone', 697, '<p>\r\n	Шлейф для iPad New 3 c микрофоном</p>\r\n', 'empty_thumb.jpg', 3.8),
(13547, 'Camera iPad New 3 front', 697, '', 'empty_thumb.jpg', 12),
(12913, 'Touchscreen iPad mini (black)', 699, 'Сенсорное стекло на iPad mini чёрного цвета', 'empty_thumb.jpg', 99),
(12914, 'Touchscreen iPad mini (white)', 699, 'Сенсорное стекло на iPad mini белого цвета', 'empty_thumb.jpg', 99),
(12970, 'LCD iPad mini', 699, 'Дисплей на iPad mini', 'empty_thumb.jpg', 68),
(13410, 'Flat Cable iPad mini with connector system (white)', 699, '<p>\r\n	Шлейф с системным разьёмом белого цвета для iPad MINI.</p>\r\n', 'empty_thumb.jpg', 12.8),
(13412, 'Button Home iPad mini (black)', 699, '<p>\r\n	Кнопка главного меню чёрного цвета для iPad MINI.</p>\r\n', 'empty_thumb.jpg', 2.8),
(13411, 'Flat Cable iPad mini with connector system (black)', 699, '<p>\r\n	Шлейф с системным разьёмом чёрного цвета для iPad MINI</p>\r\n', 'empty_thumb.jpg', 12.8),
(13413, 'Button Home iPad mini (white)', 699, '<p>\r\n	Кнопка главного меню белого цвета для iPad MINI.</p>\r\n', 'empty_thumb.jpg', 2.8),
(13414, 'Flat Cable iPad mini with hands-free connector (black)', 699, '<p>\r\n	Шлейф с разьемом гарнитуры черного цвета для iPad MINI</p>\r\n', 'empty_thumb.jpg', 7.4),
(13415, 'Flat Cable iPad mini with hands-free connector (white)', 699, '<p>\r\n	Шлейф с разьемом гарнитуры белого цвета для iPad MINI</p>\r\n', 'empty_thumb.jpg', 7.4),
(13416, 'Flat Cable iPad mini microphone', 699, '<p>\r\n	Шлейф с микрофоном для iPad MINI</p>\r\n', 'empty_thumb.jpg', 4.8),
(7225, 'Housing iPhone 2G', 700, 'USED!!!black .silver ', 'empty_thumb.jpg', 24),
(7424, 'Sim card holder iPhone 2G', 700, 'silver', 'empty_thumb.jpg', 5),
(7425, 'Flat cable iPhone 2G for light sensor and speaker ', 700, 'with components', 'empty_thumb.jpg', 2.8),
(7426, 'Charger flat cable iPhone 2G', 700, 'Шлейф с разъемом заряда на iPhone 2G', 'empty_thumb.jpg', 6.5),
(7427, 'Housing cover iPhone 2G (крышка акб) ', 700, 'black, green, blue, red, pink, 8G, 16G', 'empty_thumb.jpg', 21),
(7428, 'Flat cable iPhone 2G with vibro ', 700, ' handsfree connector and on/off button', 'empty_thumb.jpg', 9.2),
(7597, 'Len iPhone 2G', 700, '', 'empty_thumb.jpg', 7),
(7806, 'Buzzer iPhone 2G ', 700, 'Полифонический динамик на iPhone 2G', 'empty_thumb.jpg', 2.2),
(8144, 'Аккумулятор iPhone 2G', 700, '', 'empty_thumb.jpg', 8.3),
(8197, 'Выталкиватель сим карты iPhone', 700, '', 'empty_thumb.jpg', 0.6),
(8215, 'Винтики iPhone 2G', 700, '', 'empty_thumb.jpg', 0.1),
(8238, 'Charger connector iPhone 2G', 700, 'Разъём заряда (системный разъём) на iPhone 2G', 'empty_thumb.jpg', 0.9),
(8311, 'Sim card holder inside iPhone 2G', 700, '', 'empty_thumb.jpg', 3.9),
(8509, 'Camera iPhone 2G', 700, 'Камера на iPhone 2G', 'empty_thumb.jpg', 5.5),
(9182, 'Металлическая основа под LCD iPhone 2G', 700, '', 'empty_thumb.jpg', 9),
(9183, 'Скотч под LCD iPhone 2G', 700, '', 'empty_thumb.jpg', 0.9),
(9356, 'Antenna block iPhone ', 700, 'Антенна на iPhone', 'empty_thumb.jpg', 5),
(9609, 'Mic iPhone 2G', 700, '', 'empty_thumb.jpg', 1.5),
(7581, 'Len iPhone 3G ', 701, 'стекло', 'empty_thumb.jpg', 9),
(7649, 'Housing cover iPhone 3G high copy (black)', 701, 'задняя крышка', 'empty_thumb.jpg', 36),
(7725, 'Sim card holder outside (tray) iPhone 3G/3GS (black)', 701, '', 'empty_thumb.jpg', 2.5),
(7867, 'Charger flat cable iPhone 3G ', 701, 'Шлейф с разъемом зарядки', 'empty_thumb.jpg', 4.5),
(7868, 'Antenna+buzzer iPhone 3G ', 701, 'with data connector', 'empty_thumb.jpg', 6.5),
(7925, 'Button Home  iPhone 3G/3GS white', 701, '<p>\r\n	центральная кнопка</p>\r\n', 'empty_thumb.jpg', 1.8),
(8145, 'Аккумулятор iPhone 3G', 701, '', 'empty_thumb.jpg', 7.6),
(8174, 'Touchscreen+Len iPhone 3G (black)', 701, '', 'empty_thumb.jpg', 11),
(8216, 'Screws iPhone 3G small', 701, 'винтики', 'empty_thumb.jpg', 0.1),
(8307, 'Charger flat cable iPhone 3GS', 701, 'Шлейф с разъемом зарядки', 'empty_thumb.jpg', 5.5),
(8308, 'Charger connector iPhone 3G/3GS', 701, 'разъём заряда', 'empty_thumb.jpg', 0.95),
(8310, 'Sim card holder inside iPhone 3G', 701, 'внутренний держатель сим карты', 'empty_thumb.jpg', 4.65),
(8338, 'Housing iPhone 3GS (black)', 701, 'задняя крышка', 'empty_thumb.jpg', 19.5),
(8390, 'Sim card contact iPhone 2G/3G/3GS', 701, 'контакты для сим карты', 'empty_thumb.jpg', 1.2),
(8391, 'On/off vibro mode iPhone 3G/3GS (black)', 701, '<p>\r\n	кнопка вкл/выкл беззвучного режима</p>\r\n', 'empty_thumb.jpg', 1),
(8392, 'Внутренний выталкиватель сим карты iPhone 3G/3GS', 701, '', 'empty_thumb.jpg', 1),
(8508, 'Sim card holder inside iPhone 3GS', 701, 'внутренний держатель сим карты', 'empty_thumb.jpg', 4.7),
(8640, 'Touchscreen+Len iPhone 3GS (black)', 701, '', 'empty_thumb.jpg', 11.8),
(8643, 'Flat cable on/off iPhone 3GS/3G + HF (black)', 701, '<p>\r\n	шлейф с разъёмам наушников</p>\r\n', 'empty_thumb.jpg', 5),
(8841, 'Button outside volume iPhone 3G/3GS', 701, 'кнопка регулировки громкости звука iPhone 3G/3GS', 'empty_thumb.jpg', 2),
(9027, 'Camera iPhone 3G', 701, 'камера', 'empty_thumb.jpg', 9),
(9077, 'Housing iPhone 3G (black)', 701, '', 'empty_thumb.jpg', 21),
(9081, 'Flat button inside Home iPhone 3G/3GS', 701, 'внутренняя центральная кнопка со шлейфом', 'empty_thumb.jpg', 2),
(9082, 'Frame mounting LCD iPhone 3G/3GS (black)', 701, 'Пластиковая рамка крепления дисплея и сенсорного стекла на iPhone 3G/3GS', 'empty_thumb.jpg', 8.5),
(9083, 'Металлическая основа под LCD iPhone 3G/3GS', 701, '', 'empty_thumb.jpg', 6),
(9085, 'Microphone iPhone 3G/3GS with flat cable', 701, 'Микрофон на iPhone 3G/3GS в комплекте со шлейфом и резиновым колпачком', 'empty_thumb.jpg', 2),
(9177, 'Аккумулятор iPhone 3GS ', 701, '', 'empty_thumb.jpg', 7.8),
(9180, 'Button on/off outside iPhone 3G/3GS', 701, 'накладка на кнопку включения и выключения iPhone 3G/3GS', 'empty_thumb.jpg', 1.35),
(9346, 'Flat cable iPhone 3G/3GS for light sensor ', 701, '', 'empty_thumb.jpg', 5.2),
(9355, 'Buzzer iPhone 3G/3GS', 701, 'with antenna cover', 'empty_thumb.jpg', 3.5),
(9517, 'Housing iPhone 3G Full (black)', 701, '<p>\r\n	Housing+vibro+charge flat cable+flat cable on/off</p>\r\n', 'empty_thumb.jpg', 42),
(9583, 'Housing iPhone 3GS Full (black)', 701, '<p>\r\n	Housing+vibro+charge flat cable+flat cable on/off</p>\r\n', 'empty_thumb.jpg', 45),
(9771, 'Screws iPhone 3G big', 701, 'винтики', 'empty_thumb.jpg', 0.1),
(10008, 'Vibro iPhone 3G/3GS', 701, 'вибромотор', 'empty_thumb.jpg', 2.6),
(10474, 'Sticker for fixing the Touchscreen iPhone 3G/3GS', 701, 'Двухсторонняя клеящая лента для  iPhone 3G/3GS.', 'empty_thumb.jpg', 1.5),
(10499, 'Antenna Cable iPhone 3G', 701, '', 'empty_thumb.jpg', 3.5),
(10500, 'Antenna Cable iPhone 3GS ', 701, '', 'empty_thumb.jpg', 4.8),
(10560, 'Camera iPhone 3GS', 701, 'камера', 'empty_thumb.jpg', 6.6),
(10561, 'Antenna+buzzer iPhone 3GS', 701, 'with data connector', 'empty_thumb.jpg', 7.6),
(11059, 'Sim card holder outside (tray) iPhone 3G/3GS (white)', 701, '', 'empty_thumb.jpg', 2.5),
(11245, 'Flat cable on/off iPhone 3GS/3G + HF (white)', 701, '<p>\r\n	шлейф с разъёмам наушников</p>\r\n', 'empty_thumb.jpg', 5),
(11258, 'Housing iPhone 3G Full (white)', 701, '<p>\r\n	Housing+vibro+charge flat cable+flat cable on/off</p>\r\n', 'empty_thumb.jpg', 42),
(11259, 'Housing iPhone 3GS Full (white)', 701, '<p>\r\n	Housing+vibro+charge flat cable+flat cable on/off</p>\r\n', 'empty_thumb.jpg', 45),
(11261, 'Housing iPhone 3G (white)', 701, '', 'empty_thumb.jpg', 21),
(11262, 'Housing iPhone 3GS (white)', 701, '<p>\r\n	задняя крышка</p>\r\n', 'empty_thumb.jpg', 19.5),
(11540, 'Touchscreen+Len iPhone 3G (white)', 701, '', 'empty_thumb.jpg', 11),
(11970, 'On/off vibro mode iPhone 3G/3GS (white)', 701, 'кнопка вкл/выкл беззвучного режима', 'empty_thumb.jpg', 1),
(12032, 'Touchscreen+Len iPhone 3GS (white)', 701, '', 'empty_thumb.jpg', 12),
(12140, 'Wi-Fi Antenna Cable iPhone 3G/3GS', 701, '', 'empty_thumb.jpg', 3.2),
(12180, 'LCD iPhone 3G ', 701, 'дисплей', 'empty_thumb.jpg', 24),
(12181, 'LCD iPhone 3GS', 701, '<p>\r\n	дисплей</p>\r\n', 'empty_thumb.jpg', 19),
(13105, 'Button Home  iPhone 3G/3GS black', 701, '<p>\r\n	центральная кнопка</p>\r\n', 'empty_thumb.jpg', 1.8),
(9384, 'Speaker iPhone 4', 702, 'динамик', 'empty_thumb.jpg', 2.2),
(9469, 'LCD+Touchscreen iPhone 4 (black)', 702, '', 'empty_thumb.jpg', 33),
(9470, 'LCD+Touchscreen iPhone 4 (white)', 702, '', 'empty_thumb.jpg', 35),
(9471, 'Middle part iPhone 4', 702, 'Средняя часть корпуса', 'empty_thumb.jpg', 19),
(9472, 'Back cover iPhone 4 (white)', 702, 'Задняя крышка корпуса белого цвета на iPhone 4', 'empty_thumb.jpg', 11.8),
(9474, 'Sim-card holder outside iPhone 4', 702, '', 'empty_thumb.jpg', 3.9),
(9510, 'Microphone iPhone 4', 702, '', 'empty_thumb.jpg', 1.4),
(9511, 'Buzzer Ringer for iPhone 4/4S', 702, 'полифонический динамик', 'empty_thumb.jpg', 3.2),
(9514, 'Аккумулятор iPhone 4G', 702, '', 'empty_thumb.jpg', 13.2),
(9515, 'Home button outside iPhone 4 high copy (black)', 702, 'центральная кнопка', 'empty_thumb.jpg', 3.95),
(9519, 'Charger flat cable iPhone 4 black connector', 702, 'Шлейф с разъёмом зарядки (чёрный) c компонентами и микрофоном на iPhone 4', 'empty_thumb.jpg', 9.5),
(9562, 'Touchscreen+Len iPhone 4 (white)', 702, '', 'empty_thumb.jpg', 18),
(9563, 'Touchscreen+Len iPhone 4 (black)', 702, '', 'empty_thumb.jpg', 18),
(9564, 'LCD iPhone 4 only lcd', 702, '', 'empty_thumb.jpg', 33),
(9630, 'Flat Cable iPhone 4 for light proximity sensor & power key', 702, 'Шлейф с датчиком приближения уха к динамику и мембраной кнопки вкл/выкл на iPhone 4', 'empty_thumb.jpg', 9),
(9637, 'Home button outside  iPhone 4 (black)', 702, 'центральная кнопка ', 'empty_thumb.jpg', 2.2),
(9638, 'Home button outside iPhone 4 (white) ', 702, 'центральная кнопка ', 'empty_thumb.jpg', 2.2),
(9774, 'Flat Cable iPhone 4 with hands-free connector (black) + volume switch', 702, 'Шлейф с разъёмом гарнитуры (чёрный) и мембранами кнопок управления звуком на iPhone 4', 'empty_thumb.jpg', 7),
(9781, 'LCD+Touchscreen iPhone 4 high copy (black) ', 702, '', 'empty_thumb.jpg', 64),
(10009, 'Camera back iPhone 4 ', 702, 'задняя', 'empty_thumb.jpg', 11),
(10094, 'Turbo-SIM for iPhone 4', 702, '', 'empty_thumb.jpg', 6.5),
(10112, 'Vibro module iPhone 4', 702, 'вибро звонок', 'empty_thumb.jpg', 2.6),
(10113, 'LCD+Touchscreen iPhone 4 high copy (white) ', 702, '', 'empty_thumb.jpg', 64),
(10114, 'Back cover iPhone 4 high copy (white) ', 702, 'Задняя крышка корпуса белого цвета на iPhone 4', 'empty_thumb.jpg', 27),
(10130, 'Набор винтов для iPhone 4', 702, '<p>\r\n	комплект</p>\r\n', 'empty_thumb.jpg', 4.7),
(10285, 'Back cover iPhone 4 high copy (black) ', 702, 'Задняя крышка корпуса чёрного цвета на iPhone 4', 'empty_thumb.jpg', 27),
(10326, 'Flat Cable on/off inside Home iPhone 4', 702, '', 'empty_thumb.jpg', 3.4),
(10331, 'Back cover iPhone 4 (black) ', 702, 'Задняя крышка корпуса чёрного цвета на iPhone 4', 'empty_thumb.jpg', 11.8),
(10488, 'Charger flat cable iPhone 4 white connector', 702, 'Шлейф с разъёмом зарядки (белый) c компонентами и микрофоном на iPhone 4', 'empty_thumb.jpg', 10),
(10493, 'Waterproof sticker iPhone 4', 702, 'индикатор влаги ', 'empty_thumb.jpg', 0.3),
(10495, 'Connector on board for Back camera iPhone 4', 702, '', 'empty_thumb.jpg', 6.5),
(10497, 'Connector on board for Sensor flat iPhone 4', 702, '', 'empty_thumb.jpg', 6),
(10498, 'Connector on board for Audio iPhone 4', 702, '', 'empty_thumb.jpg', 5.9),
(10558, 'LCD+Touchscreen iPhone 4+Housing cover (Purple)', 702, '', 'empty_thumb.jpg', 45),
(10559, 'LCD+Touchscreen iPhone 4+Housing cover (Gold)', 702, '', 'empty_thumb.jpg', 45),
(10562, 'Camera front iPhone 4 ', 702, 'передняя', 'empty_thumb.jpg', 7.9),
(10567, 'Antenna iPhone 4 with WiFi ', 702, 'антенна', 'empty_thumb.jpg', 4.2),
(10642, 'Sim-card holder inside iPhone 4', 702, 'держатель сим карты на iPhone 4', 'empty_thumb.jpg', 3.4),
(10643, 'Button set iPhone 4 (volume+power+mute)', 702, 'Набор кнопок (3шт.) . В комплект входит: кнопка вкл/выкл телефона, кнопка регулировки громкости, кнопка беззвучного режима и держатель SIM карты.', 'empty_thumb.jpg', 4.9),
(10644, 'Battery connector iPhone 4', 702, 'разъём аккумулятора', 'empty_thumb.jpg', 2.9),
(10645, 'Внутренний выталкиватель iPhone 4', 702, '', 'empty_thumb.jpg', 2.2),
(10646, 'Connector on board for Front camera iPhone 4', 702, '', 'empty_thumb.jpg', 6.5),
(10647, 'Connector on board for Touchscreen iPhone 4', 702, '', 'empty_thumb.jpg', 5.2),
(10648, 'Защитная сетка для Speaker iPhone 4', 702, '', 'empty_thumb.jpg', 1.1),
(11060, 'Flat Cable iPhone 4 with hands-free connector (white) + volume switch', 702, 'Шлейф с разъёмом гарнитуры (белый) и мембранами кнопок управления звуком на iPhone 4', 'empty_thumb.jpg', 7),
(11524, 'Защитная сетка для Buzzer iPhone 4', 702, '', 'empty_thumb.jpg', 1),
(11529, 'Скотч для Touchscreen iPhone 4', 702, '', 'empty_thumb.jpg', 1.2),
(11627, 'Frame Housing cover iPhone 4 Black', 702, '<p>\r\n	Рамка задней крышки корпуса на iPhone 4 чёрного цвета</p>\r\n', 'empty_thumb.jpg', 10),
(11628, 'Frame Housing cover iPhone 4 White', 702, '<p>\r\n	Рамка задней крышки корпуса на iPhone 4 белого цвета</p>\r\n', 'empty_thumb.jpg', 10),
(10487, 'Аккумулятор iPhone 4S', 703, '', 'empty_thumb.jpg', 18.7),
(10489, 'Flat Cable iPhone 4S(black) with hands-free connector', 703, 'шлейф с разьёмом для наушников ', 'empty_thumb.jpg', 14),
(10490, 'Flat Cable iPhone 4S(white) with hands-free connector', 703, 'шлейф с разьёмом для наушников ', 'empty_thumb.jpg', 14),
(10491, 'Charger flat cable iPhone 4S (black) connector', 703, 'Шлейф с разъемом зарядки чёрный', 'empty_thumb.jpg', 14),
(10492, 'Charger flat cable iPhone 4S (white) connector', 703, 'Шлейф с разъемом зарядки белый', 'empty_thumb.jpg', 14),
(10494, 'LCD connector iPhone 4S', 703, '', 'empty_thumb.jpg', 5.5),
(10568, 'Flat Cable on/off inside Home iPhone 4S ', 703, '', 'empty_thumb.jpg', 5.5),
(10569, 'LCD iPhone 4S + Touchscreen (black)', 703, '', 'empty_thumb.jpg', 42),
(10570, 'LCD iPhone 4S + Touchscreen (white)', 703, '', 'empty_thumb.jpg', 43),
(10571, 'LCD iPhone 4S + Touchscreen (black) high copy', 703, '', 'empty_thumb.jpg', 67),
(10572, 'LCD iPhone 4S + Touchscreen (white) high copy', 703, '', 'empty_thumb.jpg', 67),
(10573, 'Flat Cable iPhone 4S with proximity sensor', 703, 'шлейф с кнопкой вкл.', 'empty_thumb.jpg', 14),
(10575, 'Camera front  iPhone 4S', 703, 'передняя', 'empty_thumb.jpg', 13.5),
(10636, 'Back cover iPhone 4S (black) ', 703, '<p>\r\n	задняя крышка</p>\r\n', 'empty_thumb.jpg', 17.5),
(10637, 'Back cover iPhone 4S (white) ', 703, '<p>\r\n	задняя крышка</p>\r\n', 'empty_thumb.jpg', 17.5),
(11623, 'Back cover iPhone 4S high copy (black) ', 703, '<p>\r\n	задняя крышка</p>\r\n', 'empty_thumb.jpg', 29),
(11624, 'Middle part iPhone 4S (silver)', 703, '', 'empty_thumb.jpg', 49),
(11625, 'Frame Housing cover iPhone 4S (black)', 703, '', 'empty_thumb.jpg', 10.5),
(11626, 'Frame Housing cover iPhone 4S (white)', 703, '', 'empty_thumb.jpg', 10),
(11998, 'Turbo-SIM for iPhone 4S (5.0/ 5.1/ 5.01)', 703, '', 'empty_thumb.jpg', 20),
(12031, 'Camera back iPhone 4S 8MP', 703, '<p>\r\n	задняя</p>\r\n', 'empty_thumb.jpg', 26),
(12033, 'Back cover iPhone 4S high copy (white) ', 703, '<p>\r\n	задняя крышка</p>\r\n', 'empty_thumb.jpg', 29),
(12151, 'Home button outside for iPhone 4S (black)', 703, '', 'empty_thumb.jpg', 2.5),
(12152, 'Home button outside for iPhone 4S (white)', 703, '', 'empty_thumb.jpg', 2.5),
(12153, 'Vibro module iPhone 4S', 703, '', 'empty_thumb.jpg', 4.5),
(12869, 'Аккумулятор iPhone 4S original', 703, '', 'empty_thumb.jpg', 25),
(12666, 'Charger flat cable iPhone 5 (black) connector with HF ', 704, 'Шлейф на iPhone 5 с разъёмом зарядки и разъёмом наушников', 'empty_thumb.jpg', 7.8),
(12667, 'Charger flat cable iPhone 5 (white) connector with HF', 704, 'Шлейф на iPhone 5  с разъёмом зарядки и разъёмом наушников', 'empty_thumb.jpg', 8),
(12668, 'Buzzer Ringer for iPhone 5', 704, 'Полифонический динамик на iPhone 5', 'empty_thumb.jpg', 3.4),
(12669, 'Vibro module iPhone 5', 704, 'Вибро звонок для iPhone 5', 'empty_thumb.jpg', 2),
(12670, 'Flat Cable on/off inside iPhone 5', 704, 'Шлейф на iPhone 5 с кнопкой включения, кнопками регулировки громкости и беззвучного режима', 'empty_thumb.jpg', 4.6),
(12671, 'Sim-card holder outside iPhone 5 (black)', 704, 'Держатель нано сим карты для iPhone 5, чёрный', 'empty_thumb.jpg', 2),
(12672, 'Sim-card holder outside iPhone 5 (white)', 704, 'Держатель нано сим карты для iPhone 5, белый', 'empty_thumb.jpg', 2),
(12673, 'Flat Cable iPhone 5 for light and proximity sensor with front camera', 704, 'Шлейф на iPhone 5 с передней камерой и датчиками приближения и освещённости', 'empty_thumb.jpg', 14),
(12674, 'Speaker iPhone 5', 704, 'Динамик разговорный для iPhone 5', 'empty_thumb.jpg', 2.5),
(12675, 'Home button outside for iPhone 5 (black)', 704, 'Кнопка home внешняя для iPhone 5 чёрного цвета', 'empty_thumb.jpg', 2.5),
(12676, 'Home button outside for iPhone 5 (white)', 704, 'Кнопка home внешняя для iPhone 5 белого цвета', 'empty_thumb.jpg', 2.5),
(12677, 'Flat Cable Home inside iPhone 5', 704, 'Шлейф с мембраной кнопки возврата в главное меню на iPhone 5', 'empty_thumb.jpg', 3),
(12678, 'Battery connector iPhone 5', 704, 'Разъём аккумулятора на iPhone 5', 'empty_thumb.jpg', 2.2),
(12679, 'Flat Cable Wi-Fi iPhone 5', 704, 'Шлейф Wi-Fi iPhone 5', 'empty_thumb.jpg', 4.7),
(12680, 'Housing iPhone 5 (black)', 704, 'Корпус на iPhone 5 чёрный', 'empty_thumb.jpg', 155),
(12681, 'Housing iPhone 5 (white)', 704, 'Корпус на iPhone 5 белый', 'empty_thumb.jpg', 150),
(12682, 'Replacement Home Button Bracket for iPhone 5', 704, '<p>\r\n	Металлическая основа для шлейфа с кнопкой Home</p>\r\n', 'empty_thumb.jpg', 4.9),
(12683, 'Rubber pad Home button outside for iPhone 5 (black)', 704, 'Резиновая прокладка под накладку на кнопку Home', 'empty_thumb.jpg', 4),
(12911, 'LCD iPhone 5 + Touchscreen (black)', 704, 'Дисплей на iPhone 5 с сенсорным стеклом, чёрный', 'empty_thumb.jpg', 175),
(12912, 'LCD iPhone 5 + Touchscreen (white)', 704, 'Дисплей на iPhone 5 с сенсорным стеклом, белый', 'empty_thumb.jpg', 175),
(12929, 'Набор винтов для iPhone 5', 704, '', 'empty_thumb.jpg', 3.8),
(13038, 'LCD iPhone 5 + Touchscreen full (black)+camera+Home key', 704, '<p>\r\n	Дисплей на iPhone 5 с сенсорным стеклом, камерой и центральной кнопкой Home, чёрный</p>\r\n', 'empty_thumb.jpg', 190),
(13039, 'LCD iPhone 5 + Touchscreen full (white)+camera+Home key', 704, '<p>\r\n	Дисплей на iPhone 5 с сенсорным стеклом, камерой и центральной кнопкой Home, белый</p>\r\n', 'empty_thumb.jpg', 190),
(13093, 'Аккумулятор iPhone 5', 704, '', 'empty_thumb.jpg', 19),
(13398, 'Housing iPhone 5 (white) copy', 704, '<p>\r\n	Корпус на iPhone 5 белый улучшенная копия</p>\r\n', 'empty_thumb.jpg', 110),
(13399, 'Housing iPhone 5 (black) copy', 704, '<p>\r\n	Корпус на iPhone 5 чёрный улучшенная копия</p>\r\n', 'empty_thumb.jpg', 110),
(13400, 'Housing iPhone 5 (pink) copy', 704, '<p>\r\n	Корпус на iPhone 5 розовый улучшенная копия</p>\r\n', 'empty_thumb.jpg', 110),
(13401, 'Housing iPhone 5 (gold) copy', 704, '<p>\r\n	Корпус на iPhone 5 золотистый улучшенная копия</p>\r\n', 'empty_thumb.jpg', 110),
(9383, 'Power IC iPhone 3GS 338S0768-AE БЕЗ ГАРАНТИИ!!!', 705, 'Микросхема управления питанием ', 'empty_thumb.jpg', 45),
(9775, 'Power IC iPhone 3G БЕЗ ГАРАНТИИ !!!', 705, 'Микросхема управления питанием ', 'empty_thumb.jpg', 24),
(9776, 'Power IC iPhone 4 338S-0822- A3 БЕЗ ГАРАНТИИ !!!', 705, '09428HCF', 'empty_thumb.jpg', 45),
(9969, 'Charger IC iPhone 3G 40882/N0470/LTBH', 705, 'Микросхема для Iphone 3G (зарядки)', 'empty_thumb.jpg', 12),
(10290, 'USB Power Manager IC iPhone 3G (DEC 4088 EDE-2)', 705, '', 'empty_thumb.jpg', 7.9),
(10294, 'Sound IC iPhone 3GS/4G', 705, '', 'empty_thumb.jpg', 16),
(10395, 'Микросхема Wi-Fi iPhone 4 (модуль)', 705, '', 'empty_thumb.jpg', 33),
(10396, 'Micbias IC CD 3282 A1 iPhone 4', 705, 'микросхема звука во время разговора ', 'empty_thumb.jpg', 27),
(10477, 'PF-SKY 77529-24 iPhone 4', 705, '4679779', 'empty_thumb.jpg', 18),
(10478, 'CPU+Flash iPhone 4', 705, 'Флеш память', 'empty_thumb.jpg', 48),
(10731, 'TSC 2004_WCSP 25', 705, '', 'empty_thumb.jpg', 7.5),
(10732, 'SMP 3i 6820', 705, '', 'empty_thumb.jpg', 15),
(11609, 'SKY 77541-32', 705, '', 'empty_thumb.jpg', 18),
(12155, 'Power IC iPhone 4S 338S0973-A3  БЕЗ ГАРАНТИИ', 705, '<p>\r\n	1209EHHQ</p>\r\n', 'empty_thumb.jpg', 58),
(13207, 'Audio IC iPhone 5', 705, '', 'empty_thumb.jpg', 25),
(13208, 'IC WiFi iPhone 4S 339S0154', 705, '<p>\r\n	нагрев 200 градусов</p>\r\n', 'empty_thumb.jpg', 18),
(13210, 'Power IC 343S0542-A2 / iPad 2', 705, '', 'empty_thumb.jpg', 13.5),
(13404, 'IC WiFi iPhone 4S ', 705, '<p>\r\n	нагрев 300 градусов</p>\r\n', 'empty_thumb.jpg', 20),
(13406, 'Power IC iPhone 5 338S1131', 705, '', 'empty_thumb.jpg', 28),
(13407, 'IC USB/LCD iPhone 5 1608A1', 705, '', 'empty_thumb.jpg', 16),
(8990, 'Screen Guard iPad Crystal Clear', 840, '', 'empty_thumb.jpg', 5),
(8991, 'Screen Guard iPad Anti Glare', 840, '(матовая)', 'empty_thumb.jpg', 8),
(8992, 'Screen Guard iPad Mirror', 840, '(зеркальная)', 'empty_thumb.jpg', 7),
(9089, 'Capdase iMAG Screen Guard iPad ', 840, 'Superb Transparency & Anti-Glare protection', 'empty_thumb.jpg', 16),
(9818, 'Screen Guard iPad Green  Crystal Clear', 840, '', 'empty_thumb.jpg', 7),
(10018, 'Screen Guard iPad 2/3/4 Anti Glare', 840, '(матовая)', 'empty_thumb.jpg', 9),
(10019, 'Screen Guard iPad 2/3/4 Crystal Clear', 840, '', 'empty_thumb.jpg', 8.5),
(10427, 'Back Guard iPad 2 Carbon (grey)', 840, '<p>\r\n	Карбоновая защитная пленка.</p>\r\n', 'empty_thumb.jpg', 8.9),
(10555, 'Mallper Screen Protective Film iPad 2 (black)', 840, '', 'empty_thumb.jpg', 12.7),
(10866, 'Screen Guard Professional  iPad 2/3 (2 in 1)BULLKin ', 840, 'лицевая и задняя защитные плёнки (белая,серая,чёрная карбон)', 'empty_thumb.jpg', 9),
(10891, 'Screen Ward iPad 2 Back Side anti-glare', 840, 'anti-ultraviolet/air-bubble-proof', 'empty_thumb.jpg', 7.5),
(11063, 'Back Guard iPad 2 Carbon (black)', 840, '<p>\r\n	Карбоновая защитная пленка.</p>\r\n', 'empty_thumb.jpg', 8.9),
(11064, 'Back Guard iPad 2 Carbon (white)', 840, '<p>\r\n	Карбоновая защитная пленка.</p>\r\n', 'empty_thumb.jpg', 8.9),
(11069, 'Mallper Screen Protective Film iPad 2 (white)', 840, '', 'empty_thumb.jpg', 12.7),
(11532, 'HOCO Screen Professional for iPad 2/3/4', 840, '', 'empty_thumb.jpg', 12.4),
(12342, 'Screen Ward iPad 2 Back Side ', 840, '', 'empty_thumb.jpg', 9),
(12629, 'Screen Guard iPad 2 / New Waterproof', 840, '<p>\r\n	водонепроницаемая</p>\r\n', 'empty_thumb.jpg', 9.5),
(12803, 'Screen Guard  Professional iPad 2/3 Front BULLKin ', 840, '<p>\r\n	лицевая защитная плёнка</p>\r\n', 'empty_thumb.jpg', 5.7),
(12901, 'ISME Screen Guard iPad mini Anti Glare', 840, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 6.5),
(12902, 'ISME Screen Guard iPad mini Clear', 840, '', 'empty_thumb.jpg', 6),
(12943, 'Screen Guard iPad mini Anti Glare', 840, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 5),
(12944, 'Screen Guard iPad mini Clear', 840, '', 'empty_thumb.jpg', 5),
(12945, 'Screen Guard  iPad mini Clear BULLKin ', 840, '', 'empty_thumb.jpg', 5.7),
(12946, 'Screen Guard  iPad mini Anti Glare BULLKin ', 840, '(матовая)', 'empty_thumb.jpg', 5.7),
(13119, 'Back Screen Guard iPad mini Clear', 840, 'плотная защитная плёнка на заднюю крышку прозрачная', 'empty_thumb.jpg', 5),
(13314, 'Super Ultra Screen Protector iPad mini Clear', 840, '<p>\r\n	ультратонкая защитная плёнка на айпад мини прозрачная</p>\r\n', 'empty_thumb.jpg', 5),
(13315, 'Super Ultra Screen Protector iPad mini Anti Glare', 840, '<p>\r\n	ультратонкая защитная плёнка на айпад мини матовая</p>\r\n', 'empty_thumb.jpg', 5),
(7139, 'Screen Guard iPhone 2G', 841, '', 'empty_thumb.jpg', 1.7),
(7607, 'Screen Guard iPhone 2G Mirror ', 841, '(зеркальная)', 'empty_thumb.jpg', 1),
(7609, 'Screen Guard iPhone 3G/3GS Mirror ', 841, '(зеркальная)', 'empty_thumb.jpg', 2),
(7610, 'Screen Guard iPhone 3G/3GS Anti Glare', 841, '(матовая)', 'empty_thumb.jpg', 2),
(7655, 'Screen Guard iPhone 3G/3GS ', 841, '(глянцевая)', 'empty_thumb.jpg', 2),
(9028, 'Screen Guard + Skin iPhone 3G/3GS', 841, '', 'empty_thumb.jpg', 2.7),
(9148, 'Screen Guard iPhone 4/4S', 841, '', 'empty_thumb.jpg', 1.9),
(9149, 'Screen Guard iPhone 4/4S Anti Glare', 841, '(матовая)', 'empty_thumb.jpg', 2.7),
(9415, 'Skin iPhone 4 Carbon Black', 841, '', 'empty_thumb.jpg', 4),
(9641, 'Mallper Insulation Sticker for iPhone 4G (black/white/red)', 841, 'защитная плёнка на боковую часть корпуса iPhone 4G  ', 'empty_thumb.jpg', 6.7),
(9643, 'Screen Guard iPhone 4/4S Anti Glare Capdase - ARIS Screen Protector', 841, 'Crystal Clear with Anti-Reflection Protection', 'empty_thumb.jpg', 6.5),
(9644, 'Screen Guard iPhone 4/4S Anti Glare Capdase - iXiMAG Screen Protector', 841, 'Superb Transparency & Anti-Glare.Finger-Print & Grease Resistant.', 'empty_thumb.jpg', 6.5),
(9645, 'Screen Guard iPhone 4/4S Mirror Capdase-MIRA Screen Protector', 841, '2 in1 excellent protection: Crystal Clear & Silver Glass Mirror', 'empty_thumb.jpg', 10),
(9784, 'Screen Guard iPhone 4/4S Front/Back BULLKin  ', 841, '', 'empty_thumb.jpg', 3.3),
(9785, 'Screen Guard iPhone 4/4S Clear BULLKin  ', 841, '', 'empty_thumb.jpg', 2.9),
(9786, 'Mallper Screen Protective Film iPhone 4G ', 841, 'Compatible with capacitive touch screen', 'empty_thumb.jpg', 6),
(10100, 'Screen Guard iPhone 4/4S Front/Back', 841, '', 'empty_thumb.jpg', 2.8),
(10101, 'Screen Guard iPhone 4/4S Front/Back Mirror ', 841, '(зеркальная)', 'empty_thumb.jpg', 2),
(10102, 'Screen Guard iPhone 4/4S Front/Back Anti Glare ', 841, '(матовая)', 'empty_thumb.jpg', 2.8),
(10336, 'Screen Guard iPhone 4/4S Mirror', 841, '<p>\r\n	(зеркальная)</p>\r\n', 'empty_thumb.jpg', 1.6),
(10855, 'Screen Guard iPhone 4/4S Front/Back Diamond', 841, '', 'empty_thumb.jpg', 6.5),
(10864, 'Insulation Sticker for iPhone 4G (grey/clear/wtite)', 841, 'защитная плёнка на боковую часть корпуса iPhone 4G', 'empty_thumb.jpg', 5.2),
(12010, 'Skin iPhone 4/4S Wood', 841, '', 'empty_thumb.jpg', 12.5),
(12011, 'Skin iPhone 4/4S 3D', 841, '', 'empty_thumb.jpg', 9.8),
(12236, 'Skin iPhone 4/4S 3D BULLKin', 841, '', 'empty_thumb.jpg', 8.8),
(12237, 'Screen Guard iPhone 4/4S Front/Back HOCO', 841, '', 'empty_thumb.jpg', 6.6),
(12351, 'Skin iPhone 4/4S 3D JunLieg', 841, '', 'empty_thumb.jpg', 8),
(12585, 'Screen Guard iPhone 4/4S Front/Back Anti Glare BULLKin ', 841, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 3.3),
(12625, 'Screen Guard iPhone 4/4S Waterproof', 841, '<p>\r\n	водонепроницаемая</p>\r\n', 'empty_thumb.jpg', 5.5),
(12656, 'Screen Guard iPhone 5 Front/Back BULLKin ', 841, '<p>\r\n	задняя из трёх частей</p>\r\n', 'empty_thumb.jpg', 4.5),
(12657, 'Screen Guard iPhone 5 Anti Glare BULLKin ', 841, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 4),
(12771, 'Screen Guard iPhone 5 Front/Back Anti Glare BULLKin ', 841, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 4.5),
(12772, 'Screen Guard iPhone 5 Clear BULLKin ', 841, '', 'empty_thumb.jpg', 3.3),
(12775, 'Screen Guard iPhone 5 Front/Back Clear', 841, '', 'empty_thumb.jpg', 4),
(12776, 'Screen Guard iPhone 5 Front/Back Anti Glare', 841, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 4),
(12777, 'Screen Guard iPhone 5 Front/Back Mirror', 841, '<p>\r\n	(зеркальная)</p>\r\n', 'empty_thumb.jpg', 4.5),
(12778, 'Screen Guard iPhone 5 Clear', 841, '', 'empty_thumb.jpg', 3),
(12779, 'Screen Guard iPhone 5 Anti Glare ', 841, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 3.2),
(13044, 'Screen Guard iPhone 5 Front/Back Diamond BULLKin ', 841, '', 'empty_thumb.jpg', 5.5),
(12942, 'Screen Guard iPhone 5 Front/Back Clear HOCO', 841, '', 'empty_thumb.jpg', 5.3),
(12896, 'Skin iPhone 4 Carbon White', 841, '', 'empty_thumb.jpg', 4),
(12897, 'Skin iPhone 4S Carbon Black', 841, '', 'empty_thumb.jpg', 4),
(12898, 'Skin iPhone 4S Carbon White', 841, '', 'empty_thumb.jpg', 4),
(13045, 'Screen Guard iPhone 5 Front/Back Japan AF BULLKin ', 841, '', 'empty_thumb.jpg', 6.5),
(13480, 'Screen Guard iPhone 5 Anti Glare BULLKin ', 841, '', 'empty_thumb.jpg', 0),
(9146, 'Screen Guard iPod Touch 2G/3G', 842, '', 'empty_thumb.jpg', 1.5),
(9147, 'Screen Guard iPod Touch 2G/3G Anti Glare ', 842, '(матовая)', 'empty_thumb.jpg', 1.3),
(9536, 'Screen Guard iPod Touch 4G ', 842, '', 'empty_thumb.jpg', 1.7),
(9537, 'Screen Guard iPod Touch 4G Anti Glare ', 842, '(матовая)', 'empty_thumb.jpg', 1.9),
(9538, 'Screen Guard iPod Nano 6G', 842, '', 'empty_thumb.jpg', 1.1),
(9539, 'Screen Guard iPod Nano 6G Anti Glare ', 842, '(матовая)', 'empty_thumb.jpg', 1.2),
(9540, 'Screen Guard iPod Nano 5G', 842, '', 'empty_thumb.jpg', 0.9),
(13338, 'Screen Guard iPod Touch 5G Anti Glare', 842, '<p>\r\n	(матовая)</p>\r\n', 'empty_thumb.jpg', 3),
(13339, 'Screen Guard iPod Touch 5G ', 842, '', 'empty_thumb.jpg', 2.9),
(7027, 'Screen Guard MacBook Air 13.3"', 843, '', 'empty_thumb.jpg', 4.9),
(9955, 'Screen Guard MacBook Air 11.6"', 843, '', 'empty_thumb.jpg', 4),
(10376, 'Skin for Apple MacBook Air 11" carbon (white, black)', 843, '', 'empty_thumb.jpg', 7),
(10619, 'X-doria Keyboard Protector for MacBook Air/Pro 13.3"', 843, 'защитная плёнка на клавиатуру', 'empty_thumb.jpg', 19),
(10620, 'X-doria Keyboard Protector for MacBook Air 11.6"', 843, 'защитная плёнка на клавиатуру', 'empty_thumb.jpg', 19),
(10626, 'X-doria Screen Protector for MacBook 13.3"', 843, 'защитная плёнка на экран ', 'empty_thumb.jpg', 19),
(10627, 'X-doria Screen Protector for MacBook 11,6"', 843, 'защитная плёнка на экран', 'empty_thumb.jpg', 19),
(10862, 'Keypad protector TPU for Air 11,6"', 843, '', 'empty_thumb.jpg', 8),
(10863, 'Keypad protector TPU for Air 13,3"', 843, '', 'empty_thumb.jpg', 8),
(8110, 'Набор для открывания корпусов iPhone 2G/3G/3GS', 853, '', 'empty_thumb.jpg', 5),
(9013, 'Трафарет для iPhone 3G', 853, '', 'empty_thumb.jpg', 6.1),
(9015, 'Трафарет CPU iPhone', 853, '', 'empty_thumb.jpg', 5.95),
(9465, 'Трафарет для iPhone 3GS', 853, '', 'empty_thumb.jpg', 6.1),
(9711, 'Набор для открывания корпусов iPhone 4', 853, 'отвертка / присоска / пластиковые инструменты', 'empty_thumb.jpg', 6.5),
(9904, 'Клей для iPhone (для LCD)', 853, '', 'empty_thumb.jpg', 6.9),
(10182, 'Отвёртка Apple (крестовая)', 853, '', 'empty_thumb.jpg', 5.5),
(10332, 'Трафарет для iPhone 4', 853, '2G/3G/3GS', 'empty_thumb.jpg', 8),
(10829, 'Клей двухкомпонентный для iPhone', 853, '', 'empty_thumb.jpg', 7),
(12084, 'Отвёртка Apple (звездочка)', 853, '', 'empty_thumb.jpg', 5.5),
(12804, 'Присоска для вскрытия iPhone/iPod/iPad', 853, '', 'empty_thumb.jpg', 3),
(13450, 'Пластиковая основа для хранения болтов на iPhone 4G', 853, '', 'empty_thumb.jpg', 3.5),
(13451, 'Пластиковая основа для хранения болтов на iPhone 5', 853, '', 'empty_thumb.jpg', 5),
(13530, 'Трафарет для iPhone 5', 853, '', 'empty_thumb.jpg', 8),
(8446, 'Cable USB iPod Shuffle ', 879, '', 'empty_thumb.jpg', 9),
(8838, 'Capdase Leather Sleeve case iPod Nano 5G Lofti (red)', 879, '', 'empty_thumb.jpg', 15),
(8842, 'Capdase Leather Sleeve case iPod Nano 5G Lofti (black)', 879, '', 'empty_thumb.jpg', 19),
(9095, 'Sleeve case Soft jacket 2 iPod Nano 5G  Capdase (закрытый) (white)', 879, '', 'empty_thumb.jpg', 10),
(9096, 'Sleeve case Soft jacket iPod Nano 5G Capdase (открытый)', 879, '', 'empty_thumb.jpg', 16),
(9185, 'Socks for iPod (комплект)', 879, '', 'empty_thumb.jpg', 6.9),
(11054, 'Capdase Soft Jacket 2 Xpose - iPod Touch (4th generation) Silicone Case (grey)', 879, '', 'empty_thumb.jpg', 19.5),
(11055, 'Capdase Soft Jacket 2 Xpose - iPod Touch (4th generation) Silicone Case (white)', 879, '', 'empty_thumb.jpg', 19.5),
(11684, 'Capdase Sport Armband for iPod shuffle 2G', 879, '<p>\r\n	Syncha Sync and Charge Adaptor Set</p>\r\n', 'empty_thumb.jpg', 7.8),
(12606, 'Capdase Soft Jacket 2 Xpose - iPod Touch (4th generation) Silicone Case (clear)', 879, '', 'empty_thumb.jpg', 19),
(10504, 'Palmguard Air 13 with Trackpad Protector Silver for MacBook Air 13"', 880, 'Накладка на тачпад.', 'empty_thumb.jpg', 17),
(10505, 'Palmguard Pro 13 with Trackpad Protector Silver for MacBook Pro 13"', 880, 'Накладка на тачпад.', 'empty_thumb.jpg', 17),
(10506, 'Palmguard Pro 15 with Trackpad Protector Silver for MacBook Pro 15"', 880, 'Накладка на тачпад.', 'empty_thumb.jpg', 17),
(10507, 'Palmguard Air 11.6 with Trackpad Protector Silver for MacBook Air 11.6"', 880, 'Накладка на тачпад.', 'empty_thumb.jpg', 16),
(10617, 'Power Adapter MagSafe 85W (блок питания)', 880, 'блок питания ', 'empty_thumb.jpg', 95),
(10618, 'Power Adapter MagSafe 60W (блок питания)', 880, 'блок питания ', 'empty_thumb.jpg', 75),
(10624, 'Case iTaste Studio for Apple MacBook Air 11.6 (black)', 880, '<p>\r\n	Чехол - карман для MacBook Air 11.6</p>\r\n', 'empty_thumb.jpg', 37),
(10625, 'Case iTaste Studio for Apple MacBook Air 13.3', 880, '<p>\r\n	Чехол - карман для MacBook Air 13.3</p>\r\n', 'empty_thumb.jpg', 37),
(9090, 'Sleeve Case iPad (резиновый) (black-orange)', 881, '', 'empty_thumb.jpg', 3.5),
(9091, 'Protect back cover для iPad  ', 881, 'карбон-полимерный чехол (прозрачный)', 'empty_thumb.jpg', 3),
(9092, 'Кожаный чехол папка-трансформер iPad сase (black)', 881, '', 'empty_thumb.jpg', 15),
(9093, 'Кожаный чехол-папка для iPad (black)', 881, '', 'empty_thumb.jpg', 3.3),
(9189, 'Sleeve Case iPad original (замшевый чехол-папка) (black) ', 881, 'designed by Apple in California', 'empty_thumb.jpg', 20),
(9190, 'Кожаный чехол-папка для iPad (вертикальный) (black)', 881, '', 'empty_thumb.jpg', 3.2),
(9191, 'Кожаный чехол-папка для iPad (горизонтальный) (black)', 881, '', 'empty_thumb.jpg', 3.4),
(9240, 'Stylus iPad big (black)', 881, '', 'empty_thumb.jpg', 2.9),
(9266, 'Capdase Screen protector included Soft Jacket 2 Xpose iPad (white)', 881, '<p>\r\n	ультратонкий чехол с открытым экраном</p>\r\n', 'empty_thumb.jpg', 15),
(9267, 'Tuneshell for iPad (пластиковый чехол) (blue)', 881, 'чехол являет собой твердую оболочку и плотно прилегает к задней панели оставляя все порты и переключатели открытыми', 'empty_thumb.jpg', 7.5),
(9426, 'Stylus iPad small (white)', 881, '', 'empty_thumb.jpg', 1.8),
(9452, 'Camera Connection Kit for iPad', 881, 'Переходник для подключения карты памяти, камеры и USB устройств.', 'empty_thumb.jpg', 5.5),
(9700, 'Mallper USB Power Supply in Car Charger iPhone/iPad', 881, 'автомобильное зарядное устройство для iPad (2.1 A)', 'empty_thumb.jpg', 11),
(10898, 'Capdase Screen protector included Soft Jacket 2 Xpose iPad (black)', 881, '<p>\r\n	ультратонкий чехол с открытым экраном</p>\r\n', 'empty_thumb.jpg', 15),
(10899, 'Кожаный чехол-папка для iPad (brown)', 881, '', 'empty_thumb.jpg', 3.3),
(10900, 'Кожаный чехол-папка для iPad (red)', 881, '', 'empty_thumb.jpg', 3.3),
(10901, 'Кожаный чехол-папка для iPad (pink)', 881, '', 'empty_thumb.jpg', 3.3),
(10902, 'Stylus iPad small (black)', 881, '', 'empty_thumb.jpg', 1.8),
(10916, 'Sleeve Case iPad (резиновый) (black-pink)', 881, '', 'empty_thumb.jpg', 3.5),
(10917, 'Sleeve Case iPad (резиновый) (black-blue)', 881, '', 'empty_thumb.jpg', 3.5),
(10919, 'Tuneshell for iPad (пластиковый чехол) (pink)', 881, '<p>\r\n	чехол являет собой твердую оболочку и плотно прилегает к задней панели оставляя все порты и переключатели открытыми</p>\r\n', 'empty_thumb.jpg', 7.5),
(10920, 'Tuneshell for iPad (пластиковый чехол) (purple)', 881, '<p>\r\n	чехол являет собой твердую оболочку и плотно прилегает к задней панели оставляя все порты и переключатели открытыми</p>\r\n', 'empty_thumb.jpg', 7.5),
(10253, 'Apple iPad 2 Smart Cover Leather Tan (black)', 882, 'чехол специально создан для iPad 2 со встроенными магнитами которые легко защёлкиваются и чехол плотно ложиться на экран', 'empty_thumb.jpg', 9),
(10254, 'Back Cover for iPad 2 (green)', 882, '<p>\r\n	чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели</p>\r\n', 'empty_thumb.jpg', 5),
(10381, 'High Sensitive Stylus Pen (black, silver, white)', 882, 'Стилус универсальный для емкостного экрана (цвета в ассортименте) и имеет мягкий наконечник', 'empty_thumb.jpg', 2),
(10557, 'Mallper Mabaye series Cover iPad 2 ', 882, 'красивый дизайн с экологически чистых материалов абсолютно удобный для пользователей', 'empty_thumb.jpg', 13),
(10867, 'Capdase Protective Case Flip Jacket for iPad 2 (black)', 882, 'кожаный чехол который трансформируется в подставку и фиксирует iPad 2 в трех положениях', 'empty_thumb.jpg', 30),
(10877, 'LOCA Companion Case for iPad 2 /NEW iPad (black)', 882, '<p>\r\n	чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели</p>\r\n', 'empty_thumb.jpg', 10),
(10921, 'Smart Cover Polyurethane iPad 2 (pink) (шторка)', 882, 'Smart Cover изготовлен из кожи и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 13),
(10922, 'Smart Cover Polyurethane iPad 2 (green) (шторка)', 882, 'Smart Cover изготовлен из кожи и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 9),
(10923, 'Smart Cover Polyurethane iPad 2 (grеy) (шторка)', 882, 'Smart Cover изготовлен из кожи и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 14),
(10924, 'Back Cover for iPad 2 (gray)', 882, 'чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели', 'empty_thumb.jpg', 5),
(10925, 'Back Cover for iPad 2 (blue)', 882, '<p>\r\n	чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели</p>\r\n', 'empty_thumb.jpg', 5),
(10926, 'Back Cover for iPad 2 (pink)', 882, '<p>\r\n	чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели</p>\r\n', 'empty_thumb.jpg', 5),
(10929, 'LOCA Companion Case for iPad 2 /NEW iPad  (clear)', 882, 'чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели ', 'empty_thumb.jpg', 14),
(11414, 'LOCA Companion Case for iPad 2 /NEW iPad  (pink)', 882, '<p>\r\n	чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели</p>\r\n', 'empty_thumb.jpg', 14),
(11606, 'Capdase Protective Case Flip Jacket for iPad 2 (red)', 882, 'кожаный чехол который трансформируется в подставку и фиксирует iPad 2 в трех положениях', 'empty_thumb.jpg', 30),
(11631, 'Back Cover for iPad 2 (foggy)', 882, 'чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели', 'empty_thumb.jpg', 5),
(11632, 'Back Cover for iPad 2 (clear)', 882, '<p>\r\n	чехол изготовлен с высокопрочного полиуретана и являет собой твердую оболочку которая плотно прилегает к задней панели</p>\r\n', 'empty_thumb.jpg', 5),
(11651, 'iTaste Studio Simple Bag for iPad 2 (black)', 882, '<p>\r\n	Кожаный чехол - карман для iPad 2</p>\r\n', 'empty_thumb.jpg', 25),
(11652, 'Miaget Hermes case iPad 2 (white)', 882, 'красивая и элегантная сумка-конверт для iPad 2/iPad NEW', 'empty_thumb.jpg', 23),
(11653, 'Miaget Hermes case iPad 2 (black)', 882, 'красивая и элегантная сумка-конверт для iPad 2/iPad NEW', 'empty_thumb.jpg', 23),
(11654, 'Miaget Hermes case iPad 2 (beige)', 882, 'красивая и элегантная сумка-конверт для iPad 2/iPad NEW', 'empty_thumb.jpg', 23),
(11655, 'Miaget Hermes case iPad 2 (pink)', 882, 'красивая и элегантная сумка-конверт для iPad 2/iPad NEW', 'empty_thumb.jpg', 23),
(11656, 'Miaget Hermes case iPad 2 (red)', 882, 'красивая и элегантная сумка-конверт для iPad 2/iPad NEW', 'empty_thumb.jpg', 23),
(11673, 'Croco Crocodile design leather Case for iPad 2 (black)', 882, 'чехол из кожы рептилий внутри с каркасом из пластика', 'empty_thumb.jpg', 14),
(11674, 'Croco Crocodile design leather Case for iPad 2  (pink)', 882, 'чехол из кожы рептилий внутри с каркасом из пластика', 'empty_thumb.jpg', 14),
(11678, 'Flip Case for iPad 2 Rhombic (black)', 882, '', 'empty_thumb.jpg', 14),
(11679, 'Flip Case for iPad 2 Rhombic (white)', 882, '', 'empty_thumb.jpg', 14),
(11680, 'Flip Case for iPad 2 Rhombic (yellow)', 882, '', 'empty_thumb.jpg', 14),
(11681, 'Flip Case for iPad 2 Rhombic (blue)', 882, '', 'empty_thumb.jpg', 14),
(11683, 'Flip Case for iPad 2 Rhombic (pink)', 882, '', 'empty_thumb.jpg', 14),
(12061, 'ROCK Texture case for New iPad (black)', 883, '', 'empty_thumb.jpg', 27),
(12067, 'ROCK Texture case for New iPad (sand)', 883, '', 'empty_thumb.jpg', 27),
(12075, 'Leather case for NEW iPad/iPad 2 (black)', 883, '<p>\r\n	чехол</p>\r\n', 'empty_thumb.jpg', 17),
(12135, 'Leather Smart Cover for New iPad (black)', 883, '<p>\r\n	кожаная шторка</p>\r\n', 'empty_thumb.jpg', 20),
(12136, 'Polyurethane Smart Cover For New iPad (black)', 883, '', 'empty_thumb.jpg', 16),
(12339, 'Smart Case for New iPad (black)', 883, '', 'empty_thumb.jpg', 21),
(12340, 'Smart Case for New iPad (white)', 883, '', 'empty_thumb.jpg', 21),
(12341, 'ROCK Eternal case for New iPad (grey)', 883, '', 'empty_thumb.jpg', 28),
(12361, 'Leather Smart Cover for New iPad (beige)', 883, '', 'empty_thumb.jpg', 15.5),
(12390, 'ROCK Texture case for New iPad (green)', 883, '', 'empty_thumb.jpg', 27),
(12391, 'ROCK Texture case for New iPad (bronze)', 883, '', 'empty_thumb.jpg', 27),
(12439, 'Yoobao Executive leather Case for New iPad (black)', 883, '', 'empty_thumb.jpg', 33),
(12440, 'Yoobao Executive leather Case for New iPad (purple)', 883, '', 'empty_thumb.jpg', 32),
(12441, 'Yoobao Executive leather Case for New iPad (pink)', 883, '', 'empty_thumb.jpg', 31),
(12443, 'Trexta Slim Folio Case for New iPad (brown)', 883, '', 'empty_thumb.jpg', 33),
(12445, 'Trexta Slim Folio Case for New iPad (light pink)', 883, '', 'empty_thumb.jpg', 33),
(12446, 'Aigo Advanced leather Case for New iPad (black)', 883, '', 'empty_thumb.jpg', 32),
(12447, 'Aigo Advanced leather Case for New iPad (brown)', 883, '', 'empty_thumb.jpg', 32),
(12448, 'Aigo Advanced leather Case for New iPad (red)', 883, '', 'empty_thumb.jpg', 32),
(12451, 'Speck Magfolio Case for New iPad (black)', 883, '', 'empty_thumb.jpg', 19),
(12452, 'Speck Magfolio Case for New iPad (red)', 883, '', 'empty_thumb.jpg', 19),
(12453, 'Speck Magfolio Case for New iPad (multi-color)', 883, '', 'empty_thumb.jpg', 19),
(12454, 'BELK Case PU Leather for New iPad (grey)', 883, '', 'empty_thumb.jpg', 15),
(12460, 'BELK Case Italian Style for New iPad (black)', 883, '', 'empty_thumb.jpg', 15),
(12461, 'BELK Case Italian Style for New iPad (white)', 883, '', 'empty_thumb.jpg', 15),
(12463, 'BELK Case Italian Style for New iPad (pink)', 883, '', 'empty_thumb.jpg', 15),
(12464, 'BELK Case Italian Style for New iPad (blue)', 883, '', 'empty_thumb.jpg', 15),
(12465, 'BELK Case Italian Style for New iPad (orange)', 883, '', 'empty_thumb.jpg', 15),
(12596, 'ROCK Defense case for NEW iPad (grey)', 883, '', 'empty_thumb.jpg', 28),
(12597, 'ROCK Defense case for NEW iPad (green)', 883, '', 'empty_thumb.jpg', 27),
(12604, 'BOROFONE case for New iPad (black)', 883, '', 'empty_thumb.jpg', 29),
(12605, 'BOROFONE case for New iPad (grey)', 883, '', 'empty_thumb.jpg', 29),
(12684, 'Smart Case for New iPad original (black)', 883, '', 'empty_thumb.jpg', 59),
(12685, 'Smart Case for New iPad original (grey)', 883, '', 'empty_thumb.jpg', 59);
INSERT INTO `products` (`id`, `title`, `parent`, `content`, `image`, `price`) VALUES
(12888, 'Griffin wall charger for iPad/iPhone/iPod (dual USB)', 883, 'Сетевое зарядное устройство 2 USB 10watt /5volts/2.1amps', 'empty_thumb.jpg', 15),
(12960, 'ROCK Eternal case for New iPad (black)', 883, '', 'empty_thumb.jpg', 28),
(12961, 'ROCK Eternal case for New iPad (green)', 883, '', 'empty_thumb.jpg', 28),
(12963, 'ROCK Defense case for NEW iPad (orange)', 883, '', 'empty_thumb.jpg', 28),
(12903, 'ROCK Eternal case for iPad mini (green)', 884, 'кожаный чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 22),
(12904, 'Smart Cover Polyurethane for iPad mini (black)', 884, 'Smart Cover со встроенными магнитами которые легко защёлкиваются и чехол плотно ложиться на экран и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 17),
(12905, 'Smart Cover Polyurethane for iPad mini (grey)', 884, 'Smart Cover со встроенными магнитами которые легко защёлкиваются и чехол плотно ложиться на экран и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 15),
(12906, 'ROCK Veins case for iPad mini (cream)', 884, 'кожаный чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 22),
(12907, 'ROCK Flexible case for iPad mini (dark grey)', 884, 'чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 19.5),
(12908, 'USAMS Leather Stand Cover for iPad mini (black)', 884, 'Выполненный из мягкой кожи чехол USAMS отлично защитит iPad mini и оставляет доступ ко всем портам и функциональным клавишам', 'empty_thumb.jpg', 21),
(12909, 'USAMS Leather Stand Cover for iPad mini (white)', 884, 'Выполненный из мягкой кожи чехол USAMS отлично защитит iPad mini и оставляет доступ ко всем портам и функциональным клавишам', 'empty_thumb.jpg', 21),
(12910, 'USAMS Leather Stand Cover for iPad mini (pink)', 884, 'Выполненный из мягкой кожи чехол USAMS отлично защитит iPad mini и оставляет доступ ко всем портам и функциональным клавишам', 'empty_thumb.jpg', 20),
(12916, 'ROCK Veins case for iPad mini (dark grey)', 884, 'кожаный чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 22),
(12955, 'ROCK Eternal case for iPad mini (black)', 884, 'кожаный чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 22),
(12956, 'ROCK Eternal case for iPad mini (grey)', 884, '<p>\r\n	кожаный чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях</p>\r\n', 'empty_thumb.jpg', 22),
(12957, 'ROCK Eternal case for iPad mini (orange)', 884, 'кожаный чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 22),
(12958, 'ROCK Flexible case for iPad mini (pink)', 884, 'чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 19.5),
(12959, 'ROCK Flexible case for iPad mini (green)', 884, 'чехол-книжка который трансформируется в подставку и фиксирует iPad mini в трех положениях', 'empty_thumb.jpg', 19.5),
(12964, 'Smart Cover Polyurethane for iPad mini (pink)', 884, 'Smart Cover со встроенными магнитами которые легко защёлкиваются и чехол плотно ложиться на экран и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 17),
(12965, 'Smart Cover Polyurethane for iPad mini (white)', 884, 'Smart Cover со встроенными магнитами которые легко защёлкиваются и чехол плотно ложиться на экран и имеет мягкую подкладку с микрофибры, которая помогает содержать экран в чистоте', 'empty_thumb.jpg', 17),
(12966, 'Back Cover iPad mini (grey)', 884, '<p>\r\n	дымчатый чехол - крышка пластиковый на корпус</p>\r\n', 'empty_thumb.jpg', 8),
(12967, 'Back Cover iPad mini (clear)', 884, '<p>\r\n	прозрачный чехол - крышка пластиковая на корпус</p>\r\n', 'empty_thumb.jpg', 8),
(13046, 'BOROFONE case for iPad mini (black)', 884, '', 'empty_thumb.jpg', 22),
(13131, 'Baseus Grace leather Case iPad mini (blue)', 884, '', 'empty_thumb.jpg', 17),
(13132, 'Baseus Grace leather Case iPad mini (grey)', 884, '', 'empty_thumb.jpg', 17),
(8444, 'Hands free iPhone 3G/3GS/iPod Shuffle', 885, 'наушники\r\n', 'empty_thumb.jpg', 11.5),
(8652, 'Sleeve case Capdase Callid iPhone 3G/3GS (black)', 885, '<p>\r\n	чехол кожаный закрытый с прорезью</p>\r\n', 'empty_thumb.jpg', 14),
(8655, 'Sleeve case iPhone 3G/3GS (силиконовые red/pink/purple)', 885, '', 'empty_thumb.jpg', 1),
(8835, 'Sleeve case Capdase Snak iPhone 3G', 885, '', 'empty_thumb.jpg', 14),
(10255, 'Protective Case for iPhone 3G (black) Ultra Thin', 885, '', 'empty_thumb.jpg', 3),
(10959, 'Sleeve case Capdase Callid iPhone 3G/3GS (white)', 885, '', 'empty_thumb.jpg', 14),
(10960, 'Sleeve case Capdase Callid iPhone 3G/3GS (red)', 885, '', 'empty_thumb.jpg', 13),
(9194, 'Sleeve сase iPhone 4 (black)', 886, '<p>\r\n	силиконовый чехол</p>\r\n', 'empty_thumb.jpg', 2),
(9439, 'Capdase Soft Jacket 2 Xpose iPhone 4 (black) (силиконовый)', 886, 'чехол +мягкий чехол+подставка+защитная плёнка', 'empty_thumb.jpg', 9),
(9441, 'Capdase Alumor Metal Case iPhone 4 (black-pink)', 886, '', 'empty_thumb.jpg', 11),
(9442, 'Bumper case iPhone 4 high copy (black)', 886, '', 'empty_thumb.jpg', 7),
(9443, 'Bumper case iPhone 4 (purple)', 886, '', 'empty_thumb.jpg', 4),
(9444, 'Belkin Sleeve case iPhone 4 (white) (силиконовый)', 886, 'чехол силиконовый', 'empty_thumb.jpg', 6.5),
(9445, 'Crystal hard back case iPhone 4 (black)', 886, '', 'empty_thumb.jpg', 5),
(9503, 'Dual SIM Card for iPhone 4 (black) Back Cover 2 in 1', 886, 'переходник с задней крышкой на 2 сим карты ', 'empty_thumb.jpg', 16),
(9518, 'Crystal hard back case iPhone 4 clear (white)', 886, '', 'empty_thumb.jpg', 5),
(9522, 'Dual SIM Card for iPhone 4 (black) Back Cover 3 in 1', 886, 'переходник с задней крышкой на 3 сим карты', 'empty_thumb.jpg', 16),
(9565, 'Belkin Shield Eclipse for iPhone 4 (black-white) (силиконовый)', 886, 'чехол силиконовый', 'empty_thumb.jpg', 6),
(9571, 'Capdase Leather Case Forme Capparel iPhone 4/4S (black) (кожаный)', 886, 'чехол', 'empty_thumb.jpg', 19),
(9647, 'Moshi Hard Case For iPhone 4 (black)', 886, 'чехол', 'empty_thumb.jpg', 5),
(9699, 'ILUV Sentinel Metallic Case for iPhone 4 (bronze)', 886, 'пластиковый чехол', 'empty_thumb.jpg', 3),
(9960, 'Capdase Smart Pocket Value Set Callid Bold+Soft Jacket Xpose For iPhone 4 (black)', 886, '', 'empty_thumb.jpg', 29),
(10017, 'Compact Dual USB Charger for iPod/iPhone Griffin', 886, '', 'empty_thumb.jpg', 13),
(10398, 'Capdase Smart Pocket Callid Dot  iPhone 4/4S (white)', 886, '', 'empty_thumb.jpg', 19),
(10455, 'Epoxy Sticker iPhone 4', 886, 'наклейки', 'empty_thumb.jpg', 2),
(10554, 'Steven Paul Jobs case iPhone 4/4S', 886, '', 'empty_thumb.jpg', 3),
(10872, 'Crystal case iGlaze iPhone 4 (white)', 886, '', 'empty_thumb.jpg', 4),
(10873, 'Capdase Soft Jacket Fuze DS iPhone 4/4S (black-clear)', 886, '<p>\r\n	чехол +мягкий чехол+подставка+защитная плёнка</p>\r\n', 'empty_thumb.jpg', 10),
(10874, 'Crystal case Tenacity iPhone 4/4S (pink)', 886, '', 'empty_thumb.jpg', 6),
(10875, '	Crystal case E.L.Grande iPhone 4/4S 0,3mm (black)', 886, '', 'empty_thumb.jpg', 5),
(10967, 'Belkin Shield Eclipse for iPhone 4 (red-white) (силиконовый)', 886, '<p>\r\n	чехол силиконовый</p>\r\n', 'empty_thumb.jpg', 6),
(10968, 'Belkin Shield Eclipse for iPhone 4 (grey-white) (силиконовый)', 886, 'чехол силиконовый', 'empty_thumb.jpg', 6),
(10970, 'Belkin Sleeve case iPhone 4 (smoky) (силиконовый)', 886, '<p>\r\n	чехол силиконовый</p>\r\n', 'empty_thumb.jpg', 6.5),
(10971, 'Bumper case iPhone 4 (clear)', 886, '', 'empty_thumb.jpg', 4),
(10972, 'Bumper case iPhone 4 (blue)', 886, '', 'empty_thumb.jpg', 4),
(10974, 'Bumper case iPhone 4 (red)', 886, '', 'empty_thumb.jpg', 4),
(10985, 'Bumper case iPhone 4 high copy (white)', 886, '', 'empty_thumb.jpg', 7),
(10986, 'Bumper case iPhone 4 high copy (orange)', 886, '', 'empty_thumb.jpg', 7),
(10987, 'Bumper case iPhone 4 high copy (pink)', 886, '', 'empty_thumb.jpg', 7),
(10988, 'Bumper case iPhone 4 high copy (blue)', 886, '', 'empty_thumb.jpg', 7),
(10992, 'Capdase Smart Pocket Callid iPhone 4/4S (white)', 886, '<p>\r\n	кожаный чехол с прорезью</p>\r\n', 'empty_thumb.jpg', 19),
(10995, 'Capdase Smart Pocket Value Set Callid Bold+Soft Jacket Xpose For iPhone 4 (red)', 886, '', 'empty_thumb.jpg', 29),
(10998, 'Capdase Soft Jacket 2 Xpose iPhone 4 (white) (силиконовый)', 886, '<p>\r\n	чехол +мягкий чехол+подставка+защитная плёнка</p>\r\n', 'empty_thumb.jpg', 9),
(10999, 'Crystal hard back case iPhone 4 (blue)', 886, '', 'empty_thumb.jpg', 5),
(11001, 'Crystal hard back case iPhone 4 (pink)', 886, '', 'empty_thumb.jpg', 5),
(11002, 'Crystal hard back case iPhone 4 (red)', 886, '', 'empty_thumb.jpg', 5),
(11003, 'Crystal hard back case iPhone 4 (light blue)', 886, '', 'empty_thumb.jpg', 5),
(11005, 'Crystal hard back case iPhone 4 (silver)', 886, '', 'empty_thumb.jpg', 5),
(11006, 'Crystal hard back case iPhone 4 (white)', 886, '', 'empty_thumb.jpg', 5),
(11007, 'Crystal hard back case iPhone 4 clear (black)', 886, '', 'empty_thumb.jpg', 5),
(11008, 'ILUV Sentinel Metallic Case for iPhone 4 (silver)', 886, '<p>\r\n	пластиковый чехол</p>\r\n', 'empty_thumb.jpg', 3),
(11009, 'ILUV Sentinel Metallic Case for iPhone 4 (grey)', 886, '<p>\r\n	пластиковый чехол</p>\r\n', 'empty_thumb.jpg', 3),
(11010, 'ILUV Sentinel Metallic Case for iPhone 4 (gold)', 886, '<p>\r\n	пластиковый чехол</p>\r\n', 'empty_thumb.jpg', 3),
(11011, 'Moshi Hard Case For iPhone 4 (white)', 886, '', 'empty_thumb.jpg', 5),
(11013, 'Moshi Hard Case For iPhone 4 (red)', 886, '', 'empty_thumb.jpg', 5),
(11014, 'Moshi Hard Case For iPhone 4 (blue)', 886, '', 'empty_thumb.jpg', 5),
(11017, 'Capdase Alumor Metal Case iPhone 4 (black-blue)', 886, '', 'empty_thumb.jpg', 11),
(11018, 'Capdase Alumor Metal Case iPhone 4 (black)', 886, '', 'empty_thumb.jpg', 11),
(11019, 'Capdase Alumor Metal Case iPhone 4 (mirror-black)', 886, '', 'empty_thumb.jpg', 11),
(11020, 'Bumper hard plastic case ', 886, '', 'empty_thumb.jpg', 8),
(11023, 'Bumper hard plastic case Vser iPhone 4/4S (blue-white)', 886, '', 'empty_thumb.jpg', 8),
(11024, 'Bumper hard plastic case Vser iPhone 4/4S (green-white)', 886, '', 'empty_thumb.jpg', 8),
(11025, 'Bumper hard plastic case Vser iPhone 4/4S (white-clear)', 886, '', 'empty_thumb.jpg', 8),
(11030, 'Capdase Soft Jacket Fuze DS iPhone 4/4S (blue-clear)', 886, '', 'empty_thumb.jpg', 13),
(11031, 'Capdase Soft Jacket Fuze DS iPhone 4/4S (green-clear)', 886, '', 'empty_thumb.jpg', 13),
(11033, 'Capdase Soft Jacket Fuze DS iPhone 4/4S (yellow-clear)', 886, '', 'empty_thumb.jpg', 13),
(11035, 'Crystal case E.L.Grande iPhone 4/4S 0,3mm (orange)', 886, '', 'empty_thumb.jpg', 5),
(11036, 'Crystal case E.L.Grande iPhone 4/4S 0,3mm (grey)', 886, '', 'empty_thumb.jpg', 5),
(11037, 'Crystal case E.L.Grande iPhone 4/4S 0,3mm (white)', 886, '', 'empty_thumb.jpg', 5),
(11038, 'Crystal case E.L.Grande iPhone 4/4S 0,3mm (pink)', 886, '', 'empty_thumb.jpg', 5),
(11039, 'Crystal case Tenacity iPhone 4/4S (white)', 886, '', 'empty_thumb.jpg', 6),
(11040, 'Crystal case Tenacity iPhone 4/4S (lime)', 886, '', 'empty_thumb.jpg', 6),
(11041, 'Crystal case iGlaze iPhone 4 (smoky)', 886, '', 'empty_thumb.jpg', 4),
(11042, 'Crystal case iGlaze iPhone 4 (black)', 886, '', 'empty_thumb.jpg', 4),
(11043, 'Crystal case "iGlaze" iPhone 4 (pink)', 886, '', 'empty_thumb.jpg', 4),
(11044, 'Crystal case iGlaze iPhone 4 (purple)', 886, '', 'empty_thumb.jpg', 4),
(11045, 'Crystal case iGlaze iPhone 4 (green)', 886, '', 'empty_thumb.jpg', 4),
(11046, 'Crystal case iGlaze iPhone 4 (yellow)', 886, '', 'empty_thumb.jpg', 4),
(11047, 'Crystal case iGlaze iPhone 4 (blue)', 886, '', 'empty_thumb.jpg', 4),
(11048, 'Sleeve сase iPhone 4 (white)', 886, '<p>\r\n	силиконовый чехол</p>\r\n', 'empty_thumb.jpg', 2),
(11049, 'Sleeve сase iPhone 4 (pink)', 886, '<p>\r\n	силиконовый чехол</p>\r\n', 'empty_thumb.jpg', 2),
(11050, 'Sleeve сase iPhone 4 (violet)', 886, '<p>\r\n	силиконовый чехол</p>\r\n', 'empty_thumb.jpg', 2),
(11052, 'Capdase Smart Pocket Callid Dot  iPhone 4/4S (blue)', 886, '', 'empty_thumb.jpg', 19),
(11276, 'Crystal case Tenacity iPhone 4/4S (grey)', 886, '', 'empty_thumb.jpg', 6),
(11523, 'Capdase Alumor Metal Case iPhone 4 (mirror-purple)', 886, '', 'empty_thumb.jpg', 11),
(11538, 'Moshi Concerti for iPhone 4/4S (black)', 886, '', 'empty_thumb.jpg', 29),
(11607, 'Capdase Leather Case Forme Capparel iPhone 4/4S (white) (кожаный)', 886, 'чехол', 'empty_thumb.jpg', 19),
(11633, 'HOCO Open Face Case iPhone 4/4S (black) ', 886, '<p>\r\n	задняя накладка + пленка</p>\r\n', 'empty_thumb.jpg', 12),
(11634, 'HOCO Open Face Case iPhone 4/4S (black-red) ', 886, 'задняя накладка + пленка', 'empty_thumb.jpg', 12),
(11635, 'HOCO Open Face Case iPhone 4/4S (white) ', 886, 'задняя накладка + пленка', 'empty_thumb.jpg', 12),
(11636, 'HOCO Open Face Case iPhone 4/4S (red) ', 886, '<p>\r\n	задняя накладка + пленка</p>\r\n', 'empty_thumb.jpg', 12),
(11637, 'HOCO Open Face Case iPhone 4/4S (pink) ', 886, '<p>\r\n	задняя накладка + пленка</p>\r\n', 'empty_thumb.jpg', 12),
(11638, 'HOCO Duke Advanced Leather Case for iPhone 4/4S (white)', 886, '', 'empty_thumb.jpg', 18),
(11639, 'HOCO Duke Advanced Leather Case for iPhone 4/4S (pink)', 886, '', 'empty_thumb.jpg', 18),
(11640, 'HOCO Leather case Earl fashion for IPhone 4/4S (black)', 886, 'кожа', 'empty_thumb.jpg', 19),
(11641, 'HOCO Leather case Earl fashion for IPhone 4/4S (pink)', 886, 'кожа', 'empty_thumb.jpg', 19),
(11642, 'HOCO Leather case Earl fashion for IPhone 4/4S (red)', 886, 'кожа', 'empty_thumb.jpg', 19),
(11643, 'HOCO Leather case Earl fashion for IPhone 4/4S (white)', 886, 'кожа', 'empty_thumb.jpg', 19),
(11644, 'HOCO Leather case Marquess Classic for IPhone 4/4S (black)', 886, 'кожаный чехол с прорезью', 'empty_thumb.jpg', 20),
(11645, 'HOCO Leather case Marquess Classic for IPhone 4/4S (pink)', 886, 'кожаный чехол с прорезью', 'empty_thumb.jpg', 20),
(11647, 'DiscoveryBuy leather case for iPhone 4/4S (black)', 886, '', 'empty_thumb.jpg', 17),
(11648, 'DiscoveryBuy leather back cover for iPhone 4/4S (white)', 886, '', 'empty_thumb.jpg', 17),
(11649, 'DiscoveryBuy leather back cover for iPhone 4/4S (pink)', 886, '', 'empty_thumb.jpg', 17),
(11686, 'Capdase Soft Jacket 2 Xpose iPhone 4 (black-diamond) (силиконовый)', 886, '<p>\r\n	чехол +мягкий чехол+подставка+защитная плёнка</p>\r\n', 'empty_thumb.jpg', 9),
(12068, 'Moshi Concerti for iPhone 4/4S (red)', 886, '', 'empty_thumb.jpg', 29),
(12069, 'Moshi iGlaze Kameleon for iPhone 4/4S (black)', 886, 'leather shell case (кожа)', 'empty_thumb.jpg', 23),
(12070, 'Moshi iGlaze Kameleon for iPhone 4/4S (white)', 886, 'leather shell case (кожа)', 'empty_thumb.jpg', 23),
(12071, 'Moshi iGlaze snap on case for iPhone 4/4S (silver)', 886, '', 'empty_thumb.jpg', 23),
(12072, 'Moshi iGlaze snap on case for iPhone 4/4S (red)', 886, '', 'empty_thumb.jpg', 23),
(12073, 'Moshi iGlaze snap on case for iPhone 4/4S (black)', 886, '', 'empty_thumb.jpg', 23),
(12085, 'HOCO Open Face Case iPhone 4/4S (white-red)', 886, '', 'empty_thumb.jpg', 12),
(12086, 'HOCO Open Face Case iPhone 4/4S (purple) ', 886, '', 'empty_thumb.jpg', 12),
(12129, 'Moshi iGlaze snap on case for iPhone 4/4S (red) copy', 886, '', 'empty_thumb.jpg', 5),
(12131, 'Rhombic Case for iPhone 4/4S Chanel (black)', 886, '', 'empty_thumb.jpg', 13),
(12133, 'Rhombic Case for iPhone 4/4S Chanel (pink)', 886, '', 'empty_thumb.jpg', 13),
(12205, 'Button Stickers for iPhone/iPod/iPad', 886, 'наклейки на кнопку Home', 'empty_thumb.jpg', 1.8),
(12353, 'Capdase Upper Polka iPhone 4/4S (white)', 886, 'чехол из кожзаменителя  тип чехла флип-топ', 'empty_thumb.jpg', 18),
(12355, 'Borofone Explorer Leather Case for iPhone 4/4S (grey)', 886, '', 'empty_thumb.jpg', 15),
(12365, 'Moshi iGlaze snap on case for iPhone 4/4S (black) copy', 886, '', 'empty_thumb.jpg', 5),
(12406, 'HOCO Duke Advanced Leather Case for iPhone 4/4S (black)', 886, '', 'empty_thumb.jpg', 18),
(12482, 'SUPER Case for iPhone 4/4S (black)', 886, '', 'empty_thumb.jpg', 12),
(12483, 'SUPER Case for iPhone 4/4S (white)', 886, '', 'empty_thumb.jpg', 12),
(12484, 'SUPER Case for iPhone 4/4S (red)', 886, '', 'empty_thumb.jpg', 12),
(12485, 'SUPER Case for iPhone 4/4S (grey)', 886, '', 'empty_thumb.jpg', 12),
(13143, 'Чехол MissCase для iPhone 4/4S (purple)', 886, 'MissCase на iPhone 5 в виде узоров, oчень популярные и красивые декоративные чехлы выполненные в виде кружева, нежного, легкого и очень женственного', 'empty_thumb.jpg', 5),
(13144, 'Чехол MissCase для iPhone 4/4S (green)', 886, 'MissCase на iPhone 5 в виде узоров, oчень популярные и красивые декоративные чехлы выполненные в виде кружева, нежного, легкого и очень женственного', 'empty_thumb.jpg', 5),
(13176, 'Чехол-накладка c шипами на iPhone 4/4S (чёрный /шипы серебристые)', 886, '', 'empty_thumb.jpg', 4),
(13177, 'Чехол радужный для iPhone 4/4S (белый)', 886, '', 'empty_thumb.jpg', 5),
(13188, 'Чехол MissCase для iPhone 4/4S (pink)', 886, 'MissCase на iPhone 5 в виде узоров, oчень популярные и красивые декоративные чехлы выполненные в виде кружева, нежного, легкого и очень женственного', 'empty_thumb.jpg', 5),
(13190, 'Чехол MissCase для iPhone 4/4S (blue)', 886, 'MissCase на iPhone 5 в виде узоров, oчень популярные и красивые декоративные чехлы выполненные в виде кружева, нежного, легкого и очень женственного', 'empty_thumb.jpg', 5),
(13358, 'Ferrari Leather Hard case iPhone 4/4S (black)', 886, '', 'empty_thumb.jpg', 19),
(13359, 'Griffin Elan Form case iPhone 4 (black)', 886, '', 'empty_thumb.jpg', 8),
(13376, 'Moshi Hard Case For iPhone 4 (pink)', 886, '', 'empty_thumb.jpg', 5),
(13571, 'Чехол на iPhone 4/4S прозрачный с чёрным бампером ', 886, '', 'empty_thumb.jpg', 7),
(13572, 'Чехол на iPhone 4/4S прозрачный с белым бампером ', 886, '', 'empty_thumb.jpg', 7),
(13573, 'Чехол на iPhone 4/4S прозрачный с салатовым бампером ', 886, '', 'empty_thumb.jpg', 7),
(13574, 'Чехол на iPhone 4/4S прозрачный с оранжевым бампером ', 886, '', 'empty_thumb.jpg', 7),
(13575, 'Чехол на iPhone 4/4S прозрачный с розовым бампером ', 886, '', 'empty_thumb.jpg', 7),
(13595, 'Чехол-накладка на iPhone 4/4S чёрный с разноцветными камнями (в квадратик)', 886, '', 'empty_thumb.jpg', 13),
(13596, 'Чехол-накладка на iPhone 4/4S белый с разноцветными камнями (в квадратик)', 886, '', 'empty_thumb.jpg', 13),
(13597, 'Чехол-накладка на iPhone 4/4S чёрный с разноцветными камнями (дуга)', 886, '', 'empty_thumb.jpg', 13),
(13598, 'Чехол-накладка на iPhone 4/4S чёрный с разноцветными камнями (абстракция)', 886, '', 'empty_thumb.jpg', 13),
(9390, 'Перчатки для iPhone/iPad (black, white, brown, grey)', 887, 'Мягкие и теплые перчатки позволят вам пользоваться вашим iPhone, iPad или любым другим сенсорным мультимедийным устройством, сохраняя ваши руки в тепле.', 'empty_thumb.jpg', 2),
(12661, 'HOCO Duke Leather Case iPhone 5 (pink)', 887, 'кожаный чехол-книжка HOCO, присутствуют все вырезы под камеру, нижний динамик, кнопки регулировки громкости, откидная крышка чехла фиксируется на специальный зажим, внутри чехол обшит замшей', 'empty_thumb.jpg', 20),
(12662, 'HOCO Duke Leather Case iPhone 5 (black)', 887, 'кожаный чехол-книжка HOCO, присутствуют все вырезы под камеру, нижний динамик, кнопки регулировки громкости, откидная крышка чехла фиксируется на специальный зажим, внутри чехол обшит замшей', 'empty_thumb.jpg', 20),
(12663, 'HOCO Duke Leather Case iPhone 5 (white)', 887, 'кожаный чехол-книжка HOCO, присутствуют все вырезы под камеру, нижний динамик, кнопки регулировки громкости, откидная крышка чехла фиксируется на специальный зажим, внутри чехол обшит замшей', 'empty_thumb.jpg', 20),
(12664, 'ROCK Case Eternal iPhone 5 (black)', 887, '', 'empty_thumb.jpg', 17),
(12665, 'ROCK Case Eternal iPhone 5 (green)', 887, '', 'empty_thumb.jpg', 17),
(12810, 'Bumper case iPhone 5 (black)', 887, 'Бампер на iPhone 5 чёрный', 'empty_thumb.jpg', 11),
(12811, 'Bumper case iPhone 5 (white)', 887, 'Бампер на iPhone 5 белый', 'empty_thumb.jpg', 12),
(12812, 'Bumper case iPhone 5 (pink)', 887, 'Бампер на iPhone 5 розовый', 'empty_thumb.jpg', 11),
(12885, 'Moshi hard shell case iPhone 5 (black)', 887, 'Чехол - накладка для iPhone 5', 'empty_thumb.jpg', 8),
(12886, 'Moshi hard shell case iPhone 5 (white)', 887, 'Чехол - накладка для iPhone 5', 'empty_thumb.jpg', 8),
(12887, 'Moshi hard shell case iPhone 5 (pink)', 887, 'Чехол - накладка для iPhone 5', 'empty_thumb.jpg', 8),
(13170, 'Чехол c шипами для iPhone 5 (тигровый)', 887, 'пластиковый с наклеянной кожей', 'empty_thumb.jpg', 8),
(12920, 'HandsFree iPhone 5 EarPod original', 887, 'наушники оригинальные', 'empty_thumb.jpg', 28),
(12948, 'ROCK Case Eternal iPhone 5 (orange)', 887, '', 'empty_thumb.jpg', 17),
(12949, 'HOCO Lizard Leather Case iPhone 5 (black)', 887, 'кожаный чехол - книжки , серии Royal, линейка Lizard выполнены из телячьей кожи, в стиле кожи ящерицы путем искусственного рифления, внутренняя отделка чехлов замшей, края и технологические отверстия чехла дополнительно обработаны спайкой, используется кл', 'empty_thumb.jpg', 21),
(12950, 'HOCO Lizard Leather Case iPhone 5 (white)', 887, 'кожаный чехол - книжки , серии Royal, линейка Lizard выполнены из телячьей кожи, в стиле кожи ящерицы путем искусственного рифления, внутренняя отделка чехлов замшей, края и технологические отверстия чехла дополнительно обработаны спайкой, используется кл', 'empty_thumb.jpg', 21),
(12951, 'HOCO Lizard Leather Case iPhone 5 (pink)', 887, 'кожаный чехол - книжки , серии Royal, линейка Lizard выполнены из телячьей кожи, в стиле кожи ящерицы путем искусственного рифления, внутренняя отделка чехлов замшей, края и технологические отверстия чехла дополнительно обработаны спайкой, используется кл', 'empty_thumb.jpg', 21),
(12952, 'HOCO Protection Case iPhone 5 (black)', 887, 'кожаная чехол-накладка Нoco на заднюю панель', 'empty_thumb.jpg', 17),
(12953, 'HOCO Protection Case iPhone 5 (white)', 887, 'кожаная чехол-накладка Нoco на заднюю панель', 'empty_thumb.jpg', 17),
(12954, 'HOCO Protection Case iPhone 5 (pink)', 887, 'кожаная чехол-накладка Нoco на заднюю панель', 'empty_thumb.jpg', 17),
(13047, 'Case for iPhone 5 0,3mm (clear)', 887, 'Ультратонкий пластиковый чехол на iPhone 5 прозрачный', 'empty_thumb.jpg', 9),
(13048, 'Case for iPhone 5 0,3mm (black)', 887, 'Ультратонкий пластиковый чехол на iPhone 5 чёрный', 'empty_thumb.jpg', 9),
(13149, 'Чехол Marc Jacobs kisses для iPhone 5 (black)', 887, 'Case Marc by Marc Jacobs - чехол для iPhone 5 с изысканным рисунком от одного из законодателей современной моды Марка Джейкобса. Чехол подчеркнёт Вашу индивидуальность и выделит Ваш гаджет из толпы других. При этом он надежно защитит iPhone от повреждений', 'empty_thumb.jpg', 10),
(13151, 'Чехол Marc Jacobs kisses для iPhone 5 (silver)', 887, '<p>\r\n	Case Marc by Marc Jacobs - чехол для iPhone 5 с изысканным рисунком от одного из законодателей современной моды Марка Джейкобса. Чехол подчеркнёт Вашу индивидуальность и выделит Ваш гаджет из толпы других. При этом он надежно защитит iPhone от повреждений</p>\r\n', 'empty_thumb.jpg', 10),
(13153, 'Чехол Marc Jacobs резиновый с буквами для iPhone 5 (black)', 887, 'Case Marc by Marc Jacobs - чехол для iPhone 5 с изысканным рисунком от одного из законодателей современной моды Марка Джейкобса. Чехол подчеркнёт Вашу индивидуальность и выделит Ваш гаджет из толпы других. При этом он надежно защитит iPhone от повреждений', 'empty_thumb.jpg', 12),
(13155, 'Чехол Marc Jacobs резиновый с буквами для iPhone 5 (yellow)', 887, 'Case Marc by Marc Jacobs - чехол для iPhone 5 с изысканным рисунком от одного из законодателей современной моды Марка Джейкобса. Чехол подчеркнёт Вашу индивидуальность и выделит Ваш гаджет из толпы других. При этом он надежно защитит iPhone от повреждений', 'empty_thumb.jpg', 12),
(13159, 'Чехол с черепами для iPhone 5 (чёрный /черепа серебристые)', 887, 'пластиковый с наклеянной кожей', 'empty_thumb.jpg', 15),
(13161, 'Чехол с шипами крестом для iPhone 5 (черный/шипы золотистые)', 887, 'пластиковый с наклеянной кожей', 'empty_thumb.jpg', 8),
(13162, 'Чехол с шипами крестом для iPhone 5 (розовый/шипы серебристые)', 887, 'пластиковый с наклеянной кожей', 'empty_thumb.jpg', 8),
(13163, 'Чехол с шипами крестом для iPhone 5 (белый/шипы серебристые)', 887, 'пластиковый с наклеянной кожей', 'empty_thumb.jpg', 8),
(13164, 'Чехол с шипами крестом для iPhone 5 (английский флаг/шипы серебристые)', 887, 'пластиковый с наклеянной кожей', 'empty_thumb.jpg', 8),
(13167, 'Чехол для iPhone 5 радужный (чёрный)', 887, '', 'empty_thumb.jpg', 9),
(13171, 'Чехол для iPhone 5 радужный  (розовый)', 887, '', 'empty_thumb.jpg', 9),
(13172, 'Case for iPhone 5 0,3mm (pink)', 887, 'Ультратонкий пластиковый чехол на iPhone 5 розовый', 'empty_thumb.jpg', 9),
(13173, 'Case for iPhone 5 0,3mm (blue)', 887, 'Ультратонкий пластиковый чехол на iPhone 5 голубой', 'empty_thumb.jpg', 9),
(13174, 'Case for iPhone 5 0,3mm (green)', 887, 'Ультратонкий пластиковый чехол на iPhone 5 зелёный', 'empty_thumb.jpg', 9),
(13187, 'HandsFree iPhone 5 EarPod', 887, 'наушники', 'empty_thumb.jpg', 13.7),
(13299, 'Чехол Swarovski для iPhone 5 (розовый)', 887, '<p>\r\n	чехол-накладка пластиковый</p>\r\n', 'empty_thumb.jpg', 19),
(13300, 'Чехол Swarovski для iPhone 5 (голубой)', 887, 'чехол-накладка пластиковый', 'empty_thumb.jpg', 19),
(13301, 'Чехол Swarovski для iPhone 5 (бело-серебристый)', 887, '<p>\r\n	чехол-накладка пластиковый</p>\r\n', 'empty_thumb.jpg', 19),
(13351, 'Чехол с шипами для iPhone 5 (белый)', 887, '<p>\r\n	пластиковый с наклеянной кожей</p>\r\n', 'empty_thumb.jpg', 8),
(13353, 'Protective Case for iPhone 5 (grey-clear)', 887, 'Жёсткий чехол-накладка прозрачно-серый', 'empty_thumb.jpg', 10),
(13354, 'Protective Case for iPhone 5 (pink-clear)', 887, 'Жёсткий чехол-накладка прозрачно-розовый', 'empty_thumb.jpg', 10),
(13355, 'Protective Case for iPhone 5 (black-clear)', 887, 'Жёсткий чехол-накладка прозрачно-чёрный', 'empty_thumb.jpg', 10),
(13356, 'Protective Case for iPhone 5 (white-clear)', 887, 'Жёсткий чехол-накладка прозрачно-белый', 'empty_thumb.jpg', 10),
(13428, 'Чехол дополнительный аккумулятор для iPhone 5 "Ferrari" (чёрный)', 887, 'Очень тонкий чехол BackUp с аккумулятором для iPhone 5,Ёмкость батареи: 2500 mAh,Время в режиме ожидания: до 280 часов, Время в режиме разговора: до 6 часов в 3G, до 10 часов в 2G.', 'empty_thumb.jpg', 28),
(13429, 'Чехол дополнительный аккумулятор для iPhone 5 (серебристо-белый)', 887, 'Очень тонкий чехол BackUp с аккумулятором для iPhone 5,Ёмкость батареи: 2500 mAh,Время в режиме ожидания: до 280 часов, Время в режиме разговора: до 6 часов в 3G, до 10 часов в 2G.', 'empty_thumb.jpg', 26),
(13430, 'Чехол дополнительный аккумулятор для iPhone 5 (чёрный)', 887, 'Очень тонкий чехол BackUp с аккумулятором для iPhone 5,Ёмкость батареи: 2500 mAh,Время в режиме ожидания: до 280 часов, Время в режиме разговора: до 6 часов в 3G, до 10 часов в 2G.', 'empty_thumb.jpg', 26),
(13431, 'Чехол дополнительный аккумулятор для iPhone 5 "Ferrari" (серебристо-белый)', 887, 'Очень тонкий чехол BackUp с аккумулятором для iPhone 5,Ёмкость батареи: 2500 mAh,Время в режиме ожидания: до 280 часов, Время в режиме разговора: до 6 часов в 3G, до 10 часов в 2G.', 'empty_thumb.jpg', 28),
(13491, 'Mophie Juice Pack Air iPhone 5 (чёрный)', 887, '<p>\r\n	Чехол с дополнительным аккумулятором для iPhone 5 -это надежная защита и долгая работа вашего смартфона, есть индикатор заряда батареи, Материал: Поликарбонат</p>\r\n', 'empty_thumb.jpg', 34),
(13492, 'Mophie Juice Pack Air iPhone 5 (белый)', 887, '<p>\r\n	Чехол с дополнительным аккумулятором для iPhone 5 -это надежная защита и долгая работа вашего смартфона, есть индикатор заряда батареи, Материал: Поликарбонат</p>\r\n', 'empty_thumb.jpg', 34),
(13566, 'Чехол Swarovski для iPhone 5 (сыпучие камушки)', 887, '', 'empty_thumb.jpg', 15),
(13570, 'Protective Case for iPhone 5 (red-clear)', 887, 'Жёсткий чехол-накладка прозрачно-красный', 'empty_thumb.jpg', 10),
(13576, 'Чехол на iPhone 5 прозрачный с белым бампером ', 887, '', 'empty_thumb.jpg', 8),
(13577, 'Чехол на iPhone 5 прозрачный с чёрным бампером ', 887, '', 'empty_thumb.jpg', 8),
(13578, 'Чехол на iPhone 5 прозрачный с голубым бампером ', 887, '', 'empty_thumb.jpg', 8),
(13579, 'Чехол на iPhone 5 прозрачный с салатовым бампером ', 887, '', 'empty_thumb.jpg', 8),
(13580, 'Чехол на iPhone 5 прозрачный с розовым бампером ', 887, '', 'empty_thumb.jpg', 8),
(13581, 'Чехол на iPhone 5 (жёлтый с двумя белыми полосами)', 887, '', 'empty_thumb.jpg', 9),
(13582, 'Чехол на iPhone 5 (салатовый с двумя белыми полосами)', 887, '', 'empty_thumb.jpg', 9),
(13583, 'Чехол на iPhone 5 с белой полосой синий', 887, '', 'empty_thumb.jpg', 9),
(13584, 'Чехол на iPhone 5 с белой полосой розовый ', 887, '', 'empty_thumb.jpg', 9),
(13585, 'Чехол на iPhone 5 с белой полосой бирюзовый ', 887, '', 'empty_thumb.jpg', 9),
(13586, 'Чехол на iPhone 5 с белой полосой чёрный', 887, '', 'empty_thumb.jpg', 9),
(13600, 'Чехол-накладка на iPhone 5 чёрный с разноцветными камнями (в полоску)', 887, '', 'empty_thumb.jpg', 13),
(13601, 'Чехол-накладка на iPhone 5 белый с разноцветными камнями (в полоску)', 887, '', 'empty_thumb.jpg', 13),
(13602, 'Чехол-накладка на iPhone 5 чёрный с разноцветными камнями (дуга)', 887, '', 'empty_thumb.jpg', 13),
(13603, 'Чехол-накладка на iPhone 5 белый с разноцветными камнями (дуга)', 887, '', 'empty_thumb.jpg', 13),
(13604, 'Чехол-накладка на iPhone 5 чёрный с разноцветными камнями (сердце)', 887, '', 'empty_thumb.jpg', 13),
(13605, 'Чехол-накладка на iPhone 5 белый с разноцветными камнями (сердце)', 887, '', 'empty_thumb.jpg', 13),
(13606, 'Чехол-накладка на iPhone 5 чёрный с разноцветными камнями (купальник)', 887, '', 'empty_thumb.jpg', 13),
(13607, 'Чехол на iPhone 5 Swarovski белый с разноцветными кристаллами (полоса горизонтальная)', 887, '', 'empty_thumb.jpg', 25),
(13608, 'Чехол на iPhone 5 Swarovski белый с разноцветными кристаллами (полоса диагональ)', 887, '', 'empty_thumb.jpg', 25),
(13609, 'Чехол на iPhone 5 Swarovski белый с разноцветными кристаллами (полоса зигзаг)', 887, '', 'empty_thumb.jpg', 25),
(13610, 'Чехол на iPhone 5 Swarovski белый с разноцветными кристаллами и часами', 887, '', 'empty_thumb.jpg', 28),
(13611, 'Чехол на iPhone 5 Swarovski чёрный с разноцветными кристаллами и часами', 887, '', 'empty_thumb.jpg', 28),
(8393, 'Cable USB iPhone/iPod', 888, '', 'empty_thumb.jpg', 9),
(8552, 'Car kit iPhone 2G/3G + FM transmitter', 888, 'Автомобильная зарядка с держателем для iPod\\iPhone с av передатчиком', 'empty_thumb.jpg', 14),
(8660, 'Capdase Charger Dual USB Car & cable kit ', 888, 'Комплект зарядных устройств на iPhone с кабелем.', 'empty_thumb.jpg', 38),
(8661, 'Car kit Monster, iCar Changer inc.FM modulator', 888, 'Автомобильная зарядка с держателем для iPod\\iPhone с av передатчиком', 'empty_thumb.jpg', 18),
(9078, 'Charger any micro USB Auto Belkin ', 888, 'Micro-USB для прикуривателя  (Быстрозарядный USB-порт)', 'empty_thumb.jpg', 10.7),
(9080, 'AV Composite cable iPhone & iPod Capdase ', 888, 'кабель для подключения к audio & video (3 кабеля)', 'empty_thumb.jpg', 33),
(9178, 'Charger Dual USB Car Capdase (white, black)', 888, 'Автомобильная зарядка на iPhone', 'empty_thumb.jpg', 17),
(9186, 'Universal Dock For iPad big', 888, 'Подставка для iPad.', 'empty_thumb.jpg', 7),
(9187, 'Universal Dock For iPad small ', 888, 'Подставка для iPhone\\iPad.', 'empty_thumb.jpg', 5.5),
(9195, 'AC Adapter+euroadapter iPad original', 888, '', 'empty_thumb.jpg', 25),
(9196, 'Euroadapter iPhone/iPad', 888, '', 'empty_thumb.jpg', 6.3),
(9448, 'Micro Sim Cutter For iPhone 4/iPad', 888, 'обрезалка для симок', 'empty_thumb.jpg', 14),
(9449, 'Micro Sim Card Adapter (to SIM) Classic', 888, 'переходник на Micro sim', 'empty_thumb.jpg', 1.5),
(9640, 'AV Component cable iPhone & iPod Capdase ', 888, 'кабель для подключения к audio & video(5 кабелей)', 'empty_thumb.jpg', 34),
(9698, 'Charger any micro USB Auto Belkin  ( без упаковки )', 888, 'Micro-USB для прикуривателя  (Быстрозарядный USB-порт)', 'empty_thumb.jpg', 9.7),
(10250, 'VGA Adapter for iPad /iPad 2/iPhone 4/iPod touch 4', 888, 'адаптер для подключения iPad 2/iPad/iPhone 4/iPod touch 4G к телевизору, проэктору или VGA дисплею', 'empty_thumb.jpg', 35),
(10633, 'Micro Sim Card Adapter ', 888, 'переходник на Micro sim', 'empty_thumb.jpg', 1.5),
(10871, 'Griffin PowerJolt Dual Micro Car Charger for iPad/iPhone/iPod ', 888, 'автомобильное зарядное устройство оснащенное сразу двумя портами USB', 'empty_thumb.jpg', 19),
(10894, 'HDMI Adapter for iPad /iPad 2 ', 888, '<p>\r\n	HDMI кабель для подключения к телевизору.</p>\r\n', 'empty_thumb.jpg', 29),
(11608, 'AC Adapter+euroadapter iPad ', 888, '', 'empty_thumb.jpg', 19),
(12047, 'Stylus iPhone (short) black', 888, '', 'empty_thumb.jpg', 3.5),
(12048, 'Stylus iPhone (short) silver', 888, '', 'empty_thumb.jpg', 3.5),
(12049, 'Stylus iPhone (short) red', 888, '', 'empty_thumb.jpg', 3.5),
(12050, 'Stylus iPhone (short) pink', 888, '', 'empty_thumb.jpg', 3.5),
(12051, 'Stylus iPhone (middle) black', 888, '', 'empty_thumb.jpg', 3.5),
(12052, 'Stylus iPhone (middle) pink', 888, '', 'empty_thumb.jpg', 3.5),
(12053, 'Stylus iPhone (middle) white', 888, '', 'empty_thumb.jpg', 3.5),
(12204, 'Monster Beats by Dr. Dre iBeats With ControlTalk In-Ear Headphones (black) ', 888, 'вакуумные наушники-вкладыши для iPhone', 'empty_thumb.jpg', 35),
(12508, 'Monster Beats by Dr. Dre iBeats With ControlTalk In-Ear Headphones (white) ', 888, 'вакуумные наушники-вкладыши для iPhone', 'empty_thumb.jpg', 35),
(12658, 'Nano Sim Cutter iPhone 5 (noname)', 888, 'обрезалка для симок', 'empty_thumb.jpg', 16),
(12659, 'Nano Sim Cutter iPhone 5 ROCK + adapters', 888, 'обрезалка для симок', 'empty_thumb.jpg', 16),
(12660, 'Nano Sim + Micro Sim Adapters iPhone 4/4S/5', 888, 'переходник с nano и micro SIM', 'empty_thumb.jpg', 8),
(12917, 'USB Cable Lightning iPhone 5/ iPad mini ', 888, 'Кабель для iPhone5/iPad mini', 'empty_thumb.jpg', 9.8),
(12918, 'USB Cable Lightning iPhone 5/ iPad mini original', 888, 'Кабель для iPhone5/iPad mini', 'empty_thumb.jpg', 19),
(12919, 'Lightning to Micro USB Adapter', 888, 'переходник с микро USB на Lightning', 'empty_thumb.jpg', 13.5),
(12921, 'Connection Kit Lightning iPhone 5/ iPad mini 3-in-1', 888, 'переходник для фотокамер, Micro SD/ SD', 'empty_thumb.jpg', 15),
(12923, 'Lightning to 30-pin Adapter ', 888, 'переходник из нового коннектора Lightning в традиционный 30-пиновый разъем', 'empty_thumb.jpg', 11),
(13327, 'Портативное зарядное устройство Lepow-stone  (серебристое) 2 USB + кабель', 888, 'Портативный источник питания Lepow Stone 6000 имеет объем 6000mAh, 2 USB порта для зарядки ваших гаджетов,Тип батареи: Lithium-ion Polymer, Output Voltage: DC 5V,Output Current: 500mA(Ordinary mode),1200mA(Fast-charge mode),Input Current: 1000mA', 'empty_thumb.jpg', 40),
(13328, 'Портативное зарядное устройство Lepow-stone  (белое) 2 USB + кабель', 888, 'Портативный источник питания Lepow Stone 6000 имеет объем 6000mAh, 2 USB порта для зарядки ваших гаджетов,Тип батареи: Lithium-ion Polymer, Output Voltage: DC 5V,Output Current: 500mA(Ordinary mode),1200mA(Fast-charge mode),Input Current: 1000mA', 'empty_thumb.jpg', 40),
(13329, 'Портативное зарядное устройство Lepow-stone  (салатовое) 2 USB + кабель', 888, 'Портативный источник питания Lepow Stone 6000 имеет объем 6000mAh, 2 USB порта для зарядки ваших гаджетов,Тип батареи: Lithium-ion Polymer, Output Voltage: DC 5V,Output Current: 500mA(Ordinary mode),1200mA(Fast-charge mode),Input Current: 1000mA', 'empty_thumb.jpg', 40),
(13330, 'Портативное зарядное устройство Lepow-stone  (голубое) 2 USB + кабель', 888, 'Портативный источник питания Lepow Stone 6000 имеет объем 6000mAh, 2 USB порта для зарядки ваших гаджетов,Тип батареи: Lithium-ion Polymer, Output Voltage: DC 5V,Output Current: 500mA(Ordinary mode),1200mA(Fast-charge mode),Input Current: 1000mA', 'empty_thumb.jpg', 40),
(13331, 'Портативное зарядное устройство Lepow-stone  (розовое) 2 USB + кабель', 888, '<p>\r\n	Портативный источник питания Lepow Stone 6000 имеет объем 6000mAh, 2 USB порта для зарядки ваших гаджетов,Тип батареи: Lithium-ion Polymer, Output Voltage: DC 5V,Output Current: 500mA(Ordinary mode),1200mA(Fast-charge mode),Input Current: 1000mA</p>\r\n', 'empty_thumb.jpg', 40),
(13332, 'Портативное зарядное устройство Lepow-stone  (чёрное) 2 USB + кабель', 888, 'Портативный источник питания Lepow Stone 6000 имеет объем 6000mAh, 2 USB порта для зарядки ваших гаджетов,Тип батареи: Lithium-ion Polymer, Output Voltage: DC 5V,Output Current: 500mA(Ordinary mode),1200mA(Fast-charge mode),Input Current: 1000mA', 'empty_thumb.jpg', 40),
(13352, 'Nano Sim + Micro Sim Cutter iPhone/iPad', 888, 'Устройство для обрезки сим карт под нано сим и микросим карту.', 'empty_thumb.jpg', 19),
(13405, 'Griffin PowerJolt Dual Micro Car Charger for iPhone 5/iPad 4/iPad mini', 888, '', 'empty_thumb.jpg', 25),
(13489, 'Портативное зарядное устройство Lepow-stone  (золотистое) 2 USB + кабель', 888, '', 'empty_thumb.jpg', 40),
(13490, 'Портативное зарядное устройство Lepow-stone  (тёмно-розовый) 2 USB + кабель', 888, '', 'empty_thumb.jpg', 40),
(13453, 'Чехол на iPhone 5 Lamborghini Leather Flip Case (black) "Aventador D1"', 895, 'Чехол флип-кейс Lamborghini выполнен итальянскими мастерами по лицензии Lamborghini из натуральной высококачественной кожи; Чехол очень тонкий и легкий, все порты и разъёмы остаются открытыми. Чехол не увеличит вес и объем вашего смартфона. ', 'empty_thumb.jpg', 35),
(13454, 'Чехол на iPhone 5 Lamborghini Genuine Leather Slim Wallet Cover (black)', 895, 'Стильный кожаный чехол-крышка с логотипом Lamborghini и отделением для пластиковых карт', 'empty_thumb.jpg', 32),
(13455, 'Чехол на iPhone 5 Lamborghini Policarbonate and TPV 2in1 Back Cover (grey) "Super leggera stylish D1"', 895, 'Стильный пластиковый чехол-крышка с логотипом Lamborghini и флагом Италии. Цвет Серый .Идеально прилегает к устройству.Отверстия для камеры и вспышки.Свободный доступ к сенсорному экрану, элементам управления и необходимым разъемам.', 'empty_thumb.jpg', 23),
(13456, 'Чехол на iPhone 5 Lamborghini Policarbonate and TPV 2in1 Back Cover (white) "Super leggera stylish D1"', 895, 'Стильный пластиковый чехол-крышка с логотипом Lamborghini и флагом Италии. Цвет белый .Идеально прилегает к устройству.Отверстия для камеры и вспышки.Свободный доступ к сенсорному экрану, элементам управления и необходимым разъемам.', 'empty_thumb.jpg', 23),
(13457, 'Чехол на iPhone 5 Lamborghini Policarbonate and TPV 2in1 Back Cover (orange) "Super leggera stylish D1"', 895, 'Стильный пластиковый чехол-крышка с логотипом Lamborghini и флагом Италии. Цвет Оранжевый .Идеально прилегает к устройству.Отверстия для камеры и вспышки.Свободный доступ к сенсорному экрану, элементам управления и необходимым разъемам.', 'empty_thumb.jpg', 23),
(13458, 'Чехол на iPhone 5 Lamborghini Policarbonate Back Cover (black) "Murcielago stylish D1"', 895, '', 'empty_thumb.jpg', 25),
(13459, 'Чехол на iPhone 5 Lamborghini Policarbonate Back Cover (white) "Murcielago stylish D1"', 895, '', 'empty_thumb.jpg', 25),
(13460, 'Чехол на iPhone 5 Lamborghini Policarbonate Back Cover (black) "Gallardo Stylish D1"', 895, '', 'empty_thumb.jpg', 25),
(13461, 'Чехол на iPhone 5 Lamborghini Leather Flip Case (black-green) "Gallardo D2"', 895, 'Чехол флип-кейс Lamborghini выполнен итальянскими мастерами по лицензии Lamborghini из натуральной высококачественной кожи; Чехол очень тонкий и легкий, все порты и разъёмы остаются открытыми. Чехол не увеличит вес и объем вашего смартфона. ', 'empty_thumb.jpg', 35),
(13463, 'Чехол на iPhone 5 Lamborghini Genuine Leather Flip Case & Carbon Fiber (black)  "Avendator-D2"', 895, 'Чёрный чехол-флип выполнен из натуральной высококачественной кожи с карбоновой вставкой серии Avendator-D2 для iPhone 5', 'empty_thumb.jpg', 35),
(13464, 'Чехол на iPhone 5 Lamborghini Genuine Leather Back Cover (black) "Aventador"', 895, '', 'empty_thumb.jpg', 30),
(13465, 'Чехол на iPhone 5 Lamborghini Leather Back Cover (black) "Performante D1"', 895, 'Кожаный чехол накладка чёрного цвета Lamborghini – это символ успешности и богатства. Это по-настоящему статусный, роскошный аксессуар, который защитит и украсит Ваш смартфон.', 'empty_thumb.jpg', 27),
(13466, 'Чехол на iPhone 5 Lamborghini Leather Back Cover (white) "Performante D1"', 895, 'Кожаный чехол накладка белого цвета Lamborghini – это символ успешности и богатства. Это по-настоящему статусный, роскошный аксессуар, который защитит и украсит Ваш смартфон.', 'empty_thumb.jpg', 27),
(13467, 'Чехол на iPhone 5 Lamborghini Leather Flip Case (black) "Performante-D1"', 895, 'Чехол флип-кейс Lamborghini выполнен итальянскими мастерами по лицензии Lamborghini из натуральной высококачественной кожи; Чехол очень тонкий и легкий, все порты и разъёмы остаются открытыми. Чехол не увеличит вес и объем вашего смартфона. ', 'empty_thumb.jpg', 35),
(13468, 'Чехол на iPhone 5 Lamborghini Ultra-Slim Leather Flip Case (black)', 895, 'Чёрный ультра-тонкий чехол книжка для iPhone 5 из натуральной высококачественной кожи', 'empty_thumb.jpg', 35),
(13469, 'Чехол на iPhone 5 Lamborghini Ultra-Slim Leather Flip Case (white)', 895, 'Белый ультра-тонкий чехол книжка для iPhone 5 из натуральной высококачественной кожи', 'empty_thumb.jpg', 35),
(13470, 'Чехол на iPhone 5 Lamborghini Leather Flip Case (black) "Gallardo D1"', 895, 'Чёрный чехол флип-кейс на магните Lamborghini выполнен итальянскими мастерами по лицензии Lamborghini из натуральной высококачественной кожи', 'empty_thumb.jpg', 35),
(13471, 'Чехол на iPhone 5 Lamborghini Leather Back Cover + Vertical Wallet Cover iPhone "Gallardo D1"', 895, 'Кожаный чехол накладка чёрного цвета Lamborghini с отделом для пластиковых карт', 'empty_thumb.jpg', 32),
(13472, 'Чехол на iPhone 5 Lamborghini Leather Back Cover + Vertical Wallet Cover (white) "Gallardo D1"', 895, 'Кожаный чехол накладка белого цвета Lamborghini с отделом для пластиковых карт', 'empty_thumb.jpg', 32),
(13473, 'Чехол на iPhone 5 Lamborghini Leather Back Cover + Vertical Wallet Cover (purple) "Gallardo D1"', 895, 'Кожаный чехол накладка фиолетового цвета Lamborghini с отделом для пластиковых карт', 'empty_thumb.jpg', 32),
(13474, 'Чехол на iPhone 5 Lamborghini Leather Back Cover (black) "Genuine"', 895, 'Кожаный чехол накладка чёрного цвета Lamborghini – это символ успешности и богатства. Это по-настоящему статусный, роскошный аксессуар, который защитит и украсит Ваш смартфон.', 'empty_thumb.jpg', 30),
(13475, 'Чехол на iPhone 5 Lamborghini Genuine Leather Back Cover (black) "Gallardo D1"', 895, 'Кожаный чехол накладка чёрного цвета Lamborghini – это символ успешности и богатства. Это по-настоящему статусный, роскошный аксессуар, который защитит и украсит Ваш смартфон.', 'empty_thumb.jpg', 30),
(13476, 'Чехол на iPhone 5 Lamborghini Leather Sleeve Case (black) "Gallardo D1"', 895, 'Кожаный чехол карман чёрного цвета Lamborghini ', 'empty_thumb.jpg', 34),
(13477, 'Чехол на iPhone 5 Lamborghini Genuine Leather Back Cover & Carbon Fiber (black) "Aventador"', 895, '', 'empty_thumb.jpg', 31),
(13478, 'Чехол на iPhone 5 Lamborghini Genuine Leather Back Cover & Carbon Fiber (white) "Aventador"', 895, '', 'empty_thumb.jpg', 31);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1001;
--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13612;--
-- База данных: `ishop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` tinyint(3) unsigned NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `parent_id` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dostavka`
--

CREATE TABLE IF NOT EXISTS `dostavka` (
  `dostavka_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `goods_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `goods_brandid` tinyint(3) unsigned NOT NULL,
  `anons` text NOT NULL,
  `content` text NOT NULL,
  `visible` enum('0','1') NOT NULL DEFAULT '1',
  `hits` enum('0','1') NOT NULL DEFAULT '0',
  `new` enum('0','1') NOT NULL DEFAULT '0',
  `sale` enum('0','1') NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `img_slide` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `informers`
--

CREATE TABLE IF NOT EXISTS `informers` (
  `informer_id` tinyint(3) unsigned NOT NULL,
  `informer_name` varchar(255) NOT NULL,
  `informer_position` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `link_id` tinyint(3) unsigned NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `parent_informer` tinyint(3) unsigned NOT NULL,
  `links_position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `anons` text NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `dostavka_id` tinyint(3) unsigned NOT NULL,
  `payment_id` tinyint(3) unsigned NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zakaz_tovar`
--

CREATE TABLE IF NOT EXISTS `zakaz_tovar` (
  `zakaz_tovar_id` int(10) unsigned NOT NULL,
  `orders_id` int(10) unsigned NOT NULL,
  `goods_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Индексы таблицы `dostavka`
--
ALTER TABLE `dostavka`
  ADD PRIMARY KEY (`dostavka_id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`goods_id`);

--
-- Индексы таблицы `informers`
--
ALTER TABLE `informers`
  ADD PRIMARY KEY (`informer_id`);

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`link_id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Индексы таблицы `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Индексы таблицы `zakaz_tovar`
--
ALTER TABLE `zakaz_tovar`
  ADD PRIMARY KEY (`zakaz_tovar_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `dostavka`
--
ALTER TABLE `dostavka`
  MODIFY `dostavka_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `informers`
--
ALTER TABLE `informers`
  MODIFY `informer_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `link_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `zakaz_tovar`
--
ALTER TABLE `zakaz_tovar`
  MODIFY `zakaz_tovar_id` int(10) unsigned NOT NULL AUTO_INCREMENT;--
-- База данных: `mega`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL,
  `author` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `note_id` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `author`, `text`, `note_id`, `section`, `date`, `time`, `lang`) VALUES
(1, 'Абдула', 'Комментарий от Абдула', 'novost_dlya_ru_1', 'news', '2016-07-20', '12:12:42', 'ru'),
(2, 'Дмитрий', 'Комментарий от Дмитрия', 'novost_dlya_ru_2', 'news', '2016-07-21', '12:12:42', 'ru'),
(3, 'John', 'My comment', 'novost_dlya_en_1', 'news', '2016-07-20', '12:12:42', 'en'),
(4, 'Sam', 'Comment by Sam', 'novost_dlya_en_2', 'news', '2016-07-21', '04:13:13', 'en'),
(5, 'Шамиль', 'My comment', 'stilnyiy_protivoudarnyiy_smartfon', 'video', '2016-07-20', '12:12:42', 'ru'),
(6, 'Нурмагомед', 'Comment by Sam', 'iman_i6_vodoplavayuschiy_monstr_s_seryoznyimi_harakteristikami', 'video', '2016-07-21', '04:13:13', 'ru'),
(7, 'John', 'My comment', '10_filmov_pozhenivshih_zvezd', 'video', '2016-07-20', '12:12:42', 'en'),
(8, 'Sam', 'Comment by Sam', '11_samyih_bogatyih_boytsov_mma_ufc', 'video', '2016-07-21', '04:13:13', 'en'),
(9, 'Шамиль', 'Комментарий от Шамиля', 'novost_dlya_ru_2', 'news', '2016-07-20', '12:12:42', 'ru');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `title_url` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `img` varchar(100) NOT NULL,
  `keywords` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `views` varchar(100) NOT NULL DEFAULT '0',
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `title_url`, `text`, `img`, `keywords`, `description`, `date`, `time`, `views`, `lang`) VALUES
(1, 'Новость для ru 1', 'novost_dlya_ru_1', 'Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.\r\n\r\n', 'news1.jpg', 'ключ1, ключ2', 'описание Новость для ru 1', '2016-07-20', '12:12:42', '0', 'ru'),
(2, 'Новость для ru 2', 'novost_dlya_ru_2', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).\r\n\r\n', 'news2.jpg', 'ключ1, ключ2', 'описание Новость для ru 2', '2016-08-01', '04:13:13', '0', 'ru'),
(3, 'Новость для en 1', 'novost_dlya_en_1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n', 'news3.jpg', 'cluch1, cluch2', 'description Новость для en 1', '2016-07-21', '12:12:42', '0', 'en'),
(4, 'Новость для en 2', 'novost_dlya_en_2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n', 'news4.jpg', 'cluch1, cluch2', 'description Новость для en 2', '2016-07-21', '04:13:13', '0', 'en');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_url` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `title`, `title_url`, `keywords`, `description`, `lang`) VALUES
(1, 'Главная', 'index', 'главная страница, главная страница2', 'описание главной', 'ru'),
(2, 'Новости', 'news', 'новости, новости 2', 'описание новостей', 'ru'),
(3, 'Видео', 'video', 'видео1, видео2', 'описание видео', 'ru'),
(4, 'Галерея', 'photos', 'фотос1, фотос2', 'описание галереи', 'ru'),
(5, 'Обратная связь', 'contacts', 'contacts1, contacts2', 'Описание контактов', 'ru');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `title`, `img`, `date`, `time`, `lang`) VALUES
(1, 'Название 1 ru', '1ru.jpg', '2016-07-20', '12:12:42', 'ru'),
(2, 'Название 2 ru', '2ru.jpg', '2016-07-21', '12:12:42', 'ru'),
(3, 'Фотка 3', '3ru.jpg', '2016-07-20', '12:12:42', 'ru'),
(4, 'Фотка 4', '4ru.jpg', '2016-07-21', '04:13:13', 'ru'),
(5, 'Фотка 5', '5ru.jpg', '2016-07-20', '12:12:42', 'ru'),
(6, 'Фотка 6', '6ru.jpg', '2016-07-21', '04:13:13', 'ru'),
(7, 'Фотка 7 ', '7en.jpg', '2016-07-20', '12:12:42', 'en'),
(8, 'Фотка 8', '8en.jpg', '2016-07-21', '12:12:42', 'en'),
(9, 'Фотка 9', '9en.jpg', '2016-07-20', '12:12:42', 'en'),
(10, 'Фотка 10', '10en.jpg', '2016-07-22', '04:13:13', 'en'),
(11, 'Фотка 11', '11en.jpg', '2016-07-20', '12:12:42', 'en'),
(12, 'Фотка 12', '12en.jpg', '2016-07-22', '04:13:13', 'en');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(200) NOT NULL,
  `title_url` varchar(200) NOT NULL,
  `code` text NOT NULL,
  `keywords` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `views` int(10) NOT NULL DEFAULT '0',
  `lang` varchar(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `video`
--

INSERT INTO `video` (`id`, `title`, `title_url`, `code`, `keywords`, `description`, `date`, `time`, `views`, `lang`) VALUES
(1, 'NO.1 X-men X2 - стильный противоударный смартфон', 'stilnyiy_protivoudarnyiy_smartfon', '<iframe width="560" height="315" src="https://www.youtube.com/embed/1KWC74TlfO4" frameborder="0" allowfullscreen></iframe>', 'ключ 1, ключ 2', 'Описание', '2016-07-20', '12:12:42', 0, 'ru'),
(2, 'iMan i6 водоплавающий монстр с серьёзными характеристиками', 'iman_i6_vodoplavayuschiy_monstr_s_seryoznyimi_harakteristikami', '<iframe width="560" height="315" src="https://www.youtube.com/embed/cp_wUmfvJJs" frameborder="0" allowfullscreen></iframe>', 'ключ1, ключ2', 'описание', '2016-07-22', '04:13:13', 0, 'ru'),
(3, '10 Фильмов поженивших звезд', '10_filmov_pozhenivshih_zvezd', '<iframe width="560" height="315" src="https://www.youtube.com/embed/OoPGhLzDk_I" frameborder="0" allowfullscreen></iframe>', 'ключ1, ключ2', 'описание', '2016-07-20', '00:00:00', 0, 'en'),
(4, '11 Самых богатых бойцов MMA/UFC\r\n', '11_samyih_bogatyih_boytsov_mma_ufc', '<iframe width="560" height="315" src="https://www.youtube.com/embed/3fDpBxBWm4s" frameborder="0" allowfullscreen></iframe>', 'ключ1, ключ2', 'описание', '2016-07-28', '12:12:42', 0, 'en');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;--
-- База данных: `my-accounting`
--

-- --------------------------------------------------------

--
-- Структура таблицы `costs`
--

CREATE TABLE IF NOT EXISTS `costs` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `summa` int(11) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `costs`
--

INSERT INTO `costs` (`id`, `name`, `summa`, `datetime`, `description`) VALUES
(1, 'Пошел в магазин', 444, '2016-10-01 18:36:41', 'Пошел в магазин');

-- --------------------------------------------------------

--
-- Структура таблицы `earnings`
--

CREATE TABLE IF NOT EXISTS `earnings` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `summa` int(11) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `earnings`
--

INSERT INTO `earnings` (`id`, `name`, `summa`, `datetime`, `description`) VALUES
(1, 'Получил Зарплату', 2790, '2016-10-01 18:35:38', 'Получил зарплату с за первую половину 09.2016');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `costs`
--
ALTER TABLE `costs`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;--
-- База данных: `ruslan-shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_callback`
--

CREATE TABLE IF NOT EXISTS `yariko_callback` (
  `call_name` varchar(255) NOT NULL,
  `call_phone` varchar(255) NOT NULL,
  `call_email` varchar(255) NOT NULL,
  `call_message` text NOT NULL,
  `call_date` datetime NOT NULL,
  `call_id` int(11) unsigned NOT NULL,
  `call_proof` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_callback`
--

INSERT INTO `yariko_callback` (`call_name`, `call_phone`, `call_email`, `call_message`, `call_date`, `call_id`, `call_proof`) VALUES
('asaas', '+7(999) 999-99-99', '', '', '2016-10-10 20:42:40', 1, 0),
('Масаня', '+7(898) 552-14-64', '', '', '2016-10-10 20:44:23', 2, 0),
('Балала', '+7(526) 151-23-52', '', '', '2016-10-10 20:45:20', 3, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_cats`
--

CREATE TABLE IF NOT EXISTS `yariko_cats` (
  `cat_id` int(11) unsigned NOT NULL,
  `cat_title` varchar(255) NOT NULL,
  `cat_slug` varchar(255) NOT NULL,
  `cat_fullslug` varchar(255) NOT NULL,
  `cat_parent` int(11) unsigned NOT NULL,
  `cat_keywords` text NOT NULL,
  `cat_description` text NOT NULL,
  `cat_text` text NOT NULL,
  `cat_datecreate` datetime NOT NULL,
  `cat_dateupdate` datetime NOT NULL,
  `cat_params` text NOT NULL,
  `cat_visible` tinyint(1) NOT NULL DEFAULT '1',
  `catpicture_path` varchar(255) NOT NULL,
  `catpicture` varchar(255) NOT NULL,
  `catgallery_path` varchar(255) NOT NULL,
  `catgallery` varchar(255) NOT NULL,
  `cat_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_cats`
--

INSERT INTO `yariko_cats` (`cat_id`, `cat_title`, `cat_slug`, `cat_fullslug`, `cat_parent`, `cat_keywords`, `cat_description`, `cat_text`, `cat_datecreate`, `cat_dateupdate`, `cat_params`, `cat_visible`, `catpicture_path`, `catpicture`, `catgallery_path`, `catgallery`, `cat_mediafields`) VALUES
(16, 'Торты на день рождение', 'torty_na_den_rozhdenie', 'torty_na_den_rozhdenie', 0, '', '', '', '2016-06-21 08:57:13', '2016-10-10 23:18:14', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(27, 'Детские торты', 'detskie_torty', 'detskie_torty', 0, 'Заказать детские торты в Москве', '', '', '2016-10-10 23:17:50', '2016-10-10 23:17:50', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(28, 'Свадебные торты', 'svadebnye_torty', 'svadebnye_torty', 0, '', '', '', '2016-10-10 23:18:44', '2016-10-10 23:18:44', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(29, 'Капкейки', 'kapkeyki', 'kapkeyki', 0, '', '', '', '2016-10-10 23:18:59', '2016-10-10 23:18:59', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(30, 'Праздничные и годовщины', 'prazdnichnye_i_godovshchiny', 'prazdnichnye_i_godovshchiny', 0, '', '', '', '2016-10-10 23:20:00', '2016-10-10 23:20:00', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(31, 'Корпоративные торты', 'korporativnye_torty', 'korporativnye_torty', 0, '', '', '', '2016-10-10 23:20:17', '2016-10-10 23:20:17', 'a:0:{}', 1, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_delivery`
--

CREATE TABLE IF NOT EXISTS `yariko_delivery` (
  `delivery_id` int(11) unsigned NOT NULL,
  `delivery_title` varchar(255) NOT NULL,
  `delivery_name` varchar(255) NOT NULL,
  `delivery_description` text NOT NULL,
  `delivery_datecreate` datetime NOT NULL,
  `delivery_dateupdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_menus`
--

CREATE TABLE IF NOT EXISTS `yariko_menus` (
  `menu_id` int(11) unsigned NOT NULL,
  `menu_title` varchar(255) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_datecreate` datetime NOT NULL,
  `menu_dateupdate` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_menus`
--

INSERT INTO `yariko_menus` (`menu_id`, `menu_title`, `menu_name`, `menu_datecreate`, `menu_dateupdate`) VALUES
(20, 'Категории товаров', 'menu-main-sidebar', '2016-10-10 23:24:26', '2016-10-10 23:24:26'),
(24, 'Главное меню', 'menu-main-header', '2016-10-13 21:06:16', '2016-10-13 21:06:16');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_menus_objects`
--

CREATE TABLE IF NOT EXISTS `yariko_menus_objects` (
  `object_id` int(11) unsigned NOT NULL,
  `object_mid` int(11) unsigned NOT NULL DEFAULT '0',
  `object_position` int(11) unsigned NOT NULL,
  `object_oid` int(11) unsigned NOT NULL,
  `object_parent` int(11) unsigned NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_tid` int(11) NOT NULL DEFAULT '0',
  `object_title` varchar(255) NOT NULL,
  `object_url` varchar(255) NOT NULL,
  `object_alt` varchar(255) NOT NULL,
  `object_blank` tinyint(1) NOT NULL DEFAULT '0',
  `object_description` text NOT NULL,
  `object_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_menus_objects`
--

INSERT INTO `yariko_menus_objects` (`object_id`, `object_mid`, `object_position`, `object_oid`, `object_parent`, `object_type`, `object_tid`, `object_title`, `object_url`, `object_alt`, `object_blank`, `object_description`, `object_mediafields`) VALUES
(129, 20, 1, 13, 0, 'cat', 16, 'Торты на день рождение', '/category/torty_na_den_rozhdenie/', '', 0, '', 'a:0:{}'),
(130, 20, 2, 14, 0, 'cat', 27, 'Детские торты', '/category/detskie_torty/', '', 0, '', 'a:0:{}'),
(131, 20, 3, 15, 0, 'cat', 28, 'Свадебные торты', '/category/svadebnye_torty/', '', 0, '', 'a:0:{}'),
(132, 20, 4, 16, 0, 'cat', 30, 'Праздничные и годовщины', '/category/prazdnichnye_i_godovshchiny/', '', 0, '', 'a:0:{}'),
(133, 20, 5, 17, 0, 'cat', 31, 'Корпоративные торты', '/category/korporativnye_torty/', '', 0, '', 'a:0:{}'),
(134, 20, 6, 18, 0, 'cat', 29, 'Капкейки', '/category/kapkeyki/', '', 0, '', 'a:0:{}'),
(149, 24, 1, 2, 0, 'url', 0, 'Главная', '/', '', 0, '', 'a:0:{}'),
(150, 24, 2, 1, 0, 'page', 11, 'О нас', '/page/o_nas/', '', 0, '', 'a:0:{}'),
(151, 24, 3, 7, 0, 'page', 14, 'Цены', '/page/ceny/', '', 0, '', 'a:0:{}'),
(152, 24, 4, 4, 0, 'page', 12, 'Оплата и Доставка', '/page/oplata_i_dostavka/', '', 0, '', 'a:0:{}'),
(153, 24, 5, 5, 0, 'page', 13, 'Контакты', '/page/kontakty/', '', 0, '', 'a:0:{}'),
(154, 24, 6, 6, 0, 'url', 0, 'Группа Вконтакте', 'https://vk.com/vscakes', '', 1, '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_orders`
--

CREATE TABLE IF NOT EXISTS `yariko_orders` (
  `order_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `order_name` varchar(255) NOT NULL,
  `order_address` text NOT NULL,
  `order_phone` varchar(255) NOT NULL,
  `order_email` varchar(255) NOT NULL,
  `order_message` text NOT NULL,
  `order_date` datetime NOT NULL,
  `order_products` text NOT NULL,
  `order_proof` int(1) unsigned NOT NULL DEFAULT '0',
  `order_sum` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_orders`
--

INSERT INTO `yariko_orders` (`order_id`, `user_id`, `order_name`, `order_address`, `order_phone`, `order_email`, `order_message`, `order_date`, `order_products`, `order_proof`, `order_sum`) VALUES
(1, 4, 'Алисултанов Шамиль Нурмагомедович', 'Россия', '+7(999) 999-99-99', 'project.local@domain.com', 'asaasasas', '2016-10-10 20:32:14', '21|5', 0, 11000);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_pages`
--

CREATE TABLE IF NOT EXISTS `yariko_pages` (
  `page_id` int(11) unsigned NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_fullslug` varchar(255) NOT NULL,
  `page_parent` int(11) unsigned NOT NULL,
  `page_keywords` text NOT NULL,
  `page_description` text NOT NULL,
  `page_text` text NOT NULL,
  `page_datecreate` datetime NOT NULL,
  `page_dateupdate` datetime NOT NULL,
  `page_params` text NOT NULL,
  `page_visible` tinyint(1) NOT NULL DEFAULT '1',
  `pagepicture_path` varchar(255) NOT NULL,
  `pagepicture` varchar(255) NOT NULL,
  `pagegallery_path` varchar(255) NOT NULL,
  `pagegallery` varchar(255) NOT NULL,
  `page_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_pages`
--

INSERT INTO `yariko_pages` (`page_id`, `page_title`, `page_slug`, `page_fullslug`, `page_parent`, `page_keywords`, `page_description`, `page_text`, `page_datecreate`, `page_dateupdate`, `page_params`, `page_visible`, `pagepicture_path`, `pagepicture`, `pagegallery_path`, `pagegallery`, `page_mediafields`) VALUES
(11, 'О нас', 'o_nas', 'o_nas', 0, '', '', '&lt;p&gt;Добро пожаловать на нащ сайт, тут&amp;nbsp;вы можете заказать наивкуснейший торт на ваш праздник. Удивить родных, друзей, коллег необычным дизайном главного атрибута праздника, а именно тортиком, созданным мной по вашему дизайну и пожеланиям.&lt;/p&gt;', '2016-06-21 09:12:47', '2016-10-13 21:03:50', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(12, 'Оплата и Доставка', 'oplata_i_dostavka', 'oplata_i_dostavka', 0, '', '', '&lt;p&gt;Оплата и Доставка&lt;/p&gt;', '2016-06-21 09:13:52', '2016-10-13 21:00:38', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(13, 'Контакты', 'kontakty', 'kontakty', 0, '', '', '&lt;p&gt;Контакты&lt;/p&gt;', '2016-06-21 09:14:25', '2016-10-13 21:01:04', 'a:0:{}', 1, '', '', '', '', 'a:0:{}'),
(14, 'Цены', 'ceny', 'ceny', 0, '', '', '&lt;p&gt;Цены От 1250 руб/кг (если в торте три и более ярусов - От 1350 руб/кг)&lt;/p&gt;\r\n&lt;p&gt;Свадебные торты - от 1350 руб/кг&lt;/p&gt;\r\n&lt;p&gt;Торты в виде фигур, машин и т.д. - от 1350 р/кг и весят от 3,5 кг&lt;br /&gt;&lt;br /&gt;Цены указаны минимальные, на торты с самым простым дизайном.&lt;/p&gt;\r\n&lt;p&gt;Цветы, дополнительные фигурки и украшения увеличивают стоимость за 1 кг торта. Минимальный вес торта 2,5 кг, в редких случаях можно сделать торт на 2 кг&lt;/p&gt;', '2016-10-13 21:05:53', '2016-10-13 21:06:54', 'a:0:{}', 1, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_posts`
--

CREATE TABLE IF NOT EXISTS `yariko_posts` (
  `post_id` int(11) unsigned NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_slug` varchar(255) NOT NULL,
  `post_author` int(11) unsigned NOT NULL,
  `post_keywords` text NOT NULL,
  `post_description` text NOT NULL,
  `post_text` text NOT NULL,
  `post_quote` text NOT NULL,
  `post_datecreate` datetime NOT NULL,
  `post_datepublic` datetime NOT NULL,
  `post_dateupdate` datetime NOT NULL,
  `post_params` text NOT NULL,
  `post_visible` tinyint(1) NOT NULL DEFAULT '1',
  `post_special` tinyint(1) NOT NULL DEFAULT '0',
  `postpicture_path` varchar(255) NOT NULL,
  `postpicture` varchar(255) NOT NULL,
  `postgallery_path` varchar(255) NOT NULL,
  `postgallery` varchar(255) NOT NULL,
  `post_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_posts`
--

INSERT INTO `yariko_posts` (`post_id`, `post_title`, `post_name`, `post_slug`, `post_author`, `post_keywords`, `post_description`, `post_text`, `post_quote`, `post_datecreate`, `post_datepublic`, `post_dateupdate`, `post_params`, `post_visible`, `post_special`, `postpicture_path`, `postpicture`, `postgallery_path`, `postgallery`, `post_mediafields`) VALUES
(1, 'Мы открылись', '', 'my_otkrylis', 4, '', '', '&lt;p&gt;Мы открылись будьте здоровы&lt;/p&gt;', '&lt;p&gt;Мы открылись&lt;/p&gt;', '2016-10-10 23:03:10', '0000-00-00 00:00:00', '2016-10-10 23:03:10', 'a:0:{}', 1, 0, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_posts_relationships`
--

CREATE TABLE IF NOT EXISTS `yariko_posts_relationships` (
  `post_id` int(11) unsigned NOT NULL,
  `term_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_posts_relationships`
--

INSERT INTO `yariko_posts_relationships` (`post_id`, `term_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_products`
--

CREATE TABLE IF NOT EXISTS `yariko_products` (
  `product_id` int(11) unsigned NOT NULL,
  `product_article` varchar(255) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_slug` varchar(255) NOT NULL,
  `product_author` int(11) unsigned NOT NULL,
  `product_keywords` text NOT NULL,
  `product_description` text NOT NULL,
  `product_text` text NOT NULL,
  `product_quote` text NOT NULL,
  `product_datecreate` datetime NOT NULL,
  `product_dateupdate` datetime NOT NULL,
  `product_params` text NOT NULL,
  `product_visible` tinyint(1) NOT NULL DEFAULT '1',
  `product_special` tinyint(1) NOT NULL DEFAULT '0',
  `product_views` int(11) unsigned NOT NULL DEFAULT '0',
  `product_rating` int(11) unsigned NOT NULL DEFAULT '0',
  `product_price` int(11) unsigned NOT NULL DEFAULT '0',
  `product_pricewithdiscount` int(11) unsigned NOT NULL,
  `product_sales` int(11) unsigned NOT NULL DEFAULT '0',
  `product_discount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `product_simular` varchar(255) NOT NULL,
  `productpicture_path` varchar(255) NOT NULL,
  `productpicture` varchar(255) NOT NULL,
  `productgallery_path` varchar(255) NOT NULL,
  `productgallery` varchar(255) NOT NULL,
  `product_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_products`
--

INSERT INTO `yariko_products` (`product_id`, `product_article`, `product_title`, `product_slug`, `product_author`, `product_keywords`, `product_description`, `product_text`, `product_quote`, `product_datecreate`, `product_dateupdate`, `product_params`, `product_visible`, `product_special`, `product_views`, `product_rating`, `product_price`, `product_pricewithdiscount`, `product_sales`, `product_discount`, `product_simular`, `productpicture_path`, `productpicture`, `productgallery_path`, `productgallery`, `product_mediafields`) VALUES
(21, 'N-005', 'Тортик на годик', 'n-005', 4, 'Тортик на годик', 'Тортик на годик заказать в Москве', '&lt;p&gt;Какое то описание товара&lt;/p&gt;', '', '2016-08-17 12:42:05', '2016-10-10 22:51:49', 'a:2:{s:6:"param1";s:22:"Подошва:|ТЭП";s:6:"param2";s:65:"Внешний материал|натуральная замша";}', 1, 0, 0, 0, 2200, 2200, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/10/41/1/21/', '0_21.jpg', '', '', 'a:0:{}'),
(22, 'artikul111', 'Тортик на крещение', 'artikul111', 4, 'Тортик на крещение', 'Тортик на крещение заказать в Москве', '&lt;p&gt;Описание товара&lt;/p&gt;', '', '2016-10-10 22:50:22', '2016-10-10 22:50:22', 'a:1:{s:6:"param1";s:33:"Производитель|Reebok";}', 1, 0, 0, 0, 1500, 1500, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/10/41/1/22/', '0_22.jpg', '', '', 'a:0:{}'),
(23, 'artikul1212', 'Тортик Минни маус для девочки', 'artikul1212', 4, '', '', '&lt;p&gt;Жили были дед с бабой и вот вся история))&lt;/p&gt;', '', '2016-10-10 22:54:03', '2016-10-10 22:54:03', 'a:0:{}', 1, 0, 0, 0, 1850, 1850, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/10/41/1/23/', '0_23.jpg', '', '', 'a:0:{}'),
(24, 'artikul11221', 'Детский торт тачки', 'artikul11221', 4, '', '', '&lt;p&gt;Описание товара&lt;/p&gt;', '', '2016-10-10 23:10:30', '2016-10-10 23:25:40', 'a:0:{}', 1, 0, 0, 0, 1300, 1300, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/10/41/1/24/', '0_24.jpg', '', '', 'a:0:{}'),
(25, 'smesh1212', 'Тортик со смешариками', 'smesh1212', 4, '', '', '&lt;p&gt;Супер тортики со смешариками&lt;/p&gt;', '', '2016-10-10 23:56:46', '2016-10-10 23:56:46', 'a:0:{}', 1, 0, 0, 0, 1151, 1151, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/10/41/1/25/', '0_25.jpg', '', '', 'a:0:{}'),
(26, 'cats135', 'Тортик с котёнком', 'cats135', 4, '', '', '&lt;p&gt;Красивый тортик с котенком&lt;/p&gt;', '', '2016-10-11 00:04:03', '2016-10-11 00:04:03', 'a:0:{}', 1, 0, 0, 0, 1850, 1850, 0, 0, 'a:0:{}', '/files/products/productpicture/2016/10/41/2/26/', '0_26.jpg', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_products_relationships`
--

CREATE TABLE IF NOT EXISTS `yariko_products_relationships` (
  `product_id` int(11) unsigned NOT NULL,
  `cat_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_products_relationships`
--

INSERT INTO `yariko_products_relationships` (`product_id`, `cat_id`) VALUES
(21, 17),
(22, 16),
(23, 18),
(24, 27),
(25, 27),
(26, 27);

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_sliders`
--

CREATE TABLE IF NOT EXISTS `yariko_sliders` (
  `slider_id` int(11) unsigned NOT NULL,
  `slider_name` varchar(255) NOT NULL,
  `slider_callname` varchar(255) NOT NULL,
  `slider_params` text NOT NULL,
  `slider_datecreate` datetime NOT NULL,
  `slider_dateupdate` datetime NOT NULL,
  `slider_visible` tinyint(1) NOT NULL DEFAULT '1',
  `slider_sliders` text NOT NULL,
  `slider_path` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_sliders`
--

INSERT INTO `yariko_sliders` (`slider_id`, `slider_name`, `slider_callname`, `slider_params`, `slider_datecreate`, `slider_dateupdate`, `slider_visible`, `slider_sliders`, `slider_path`) VALUES
(1, 'Слайдер на главной11', 'homeslider', 'a:0:{}', '2016-06-13 14:29:29', '2016-10-11 21:52:05', 0, 'a:3:{i:0;a:7:{s:5:"title";s:25:"Детские торты";s:4:"link";s:42:"http://ruslan-shop/category/detskie_torty/";s:4:"text";s:0:"";s:5:"video";i:0;s:5:"blank";i:0;s:8:"videourl";s:0:"";s:6:"slider";s:7:"0_1.jpg";}i:1;a:7:{s:5:"title";s:41:"Торты на день рождение";s:4:"link";s:51:"http://ruslan-shop/category/torty_na_den_rozhdenie/";s:4:"text";s:0:"";s:5:"video";i:0;s:5:"blank";i:0;s:8:"videourl";s:0:"";s:6:"slider";s:7:"1_1.jpg";}i:2;a:7:{s:5:"title";s:33:"Праздничные торты";s:4:"link";s:56:"http://ruslan-shop/category/prazdnichnye_i_godovshchiny/";s:4:"text";s:0:"";s:5:"video";i:0;s:5:"blank";i:0;s:8:"videourl";s:0:"";s:6:"slider";s:7:"2_1.jpg";}}', '/files/sliders/2016/10/41/2/1/');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_terms`
--

CREATE TABLE IF NOT EXISTS `yariko_terms` (
  `term_id` int(11) unsigned NOT NULL,
  `term_title` varchar(255) NOT NULL,
  `term_slug` varchar(255) NOT NULL,
  `term_fullslug` varchar(255) NOT NULL,
  `term_parent` int(11) unsigned NOT NULL,
  `term_keywords` text NOT NULL,
  `term_description` text NOT NULL,
  `term_text` text NOT NULL,
  `term_datecreate` datetime NOT NULL,
  `term_dateupdate` datetime NOT NULL,
  `term_params` text NOT NULL,
  `term_visible` tinyint(1) NOT NULL DEFAULT '1',
  `termpicture_path` varchar(255) NOT NULL,
  `termpicture` varchar(255) NOT NULL,
  `termgallery_path` varchar(255) NOT NULL,
  `termgallery` varchar(255) NOT NULL,
  `term_mediafields` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_terms`
--

INSERT INTO `yariko_terms` (`term_id`, `term_title`, `term_slug`, `term_fullslug`, `term_parent`, `term_keywords`, `term_description`, `term_text`, `term_datecreate`, `term_dateupdate`, `term_params`, `term_visible`, `termpicture_path`, `termpicture`, `termgallery_path`, `termgallery`, `term_mediafields`) VALUES
(1, 'Новости', 'novosti', 'novosti', 0, '', '', '', '2016-10-10 23:02:38', '2016-10-10 23:02:38', 'a:0:{}', 1, '', '', '', '', 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `yariko_users`
--

CREATE TABLE IF NOT EXISTS `yariko_users` (
  `user_id` int(11) unsigned NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_surname` varchar(100) NOT NULL,
  `user_middlename` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_address` text NOT NULL,
  `user_about` text NOT NULL,
  `user_status` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  `user_date` datetime NOT NULL,
  `user_network` varchar(255) NOT NULL,
  `user_identity` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `yariko_users`
--

INSERT INTO `yariko_users` (`user_id`, `user_login`, `user_password`, `user_name`, `user_surname`, `user_middlename`, `user_email`, `user_phone`, `user_address`, `user_about`, `user_status`, `user_date`, `user_network`, `user_identity`) VALUES
(1, 'root', '776b153e48474f60d843395d6b946eb2', 'Адмирал', 'Генерал', 'Алладин', 'ex3xeng@yandex.ru', '+7 (989) 880-07-02', 'РД, г.Махачкала ул.Дахадаева 48', 'it&#039;s work!', '3', '2016-06-14 07:30:05', '', ''),
(4, 'prototype1992', '2321b7aea1f646de58dd073726c45497', 'Шамиль', 'Алисултанов', 'Нурмагомедович', 'project.local@domain.com', '', 'Россия г. Москва', 'Спросите))', '3', '2016-10-10 23:07:51', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `yariko_callback`
--
ALTER TABLE `yariko_callback`
  ADD PRIMARY KEY (`call_id`);

--
-- Индексы таблицы `yariko_cats`
--
ALTER TABLE `yariko_cats`
  ADD PRIMARY KEY (`cat_id`);

--
-- Индексы таблицы `yariko_delivery`
--
ALTER TABLE `yariko_delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Индексы таблицы `yariko_menus`
--
ALTER TABLE `yariko_menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Индексы таблицы `yariko_menus_objects`
--
ALTER TABLE `yariko_menus_objects`
  ADD PRIMARY KEY (`object_id`);

--
-- Индексы таблицы `yariko_orders`
--
ALTER TABLE `yariko_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `yariko_pages`
--
ALTER TABLE `yariko_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Индексы таблицы `yariko_posts`
--
ALTER TABLE `yariko_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `yariko_posts_relationships`
--
ALTER TABLE `yariko_posts_relationships`
  ADD UNIQUE KEY `post_id` (`post_id`,`term_id`);

--
-- Индексы таблицы `yariko_products`
--
ALTER TABLE `yariko_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `yariko_products_relationships`
--
ALTER TABLE `yariko_products_relationships`
  ADD UNIQUE KEY `product_id` (`product_id`,`cat_id`);

--
-- Индексы таблицы `yariko_sliders`
--
ALTER TABLE `yariko_sliders`
  ADD PRIMARY KEY (`slider_id`);

--
-- Индексы таблицы `yariko_terms`
--
ALTER TABLE `yariko_terms`
  ADD PRIMARY KEY (`term_id`);

--
-- Индексы таблицы `yariko_users`
--
ALTER TABLE `yariko_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `yariko_callback`
--
ALTER TABLE `yariko_callback`
  MODIFY `call_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `yariko_cats`
--
ALTER TABLE `yariko_cats`
  MODIFY `cat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT для таблицы `yariko_delivery`
--
ALTER TABLE `yariko_delivery`
  MODIFY `delivery_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `yariko_menus`
--
ALTER TABLE `yariko_menus`
  MODIFY `menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT для таблицы `yariko_menus_objects`
--
ALTER TABLE `yariko_menus_objects`
  MODIFY `object_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT для таблицы `yariko_orders`
--
ALTER TABLE `yariko_orders`
  MODIFY `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `yariko_pages`
--
ALTER TABLE `yariko_pages`
  MODIFY `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `yariko_posts`
--
ALTER TABLE `yariko_posts`
  MODIFY `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `yariko_products`
--
ALTER TABLE `yariko_products`
  MODIFY `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT для таблицы `yariko_sliders`
--
ALTER TABLE `yariko_sliders`
  MODIFY `slider_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `yariko_terms`
--
ALTER TABLE `yariko_terms`
  MODIFY `term_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `yariko_users`
--
ALTER TABLE `yariko_users`
  MODIFY `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;--
-- База данных: `tree_comments`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(5) NOT NULL,
  `parent_id` int(5) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;--
-- База данных: `view-counter`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
