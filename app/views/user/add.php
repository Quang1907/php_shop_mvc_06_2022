<div style="text-align:center;">
    <?php
    HtmlHelper::formOpen('post', _WEB_ROOT . "/home/post_user");
    HtmlHelper::input('<div>', '<br>' . form_error('fullname', "<span style='color:red'>", "</span>") . '</div>', "text", 'fullname', old('fullname'), 'input name', '', '');
    HtmlHelper::input("<div>", "<br>" . form_error('age', "<span style='color:red'>", "</span>") . "</div>", 'number', 'age', old('age'), 'input age', "", "");
    HtmlHelper::input("<div>", "<br>" . form_error('email', "<span style='color:red'>", "</span>") . "</div>", 'text', 'email', old('email'), 'input email', "", "");
    HtmlHelper::input("<div>", "<br>" . form_error('password', "<span style='color:red'>", "</span>") . "</div>", 'password', 'password', old('password'), 'input password', "", "");
    HtmlHelper::input("<div>", "<br>" . form_error('password', "<span style='color:red'>", "</span>") . "</div>", 'password', 'confirm_password', old('confirm_password'), 'input confirm password', "", "");
    HtmlHelper::submit('submit');
    HtmlHelper::formClose();
    ?>
</div>

<!-- 
<input type="text" name="fullname" value="<?php old('fullname') ?>" placeholder="input name"><br>
    -->