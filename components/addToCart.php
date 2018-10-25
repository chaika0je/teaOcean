<?php
session_start();

if (isset($_SESSION['cart'])) {
    array_push($_SESSION['cart'], array(
            'id' => htmlspecialchars($_POST['id']),
            'name' => htmlspecialchars($_POST['name']),
            'price' => htmlspecialchars($_POST['price']),
            'grams' => htmlspecialchars($_POST['gr']),
            'count' => htmlspecialchars($_POST['cn']),
            'image' => htmlspecialchars($_POST['image']),
        )
    );
} else {
    $_SESSION['cart'] = array(
        array(
            'id' => htmlspecialchars($_POST['id']),
            'name' => htmlspecialchars($_POST['name']),
            'price' => htmlspecialchars($_POST['price']),
            'grams' => htmlspecialchars($_POST['gr']),
            'count' => htmlspecialchars($_POST['cn']),
            'image' => htmlspecialchars($_POST['image']),
        )
    );
}