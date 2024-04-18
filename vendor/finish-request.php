<?php

session_start(); // Начинаем сессию для работы с сессионными переменными

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("../db/db.php"); // Подключаем файл с настройками базы данных

$id_request = $_POST['id_request'];
$price = $_POST['price'];

mysqli_query($connect, "UPDATE `requests` SET `status` = 4, `price` = '$price' WHERE `id` = '$id_request'");

header("Location: ../index.php");
