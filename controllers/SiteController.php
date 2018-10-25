<?php

class SiteController
{

    public function actionIndex()
    {
        // Список последних товаров
        $products = Catalog::getRandomProducts(3);

        $info = Site::loadPageInfo('main');

        if (isset( $_POST['send-callback']))
        {
            $name = FormHandler::prepareInput($_POST['name']);
            $phone = FormHandler::prepareInput($_POST['phone']);
            $message = FormHandler::prepareInput($_POST['message']);
            Site::insertCallback($name,$phone,$message);
        }

        require_once(ROOT . '/views/site/main.php');
        return true;
    }

    public function actionRegister()
    {
        if (isset($_SESSION['user-logged']))
            if($_SESSION['user-logged'] == true)
                header("Location: /account");

        if (isset($_POST['submit']))
        {
            $name = FormHandler::prepareInput($_POST['name']);
            $mail = FormHandler::prepareInput($_POST['mail']);
            $password = FormHandler::preparePassword($_POST['pwd']);
            $phone = FormHandler::prepareInput($_POST['phone']);

            User::registerUser($name,$mail,$password,$phone);
        }

        require_once(ROOT . '/views/register/main.php');
        return true;
    }

    public function actionAuth()
    {
        if (isset($_SESSION['user-logged']))
            if($_SESSION['user-logged'] == true)
                header("Location: /account");

        if (isset($_POST['submit']))
        {
            $mail = FormHandler::prepareInput($_POST['mail']);
            $password = FormHandler::preparePassword($_POST['pwd']);

            User::authorizeUser($mail, $password);
        }

        require_once(ROOT . '/views/auth/main.php');
        return true;
    }

    public function actionAccount()
    {
        if (!isset($_SESSION['user-logged']) or $_SESSION['user-logged'] == false)
            header("Location: /auth");

        $lastOrders = User::getLastUserOrders($_SESSION['user-id']);

        if (isset($_POST['change']))
        {
            User::editUserByHimself(FormHandler::prepareInput($_POST['id']), FormHandler::prepareInput($_POST['name']), FormHandler::prepareInput($_POST['phone']), FormHandler::prepareInput($_POST['address']));
        }

        require_once(ROOT . '/views/account/main.php');
        return true;
    }

    public function actionSearch()
    {
        $products = Site::getSearchList(trim(htmlspecialchars($_POST['searchQuery'])));
        //var_dump($products);


        require_once(ROOT . '/views/search/main.php');
        return true;
    }

    public function actionSuccessReg()
    {
        require_once (ROOT.'/views/register/success.php');
        return true;
    }

    public function actionDelivery()
    {
        $info = Site::loadPageInfo('delivery');

        require_once(ROOT . '/views/delivery/main.php');
        return true;
    }
}

