<?php

class HtmlHelper
{

    public static function formOpen($method = "GET", $action = "")
    {
        echo "<form method='$method' action='$action'>";
    }

    public static function formClose()
    {
        echo "</form>";
    }

    public static function input($wrapBefore = "", $wrapAfter = "", $type = "text", $name, $value = "", $placeholder = "", $class = "", $id = "")
    {
        echo $wrapBefore;
        echo "<input type='$type' name='$name' class='$class' value='$value' id='$id' placeholder='$placeholder' />";
        echo $wrapAfter;
    }

    public static function submit($label, $class = "")
    {
        echo '<button type="submit" class="' . $class . '">' . $label . '</button>';
    }
}
