<?php

class Order
{
    public static function makeOrder()
    {
        $customer = $_SESSION['user-id'];
        $date = date("d.m.Y / H:i", strtotime("+3 hours"));
        $address = FormHandler::prepareInput($_POST['address']);
        $price = $_POST['payment'];
        $status = 'Ждет подтверждения';
        $products = json_encode($_SESSION['cart'], JSON_UNESCAPED_UNICODE);
        $customerPhone = FormHandler::prepareInput($_POST['phone']);
        $sql = "
        INSERT INTO `orders`
        (`customer`, `date`, `address`, `price`, `status`, `products`, `customer-phone`) 
        VALUES 
        ('$customer','$date','$address','$price','$status','$products','$customerPhone')   
        ";
        $db = Db::getConnection();
        $db->query($sql);

        $SERVER_NAME = $_SERVER['SERVER_NAME'];

        mail("stas_unitsky@mail.ru", "Tea-Ocean. ЕСТЬ ЗАКАЗ!", "Стас, проверь заказы",
        "From: info@$SERVER_NAME\r\n"
        ."Reply-To: info@$SERVER_NAME\r\n"
        ."X-Mailer: PHP/" . phpversion());

        mail("".$_SESSION['user-email']."", "Tea-Ocean. Ваш заказ!", "Вы чото заказали, ждите звонка",
            "From: info@$SERVER_NAME\r\n"
            ."Reply-To: info@$SERVER_NAME\r\n"
            ."X-Mailer: PHP/" . phpversion());
    }
}