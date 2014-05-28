<?php

/**
 * Вызывается при деактивации плагина
 */
function Web20Deactivation() {
    delete_option('web20_icquid');
    delete_option('web20_icquid_to');
    //delete_option('web20_pole1');
    delete_option('web20_icqpassword');
    //delete_option('icq_test_text'); //Временная опция
    //delete_option('web20_current_user'); //Временная опция
    delete_option('web20_jabberjid');
    delete_option('web20_jabberassword');
    delete_option('web20_jabberjid_to');
    delete_option('web20_jabberserver');
    delete_option('web20_jabberport');
    delete_option('web20_comments');
    delete_option('web20_postdraft');
    delete_option('web20_userlogon');
    //delete_option('web20_update_wp');
    //delete_option('web20_update_plugin');
    delete_option('web20_notificationicq');
    delete_option('web20_notificationjabber');
    delete_option('web20_notification'); //Массив настроек
}

/**
 * Отправлялка icq сообщений
 */
function Web20icqSender($toicq, $texticq, $uid, $password) {

    $texticq = mb_convert_encoding($texticq, 'cp1251', 'UTF-8');

    define('UIN', $uid);
    define('PASSWORD', $password);
    define('STARTXSTATUS', 'studying');
    define('STARTSTATUS', 'STATUS_EVIL');
    $icq = new WebIcqPro();

    $icq->connect(UIN, PASSWORD) or die($icq->error);

    $icq->setOption('UserAgent', 'miranda');

    if ($icq->sendMessage($toicq, $texticq)) {
        return true;
    } else {
        echo $icq->error;
    }
}

/**
 * Отправка сообщений в Jabber
 */
function Web20JabberSender($server, $port, $user, $password, $message, $tema, $touserjid) {

    $jabber = new jabber($server, $port, $user, $password);
// Подключаемся к серверу
    if (!$jabber->connect()) {
        print "Ошибка соединения с сервером: " . $jabber->server;
        exit();
    }
// Авторитизируемся
    if (!$jabber->login()) {
        echo "Ошибка авторитизации. Пользователь: " . $jabber->username;
        exit();
    }

    $jabber->send_message($touserjid, mb_convert_encoding(mb_convert_encoding($message, 'cp1251', 'UTF-8'), 'UTF-8', 'cp1251'), mb_convert_encoding(mb_convert_encoding($tema, 'cp1251', 'UTF-8'), 'UTF-8', 'cp1251'));

// Отсоединяемся
    $jabber->disconnect();

// Выводим лог работы
//print $jabber->get_log();
}

/**
 * Проверка чекбокса на странице настроек
 */
function Web20Checkbox_verify($array, $value) {
    for ($i = 0; $i < count($array); $i++) {
        if ($value == $array[$i]) {
            return "checked";
        }
    }
}

/**
 * Для проверки хуков
 */
function TraTest() {
    $blog_title = get_bloginfo('name');
    $message = "Добавленн новый жопс на сайт " . $blog_title;
    return $message;
}

/**
 * Статус поста
 */
function Web20hook_poststatus($new_status, $old_status, $post) {
    if ($old_status == 'draft' AND $new_status = 'draft') {
        web20hook_postdraft();
    }
}

/**
 * Отправялем при поступлении комментария
 */
function web20hook_commentadd() {
    $web20_notification = get_option('web20_notification');
    $message = "Добавленн новый комментарий на сайт -- " . __Web20BlogName__ . " --";
    if (Web20Checkbox_verify($web20_notification, 'notificationicq6') == "checked") {
        $web20_icquid = get_option('web20_icquid');
        $web20_icqpassword = get_option('web20_icqpassword');
        $web20_icquid_to = get_option('web20_icquid_to');
        Web20icqSender($web20_icquid_to, $message, $web20_icquid, $web20_icqpassword);
    }

    if (Web20Checkbox_verify($web20_notification, 'notificationjabber7') == "checked") {
        $web20_jabberjid = get_option('web20_jabberjid');
        $web20_jabberassword = get_option('web20_jabberassword');
        $web20_jabberjid_to = get_option('web20_jabberjid_to');
        $web20_jabberserver = get_option('web20_jabberserver');
        $web20_jabberport = get_option('web20_jabberport');
        $tema = "NewComment";

        Web20JabberSender($web20_jabberserver, $web20_jabberport, $web20_jabberjid, $web20_jabberassword, $message, $tema, $web20_jabberjid_to);
    }
}

/**
 * Отправка сообщений при публикации поста
 * 
 */
