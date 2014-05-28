<?php

/*
  Plugin Name: Web20 notifications
  Plugin URI: http://www.zixn.ru/category/wp_create_plugin
  Description: Advanced event notifications in the blog, support ICQ, Jabber comment notifications, user logins, adding draft and publish records. Расширенные способы уведомлений о событиях в блоге, поддержка ICQ, Jabber уведомлений о комментариях, входах пользователей, добавлению черновиков и публикации записей.
  Version: 1.0
  Author: Djon
  Author URI: http://zixn.ru
 */

/*  Copyright 2014  Djon  (email: Ermak_not@mail.ru)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 */

/**
 * Класс для плагина wordpress
 */
class Web20ParserSity {

    public $_table_name;
    public $_wpdb;
    public $_prefixdb;
    public $_url_index;

    /**
     * Конструктор класса
     *  - Добавляем ссылку на файл объединяющий все части плагина
     */
    public function __construct() {
        require_once (WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/web20-core.php');
    }

    /**
     * Создавалка необходимых таблиц
     */
    protected function Web20CreateTable() {
        $this->_wpdb = $wpdb;
    }

}

//Реализуем класс
$objclass = new Web20ParserSity;
//Хуки из опционального списка
$web20_notification = get_option('web20_notification');
if (Web20Checkbox_verify($web20_notification, 'comments1') == "checked") //кто нибудь оставил коммент
    add_action('comment_post', 'web20hook_commentadd', 30);
if (Web20Checkbox_verify($web20_notification, 'postpublic2') == "checked") //добавление поста
    add_action('publish_post', 'web20hook_postadd');
if (Web20Checkbox_verify($web20_notification, 'postdraft2') == "checked") //добавление черновика
    add_action('transition_post_status', 'Web20hook_poststatus', 10, 3);
if (Web20Checkbox_verify($web20_notification, 'userlogon3') == "checked") //Вход пользователя   
    add_action('init', 'Web20DashboardLoad'); //Повесил на страницу загрузки Дашборда
    
// add_action('wp_login', 'Web20hook_loginuser');
//Пользователь активный в данный момент
//wp_get_current_user;
//$web20CurUser=  Web20CurentUser();
//add_option("web20_current_user", $web20CurUser, '', 'yes');
//add_action('draft_to_publish','web20hook_postinsert');
//add_action( 'the_post', 'huli_net' );
if (Web20Checkbox_verify($web20_notification, 'notification_noactiveplugin') == "checked") //Удаление опций из базы при деактивации 
    register_deactivation_hook(__FILE__, 'Web20Deactivation');

add_action('admin_menu', 'web20_register_adminmenu');
add_action('admin_menu', 'web20_register_admin_submenu1');

/**
 * Добавляет меню
 */
function web20_register_adminmenu() {
    add_menu_page("Web20", "Web20", "8", "web20-index", null, plugins_url("web20-notifications/img/ico.ico"));
}

/**
 * Добавляет суб меню
 */
function web20_register_admin_submenu1() {

    add_submenu_page("web20-index", "Сервисы уведомлений", "Сервисы", '8', 'web20-index', "web20Cp");
    add_submenu_page("web20-index", "Настройки плагина", "Настройки", '8', 'web20-options', "web20Opt");
    add_submenu_page("web20-index", "О плагине", "Разработка", '8', 'web20-about', "web20Oabout");
}

/**
 * Ссылка на страницу пункта меню
 */
function web20Cp() {
    include_once 'web20-cp.php';
}

function web20Opt() {
    include_once 'web20-opt.php';
}

function web20Oabout() {
    include_once 'web20-about.php';
}

//$wp->init();

