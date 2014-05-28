<?php
$web20_notification = get_option('web20_notification');
?>

<h2>Настройки расширяющие способы уведомлений</h2>



<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

    <table class="form-table">
        <h3>Варианты уведомлений и способов уведомлений</h3>
        <tr valign="top">
            <th scope="row">Комментарии</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="comments1" <?php echo Web20Checkbox_verify($web20_notification, "comments1"); ?> />
                <span class="description">Уведомлять ли о новых комментариях?</span>
            </td>


        </tr>
        <tr valign="top">
            <th scope="row">Черновики</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="postdraft2" <?php echo Web20Checkbox_verify($web20_notification, "postdraft2"); ?> />
                <span class="description">Уведомлять ли о новых черновиках в записях?</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Публикация</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="postpublic2" <?php echo Web20Checkbox_verify($web20_notification, "postpublic2"); ?> />
                <span class="description">Уведомлять ли о новых публикациях?</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Входы пользователя</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="userlogon3" <?php echo Web20Checkbox_verify($web20_notification, "userlogon3"); ?>/>
                <span class="description">Уведомлять ли о удачных входах пользователей?</span>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Уведомлять меня через ICQ</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="notificationicq6" <?php echo Web20Checkbox_verify($web20_notification, "notificationicq6"); ?>/>
                <span class="description">Включить уведомление через ICQ сервис?</span>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Уведомлять меня через Jabber</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="notificationjabber7" <?php echo Web20Checkbox_verify($web20_notification, "notificationjabber7"); ?>/>
                <span class="description">Включить уведомление через Jabber сервис?</span>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Удалять настройки при диактивации плагина?</th>
            <td>
                <input type="checkbox" name="web20_notification[]" value="notification_noactiveplugin" <?php echo Web20Checkbox_verify($web20_notification, "notification_noactiveplugin"); ?>/>
                <span class="description">Если выбранно, то при диактивации плагина будут удаленны настройки из базы данных Wordpress, ставте галочку
                если планируете больше не возвращаться к этому плагину</span>
            </td>
        </tr>

    </table>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="web20_notification" />

    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>



<?php






