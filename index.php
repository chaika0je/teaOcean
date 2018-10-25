<?php

// Общие настройки
define('ROOT', dirname(__FILE__));
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();

if (!(preg_match('/^[-,a-zA-Z0-9]{1,128}$/', session_id()) > 0))
    session_regenerate_id();


// Подключение файлов системы
require_once(ROOT.'/components/Autoload.php');


// Вызов Router
$router = new Router();
$router->run();
