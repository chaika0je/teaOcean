<?php

class User
{
    public static function registerUser($name, $mail, $password, $phone)
    {
        $errors = [];

        if (strlen($name) <= 2)
            array_push($errors, "Имя слишком короткое");

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
            array_push($errors, "Невалидный емаил");

        if ($password == '' or $password == null)
            array_push($errors, "Неправильная длинна пароля");

        if (strlen($phone) > 20 or strlen($phone) < 3)
            array_push($errors, "Неправильная длинна номера");

        if (!empty($errors))
        {
            foreach ($errors as $error)
                echo "<br>".$error."<br>";
            echo "<hr>";
            die("Ощибка регистрации"."<a href='/reg'><b>Попробовать снова</b></a>");
        }

        $db = Db::getConnection();
        $sql = "SELECT `e-mail` FROM `customers` WHERE `e-mail` = '$mail'";
        $check = $db->query($sql)->fetchAll();
        //var_dump($check);
        if (isset($check[0]['e-mail']))
            die("Ощибка регистрации, аккаунт с таким e-mail уже существует"."<br><a href='/reg'><b>Попробовать снова</b></a>");


        $sql = "INSERT INTO `customers`(`name`, `e-mail`, `password`, `phone`, `address`) VALUES ('$name','$mail','$password','$phone','-отключено-')";
        $result = $db->query($sql);

        if ($result) {
            $SERVER_NAME = $_SERVER['SERVER_NAME'];
            $message = 'Стас, придумай что должно быть в письме после регистрации';
            mail("$mail", "Tea-Ocean. Спасибо за регистрацию!", $message,
             "From: info@$SERVER_NAME\r\n"
            ."Reply-To: info@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion());
            
            header("Location: /reg/success");
            echo "<script>alert('Аккаунт успешно создан. Теперь авторизуйтесь')</script>";
        }

        return $result;
    }

    public static function authorizeUser($mail, $password)
    {
        $db = Db::getConnection();
        try {
            $user = $db->query("SELECT * FROM `customers` WHERE `e-mail` = '$mail'");
            $user = $user->fetch();
            if($user['password'] != $password)
            {
                echo "<script>alert('Неверный логин или пароль')</script>";
            }
            else {
                try {
                    $_SESSION['user-logged'] = true;
                    $_SESSION['user-id'] = intval($user['id']);
                    $_SESSION['user-name'] = $user['name'];
                    $_SESSION['user-email'] = $user['e-mail'];
                    $_SESSION['user-phone'] = $user['phone'];
                    if ($user['address'] != '-отключено-')
                        $_SESSION['user-address'] = $user['address'];
                    else
                        $_SESSION['user-address'] = '';
                    header("Location: /account");
                }
                catch (ErrorException $exception) {
                    header("Location: /auth");
                    echo "<script>alert('Ошибка авторизации')</script>";
                }
            }
        }
        catch (ErrorException $exception) {
            header("Location: /auth");
            echo "<script>alert('Неверный логин или пароль')</script>";
        }
        return ;
    }

    public static function getLastUserOrders($userID)
    {

        $db = Db::getConnection();
        $sql = "SELECT * FROM `orders` WHERE `customer` = '$userID' LIMIT 8";
        $orders = $db->query($sql);
        $orders = $orders->fetchAll();

        return array_reverse($orders);
    }

    public static function getUserById($userID)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `customers` WHERE `id` = '$userID'";
        $user = $db->query($sql);
        $user = $user->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public static function editUserByHimself($id, $name, $phone, $address)
    {
        $db = Db::getConnection();
        $userInfo = $db->query("SELECT * FROM `customers` WHERE `id` = '$id'")->fetch(PDO::FETCH_ASSOC);
        //echo "check";
        if ($id == $userInfo['id'])
        {
            //echo "check";
            if ($userInfo['id'] == $_SESSION['user-id'])
            {
                //echo "check";
                if ($address == 'address' or $address == '')
                {
                    $address = '-отключено-';
                }
                $id = $_SESSION['user-id'];
                $sql = "UPDATE `customers` SET `name`='$name',`phone`='$phone',`address`='$address' WHERE `id` = '$id'";
                $db->query($sql);

                $_SESSION['user-name'] = $name;
                $_SESSION['user-address'] = $address;
                //echo $sql;
            }
        }
    }
}