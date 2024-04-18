<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php"); // Подключаем файл с настройками базы данных

if($_COOKIE['role'] == 1) {
    $id_master = $_COOKIE['id_user'];
    $select_tv_in_repair = mysqli_query($connect, "SELECT * FROM `requests` WHERE `id_master` = '$id_master' AND `status` != 3");
    $select_tv_in_repair = mysqli_fetch_all($select_tv_in_repair);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
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

    <?php if($_COOKIE['role'] == 1) { ?>
        <a href="./requests.php">Все заявки на ремонт</a>
        <h2>Телевизоре в ремонте</h2>
        <?php 
            var_dump($select_tv_in_repair);
        ?>
    <?php } elseif ($_COOKIE['role'] == 2) { ?>
        <a href="./requests.php">Мои заявки</a>
        <br>
        <h2>Создать заявку на ремонт</h2>
        <form action="./vendor/create-request.php" method="post">
            <input type="text" name="company_name" placeholder="Название производителя" required>
            <input type="text" name="model_name" placeholder="Название модели телевизора" required>
            <input type="text" name="type_of_backlight" placeholder="Тип подсветки экрана" required>
            <input type="text" name="screen_diagonal" placeholder="Диагональ экрана (дюйм)" required>
            <input type="text" name="screen_refresh_rate" placeholder="Частота обновления экрана" required>
            <input type="submit" value="Создать">
        </form>
    <?php } ?>
</body>
</html>