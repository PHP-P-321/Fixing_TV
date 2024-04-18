<?php

session_start(); // Начинаем сессию для работы с сессионными переменными

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
} 

if($_COOKIE['role'] == 1) {
    require_once("../db/db.php"); // Подключаем файл с настройками базы данных

    $id_request = $_GET['id_request'];
    $id_master = $_COOKIE['id_user'];

    $result = mysqli_query($connect, "SELECT `id_master` FROM `requests` WHERE `id` = '$id_request'");
    $row = mysqli_fetch_assoc($result);
    $current_id_master = $row['id_master'];
    $new_id_master = $current_id_master ? $current_id_master . ',' . $id_master : $id_master;
    
    mysqli_query($connect, "UPDATE `requests` SET `id_master` = '$new_id_master' WHERE `id` = '$id_request'");
    
    header("Location: ../index.php");
}

header("Location: ../index.php");
