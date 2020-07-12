<?php

namespace App\Helpers;

class BlogHelpers
{

    public static function custom_echo($x, $length) {
        if (mb_strlen($x, 'utf8') > $length) {
            $last_space = strrpos(substr($x, 0, $length), ' ');
            return $x = substr($x, 0, $last_space) . '...';
        }
        return $x;
    }

    public static function title($title) {
        // Lower case everything
        $title = strtolower($title);
        // Make alphanumeric (removes all other characters)
        $title = preg_replace("/[^a-z0-9_\s-]/", "", $title);
        // Clean up multiple dashes or whitespaces
        $title = preg_replace("/[\s-]+/", " ", $title);
        // Convert whitespaces and underscore to dash
        $title = preg_replace("/[\s_]/", "-", $title);
        return $title;
    }

    public static function url($id, $title) {
        // Lower case everything
        $title = strtolower($title);
        // Make alphanumeric (removes all other characters)
        $title = preg_replace("/[^a-z0-9_\s-]/", "", $title);
        // Clean up multiple dashes or whitespaces
        $title = preg_replace("/[\s-]+/", " ", $title);
        // Convert whitespaces and underscore to dash
        $title = preg_replace("/[\s_]/", "-", $title);
        return $title .  '.' . $id;
    }
}