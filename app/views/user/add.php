<div style="text-align:center;">
    <?= (!empty($msg)) ? $msg : "" ?>
    <form method="post" action="<?= _WEB_ROOT ?>/home/post_user">
        <input type="text" name="fullname" value="<?= (!empty($old['fullname'])) ? $old['fullname'] : "" ?>" placeholder="input name"><br>
        <?= (!empty($errors['fullname'])) ? "<span style='color:red'>" . $errors['fullname'] . '</span>' : "" ?><br>
        <hr>
        <input type="text" name="email" value="<?= (!empty($old['email'])) ? $old['email'] : "" ?>" placeholder="input email"><br>
        <?= (!empty($errors['email'])) ? "<span style='color:red'>" . $errors['email'] . '</span>' : "" ?><br>
        <hr>
        <input type="password" name="password" value="<?= (!empty($old['password'])) ? $old['password'] : "" ?>" placeholder="input password"><br>
        <?= (!empty($errors['password'])) ? "<span style='color:red'>" . $errors['password'] . '</span>' : "" ?><br>
        <hr>
        <input type="password" name="confirm_password" value="<?= (!empty($old['confirm_password'])) ? $old['confirm_password'] : "" ?>" placeholder="input confirm password"><br>
        <?= (!empty($errors['confirm_password'])) ? "<span style='color:red'>" . $errors['confirm_password'] . '</span>' : "" ?><br>
        <hr>
        <button type="submit">submit</button>
    </form>
</div>