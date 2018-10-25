<?php

class FormHandler
{
    public static function prepareInput($text)
    {
        $text = htmlspecialchars($text);
        $text = trim($text);

        return $text;
    }

    public static function preparePassword($text)
    {
        $text = md5($text);

        return $text;
    }
}