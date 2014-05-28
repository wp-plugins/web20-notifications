<?php
$web20_icquid = get_option('web20_icquid');
$web20_icqpassword = get_option('web20_icqpassword');
$web20_icquid_to = get_option('web20_icquid_to');
$web20_jabberjid=get_option('web20_jabberjid');
$web20_jabberassword=get_option('web20_jabberassword');
$web20_jabberjid_to=get_option('web20_jabberjid_to');
$web20_jabberserver=get_option('web20_jabberserver');
$web20_jabberport=get_option('web20_jabberport');
?>
<h2>Настройки сервисов для отправки уведомлений</h2>
<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

    <table class="form-table">
        <h3>Опции для отправки сообщений через сервис ICQ</h3>
        <tr valign="top">
            <th scope="row">icq UID отправителя</th>
            <td>
                <input type="text" name="web20_icquid" value="<?php echo $web20_icquid; ?>" />
                <span class="description">От этого UID будут отправляться сообщения с сайта, зерегистрируйте отдельный UID
                    icq для вашего сайта</span>
            </td>


        </tr>
        <tr valign="top">
            <th scope="row">icq password отправителя</th>
            <td>
                <input type="password" name="web20_icqpassword" value="<?php echo $web20_icqpassword; ?>" />
                <span class="description">Пароль от выше указанной учётной записи</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">icq UID получателя</th>
            <td>
                <input type="text" name="web20_icquid_to" value="<?php echo $web20_icquid_to; ?>" />
                <span class="description">на этот номер icq будут приходить сообщения с сайта</span>
            </td>


        </tr>
    </table>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="web20_icquid, web20_icqpassword, web20_icquid_to" />

    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>

<form method="post">
        <table class="form-table">

        <tr valign="top">
            <th scope="row">Введите текст</th>
            <td>
                <input type="text" name="icq_test_text" value="Текст с сайта" />
                <span class="description">Тестовое сообщение для проверки работы icq уведомлений</span>
            </td>
        </tr>

    </table>
    <p class="submit">
        <input type="submit" name="test_send_icq" class="button-primary" value="Отправить" />
    </p>

</form>


<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

    <table class="form-table">
        <h3>Опции для отправки сообщений через сервис Jabber</h3>
        
        <tr valign="top">
            <th scope="row">Jabber server</th>
            <td>
                <input type="text" name="web20_jabberserver" value="<?php echo $web20_jabberserver; ?>" />
                <span class="description">(пример xmpp.ru)Сервер Jabber на котором находится учётная запись отправителя</span>
            </td>
        </tr>
        
                <tr valign="top">
            <th scope="row">Jabber Порт</th>
            <td>
                <input type="text" name="web20_jabberport" value="<?php echo $web20_jabberport; ?>" />
                <span class="description">(пример 5222)Порт Jabber на котором работает сервер</span>
            </td>
        </tr>

        
        <tr valign="top">
            <th scope="row">Jabber JID отправителя</th>
            <td>
                <input type="text" name="web20_jabberjid" value="<?php echo $web20_jabberjid; ?>" />
                <span class="description">(пример vinogradov)От этого JID будут отправляться сообщения с сайта, зерегистрируйте отдельный JID
                    для вашего сайта</span>
            </td>


        </tr>
        <tr valign="top">
            <th scope="row">JABBER password отправителя</th>
            <td>
                <input type="password" name="web20_jabberassword" value="<?php echo $web20_jabberassword; ?>" />
                <span class="description">Пароль от вашей Jabber учётной записи</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">JID Jabber получателя</th>
            <td>
                <input type="text" name="web20_jabberjid_to" value="<?php echo $web20_jabberjid_to; ?>" />
                <span class="description">(пример vinogradov@xmpp.ru)на этот номер JID будут приходить сообщения с сайта</span>
            </td>


        </tr>
    </table>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="web20_jabberserver, web20_jabberport, web20_jabberjid, web20_jabberassword, 
           web20_jabberjid_to" />

    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>

<form method="post">
        <table class="form-table">

        <tr valign="top">
            <th scope="row">Введите текст</th>
            <td>
                <input type="text" name="jabber_test_text" value="Текст с сайта" />
                <span class="description">Тестовое сообщение для проверки работы Jabber уведомлений</span>
            </td>
        </tr>

    </table>
    <p class="submit">
        <input type="submit" name="test_send_jabber" class="button-primary" value="Отправить" />
    </p>

</form>


<?php
//Отправляем сообщение icq
if(isset($_POST['test_send_icq'])){
    $texticq=$_POST['icq_test_text'];
    Web20icqSender($web20_icquid_to, $texticq, $web20_icquid, $web20_icqpassword);
}
if(isset($_POST['test_send_jabber'])){
    $textjabber=$_POST['jabber_test_text'];
    Web20JabberSender($web20_jabberserver, $web20_jabberport, $web20_jabberjid, $web20_jabberassword, $textjabber, "Web20Plugin", $web20_jabberjid_to);
    //$server, $port, $user, $password, $message, $tema, $touserjid
}

?>