function web20hook_postadd() {
    $web20_notification = get_option('web20_notification');
    $message = "Опубликованна новая запись на сайт -- " . __Web20BlogName__ . " -- пользователем " . Web20CurentUser();
    if (Web20Checkbox_verify($web20_notification, 'notificationicq6') == "checked") {
        $web20_icquid = get_option('web20_icquid');
        $web20_icqpassword = get_option('web20_icqpassword');
        $web20_icquid_to = get_option('web20_icquid_to');
        Web20icqSender($web20_icquid_to, $message, $web20_icquid, $web20_icqpassword);
    }
    if (Web20Checkbox_verify($web20_notification, 'notificationjabber7') == "checked") {
        $web20_jabberjid = get_option('web20_jabberjid');
        $web20_jabberassword = get_option('web20_jabberassword');
        $web20_jabberjid_to = get_option('web20_jabberjid_to');
        $web20_jabberserver = get_option('web20_jabberserver');
        $web20_jabberport = get_option('web20_jabberport');
        $tema = "NewPost";
        Web20JabberSender($web20_jabberserver, $web20_jabberport, $web20_jabberjid, $web20_jabberassword, $message, $tema, $web20_jabberjid_to);
    }
}

/**
 * Отправка при добавление черновика
 */
function web20hook_postdraft() {
    $web20_notification = get_option('web20_notification');
    $message = "Добавленн новый Черновик на сайт -- " . __Web20BlogName__ . " -- пользователем " . Web20CurentUser();
    if (Web20Checkbox_verify($web20_notification, 'notificationicq6') == "checked") {
        $web20_icquid = get_option('web20_icquid');
        $web20_icqpassword = get_option('web20_icqpassword');
        $web20_icquid_to = get_option('web20_icquid_to');
        Web20icqSender($web20_icquid_to, $message, $web20_icquid, $web20_icqpassword);
    }
    if (Web20Checkbox_verify($web20_notification, 'notificationjabber7') == "checked") {
        $web20_jabberjid = get_option('web20_jabberjid');
        $web20_jabberassword = get_option('web20_jabberassword');
        $web20_jabberjid_to = get_option('web20_jabberjid_to');
        $web20_jabberserver = get_option('web20_jabberserver');
        $web20_jabberport = get_option('web20_jabberport');
        $tema = "Draft";
        Web20JabberSender($web20_jabberserver, $web20_jabberport, $web20_jabberjid, $web20_jabberassword, $message, $tema, $web20_jabberjid_to);
    }
}

/**
 * Отправка при входе пользователя
 */
function Web20hook_loginuser() {
    $web20_notification = get_option('web20_notification');
    $message = $messageUser = "Пользователь " . Web20CurentUser() . " вошёл на сайт-- " . __Web20BlogName__ . " --";
    if (Web20Checkbox_verify($web20_notification, 'notificationicq6') == "checked") {
        $web20_icquid = get_option('web20_icquid');
        $web20_icqpassword = get_option('web20_icqpassword');
        $web20_icquid_to = get_option('web20_icquid_to');
        Web20icqSender($web20_icquid_to, $message, $web20_icquid, $web20_icqpassword);
    }
    if (Web20Checkbox_verify($web20_notification, 'notificationjabber7') == "checked") {
        $web20_jabberjid = get_option('web20_jabberjid');
        $web20_jabberassword = get_option('web20_jabberassword');
        $web20_jabberjid_to = get_option('web20_jabberjid_to');
        $web20_jabberserver = get_option('web20_jabberserver');
        $web20_jabberport = get_option('web20_jabberport');

        $tema = "LogonUser";

        Web20JabberSender($web20_jabberserver, $web20_jabberport, $web20_jabberjid, $web20_jabberassword, $message, $tema, $web20_jabberjid_to);
    }
}

/**
 * Определяем текущего пользователя
 */
function Web20CurentUser() {

    $current_user = wp_get_current_user();
    return $current_user->user_login;
}

/**
 * Хук определения того что мы в дашборде
 */
function Web20DashboardLoad() {
    $stringurl = get_bloginfo('url');
    $url_admin = admin_url();
    $url_site = site_url();
    $patch_admin = str_replace($url_site, "", $url_admin);
    $urldash = $patch_admin;
    //$urldahsindex = "/[a-zA-Z0-9.-_]*/";
    $curentpage = $stringurl . $_SERVER['REQUEST_URI'];
    //$curentpage=$stringurl."/index.php";
    //$curentpageindex = $stringurl . $_SERVER['REQUEST_URI'] . $urldahsindex;
    if ($stringurl . $urldash === $curentpage) {
        Web20hook_loginuser();
    }
}
