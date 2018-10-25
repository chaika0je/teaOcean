<?php

class Site
{
    public static function getSearchList($query)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$query%'";
        $products = $db->query($sql);
        $products = $products->fetchAll();
        return $products;
    }

    public static function insertCallback($name, $phone, $message)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO `callback-form`(`name`, `phone`, `message`) VALUES ('$name','$phone','$message')";
        $db->query($sql);
        $SERVER_NAME = $_SERVER['REMOTE_ADDR'];
        $mailMessage = "Имя: $name;<br>Телефон: $phone;<br>Сообщение: $message";

        mail("stas_unitsky@mail.ru", "Tea-Ocean. Обратная связь!", $mailMessage,
            "From: info@$SERVER_NAME\r\n"
            ."Reply-To: info@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion());
    }

    public static function loadPageInfo($page)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `info` WHERE `page` = '$page'";
        $info = $db->query($sql);
        $info = $info->fetch(PDO::FETCH_ASSOC);
        return $info;
    }
}