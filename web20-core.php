<?php
/**
 * Путь к папке с плагином
 */
define("__Web20__", WP_PLUGIN_DIR.'/web20-notifications/');
/**
 * Подключаем библиотеке и функции
 */
include_once (__Web20__.'web20-function.php');
include_once (__Web20__.'inc/pro/WebIcqPro.class.php');
include_once (__Web20__.'inc/jabber.class.php');

/**
 * Постоянная переменная имени сайта, для вывода в функциях
 */
define("__Web20BlogName__", get_bloginfo('name')); //
