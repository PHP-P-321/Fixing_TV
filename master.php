<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php"); // Подключаем файл с настройками базы данных

$id_master = $_GET['id_master'];
$select_master = mysqli_query($connect, "SELECT `id`, `fullname`, `email` FROM `users` WHERE `id`='$id_master'");
$select_master = mysqli_fetch_assoc($select_master);

$select_completed_tasks = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_master`='$'");
$select_completed_tasks = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_master`='$id_master'");
$count_completed_tasks = mysqli_num_rows($select_completed_tasks);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница мастера</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 300px;
        }
    </style>
</head>
<body>
    <a href="./logout.php">Выйти</a>
    <br><br>
    <a href="./requests.php">Назад</a>

    <h2>Профиль мастера - <?= $select_master['fullname'] ?></h2>
    <p>Email мастера - <?= $select_master['email'] ?></p>
    <p>Количество выполненных ремонтов: <?= $count_completed_tasks ?></p>
</body>
</html>