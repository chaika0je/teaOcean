<?php

class Cart
{
    public static function deleteProduct($id)
    {
        unset($_SESSION['cart'][$id]);
        header("Location: /cart");
    }
}