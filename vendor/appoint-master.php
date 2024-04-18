<?php

session_start(); // Начинаем сессию для работы с сессионными переменными

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("../db/db.php"); // Подключаем файл с настройками базы данных

$id_master = $_GET['id_master'];
$id_request = $_GET['id_request'];

mysqli_query($connect, "UPDATE `requests` SET `id_master`='$id_master', `status` = 2  WHERE `id` = '$id_request'");

header("Location: ../index.php");
