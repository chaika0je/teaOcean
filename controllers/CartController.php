<?php

class CartController
{
    public function actionCart()
    {
        require_once(ROOT . '/views/cart/main.php');
        return true;
    }

    public function actionDelFromCart($id)
    {
        Cart::deleteProduct($id);
        return true;
    }

    public function actionSuccess()
    {
        require_once ROOT.'/views/cart/success.php';
        return true;
    }

}