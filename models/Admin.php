<?php

class Admin
{
    public static function login($login, $password)
    {
        $db = Db::getConnection();
        try {
            $user = $db->query("SELECT * FROM `users` WHERE `email` = '$login' AND `password` = '$password' LIMIT 1");
            if($user == false)
                die("Ошибка авторизации!");
            else {
                try {
                    $user = $user->fetch(PDO::FETCH_ASSOC);
                    if($user['admin'] == 1) {
                        $_SESSION['logged'] = true;
                        $_SESSION['admin'] = true;
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['id'] = $user['id'];
                        header("Location: /panel");
                    } else {
                        die("Ошибка авторизации!");
                    }
                }
                catch (ErrorException $exception) {
                    die("Ошибка авторизации!");
                }
            }
        }
        catch (ErrorException $exception) {
            die("Ошибка авторизации!");
        }
        return true;
    }

    public static function addCategory($name, $description)
    {
        $db = Db::getConnection();
        $result = $db->query("INSERT INTO `categories`(`name`, `description`) VALUES ('$name', '$description')");

        return $result;
    }

    public static function addSubcategory($name, $description, $inCategory)
    {
        $db = Db::getConnection();
        $result = $db->query("INSERT INTO `subcategories`(`name`, `description`, `in-category`) VALUES ('$name','$description','$inCategory')");

        return $result;
    }

    public static function addProduct($name, $description, $price, $inCategory, $inSubcategory, $typeProduct, $art, $gr, $tp, $tm, $radius, $section)
    {

        $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");

        foreach ($blacklist as $item)
            if(preg_match("/$item\$/i", $_FILES['product-img']['name']))
                exit("Ошибка загрузки товара");

        $type = $_FILES['product-img']['type'];

        $fileName = $_FILES['product-img']['name'];

        if (($type != "image/jpg") && ($type != "image/jpeg"))
            exit("Ошибка загрузки товара");

        $image = ROOT."/upload/images/".$_FILES['product-img']['name'];

        move_uploaded_file($_FILES['product-img']['tmp_name'], $image);

        $newName = "";
        $alpha = "_QqWwEeRr1TtY2yU3uI5iO4oP6pA7aS8sD9d0FfGgHhJjKkLlZzXxCcVvBbNnMm-";
        for ($i = 0; $i != 12; $i++)
            $newName = $newName.$alpha[rand(0, strlen($alpha)-1)];


        rename(ROOT."/upload/images/".$fileName, ROOT."/upload/images/".$newName.".jpg");

        $image = "/upload/images/".$newName.".jpg";

        $db = Db::getConnection();
        $result = $db->query("
                              INSERT INTO `products`
                              (`name`, `description`, `price`, `image`, `in-category`, `in-sub-category`, `type`, `art`, `degree`, `time`, `grams`, `picType`, `in-section`) 
                              VALUES 
                              ('$name','$description','$price','$image','$inCategory','$inSubcategory', '$typeProduct', '$art', '$tp', '$tm', '$gr', '$radius', '$section')
                            ");

        return $result;
    }

    public static function delProduct($id)
    {
        $db = Db::getConnection();
        $db->query("DELETE FROM `products` WHERE `id` = $id");
    }
    
    public static function sendMailToAllUsers($message)
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT `e-mail` FROM `customers`");
        $mails = $result->fetchAll(PDO::FETCH_ASSOC);
        $SERVER_NAME = $_SERVER['SERVER_NAME'];
        foreach($mails as $mail)
        {
            $reciver = $mail['e-mail'];
            mail("$reciver", "Tea-Ocean. Вас посетила рассылка!", $message,
             "From: info@$SERVER_NAME\r\n"
            ."Reply-To: info@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion());
        }
    }
    
    public static function sendMailToSomeUser($message, $to)
    {
        $SERVER_NAME = $_SERVER['SERVER_NAME'];
        mail("$to", "Tea-Ocean. Вас посетила рассылка!", $message,
             "From: info@$SERVER_NAME\r\n"
            ."Reply-To: info@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion());
    }

    public static function updateProduct($id, $name, $description, $price, $art, $GR, $TP, $TM, $typePic)
    {
        $db = Db::getConnection();
        $db->query("UPDATE `products` SET `name`='$name',`description`='$description',`price`='$price', `degree`='$TP',`time`='$TM',`grams`='$GR',`art`='$art', `picType` = '$typePic' WHERE `id` = $id");
    }

    public static function getAllOrders()
    {
        $db = Db::getConnection();

        $orders = $db->query("SELECT * FROM `orders` ORDER BY `orders`.`id` DESC");
        $orders = $orders->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    }

    public static function updatePage($vars)
    {
        $page = array_shift($vars);

        $sqlString = '';

        foreach ($vars as $key => $var)
        {
            $sqlString = $sqlString . "`$key` = \"".htmlspecialchars($var)."\",";
        }

        $sqlString = substr($sqlString, 0, -1);

        $sql = "UPDATE `info` SET ".$sqlString." WHERE `page` = '$page'";

        $db = Db::getConnection();
        $db->query($sql);
    }

    public static function getOrderByID($id)
    {
        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM `orders` WHERE `id` = '$id'");

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateOrder($vars)
    {
        $id = array_shift($vars);

        $sqlString = '';

        foreach ($vars as $key => $var)
        {
            $sqlString = $sqlString . "`$key` = \"".htmlspecialchars($var)."\",";
        }

        $sqlString = substr($sqlString, 0, -1);

        $sql = "UPDATE `orders` SET ".$sqlString." WHERE `id` = '$id'";

        $db = Db::getConnection();
        $db->query($sql);
    }

    public static function loadCallbacks()
    {
        $db = Db::getConnection();
        $callbacks = $db->query("SELECT * FROM `callback-form`");

        return $callbacks->fetchAll(PDO::FETCH_ASSOC);
    }
}