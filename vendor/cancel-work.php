<?php

session_start(); // Начинаем сессию для работы с сессионными переменными

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("../db/db.php"); // Подключаем файл с настройками базы данных

$id_request = $_GET['id_request']; // Получаем id заявки из GET параметра

// Формируем SQL запрос для удаления id мастера из поля id_master
mysqli_query($connect, "UPDATE `requests` SET `id_master` = NULL, `status` = 1 WHERE `id` = '$id_request'");

header("Location: ../index.php");
