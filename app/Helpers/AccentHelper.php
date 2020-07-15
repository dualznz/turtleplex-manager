<?php

namespace App\Helpers;

class AccentHelper
{
    public static function accent($title, $text_color, $background_color) {
        $i = '<span class="badge" style="background-color: '.$background_color.'; color: '.$text_color.'">'.$title.'</span>';
        return $i;
    }
}
