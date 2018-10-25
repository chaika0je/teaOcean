<?php

class OrderController
{
    public function actionOrder()
    {
        if (isset($_POST['make-order']))
        {
            Order::makeOrder();
            $_SESSION['cart'] = [];
            $_SESSION['cart-cost'] = '';
            header('Location: /cart/success');
        }

        if (isset($_POST['total']))
        {
            //echo $_POST['total'];
            //echo  json_encode($_SESSION['cart'], JSON_UNESCAPED_UNICODE);
            //var_dump(json_decode(json_encode($_SESSION['cart'], JSON_UNESCAPED_UNICODE),true));
            //include_once (ROOT.'/views/order/main.php');
        }
        else
            header("Location: /cart/success");
        return true;
    }
}