<?php

session_start(); // Начинаем сессию для работы с сессионными переменными

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("../db/db.php"); // Подключаем файл с настройками базы данных

$company_name = $_POST['company_name']; // Получаем Название компании из формы
$model_name = $_POST['model_name']; // Получаем Название модели из формы
$type_of_backlight = $_POST['type_of_backlight']; // Получаем Тип подсветки из формы
$screen_diagonal = $_POST['screen_diagonal']; // Получаем Диагональ из формы
$screen_refresh_rate = $_POST['screen_refresh_rate']; // Получаем Частоту обновление экрана из формы

mysqli_query($connect, "INSERT INTO `requests`
                        (`company_name`, `model_name`, `type_of_backlight`, `screen_diagonal`, `screen_refresh_rate`, `status`)
                        VALUES
                        ('$company_name', '$model_name', '$type_of_backlight', '$screen_diagonal', '$screen_refresh_rate', 1)
");

header("Location: ../index.php");
