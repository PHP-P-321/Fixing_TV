<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php"); // Подключаем файл с настройками базы данных

if($_COOKIE['role'] == 1) {
    $id_master = $_COOKIE['id_user'];
    $select_tv_in_repair = mysqli_query($connect, "SELECT * FROM `requests` WHERE FIND_IN_SET('$id_master', `id_master`) AND `status` >= 3 AND `status` < 4");
    $select_tv_in_repair = mysqli_fetch_all($select_tv_in_repair);

    $select_tv_before_repair = mysqli_query($connect, "SELECT * FROM `requests` WHERE FIND_IN_SET('$id_master', `id_master`) AND `status` = 2");
    $select_tv_before_repair = mysqli_fetch_all($select_tv_before_repair);
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
        .wrapper {
            display: flex;
            justify-content: space-between;
        }
        .wrapper > div:first-child {
            width: 400px;
        }
    </style>
</head>
<body>
    <a href="./logout.php">Выйти</a>
    <br><br>

    <?php if($_COOKIE['role'] == 1) { ?>
        <a href="./requests.php">Все заявки на ремонт</a>
        <div class="wrapper">
            <div>
                <h2>Телевизоре в ремонте</h2>
                <?php 
                    foreach($select_tv_in_repair as $tv) { ?>
                        <ul>
                            <li><strong>Название производителя: </strong> <?= $tv[2] ?> </li>
                            <li><strong>Название модели телевизора: </strong> <?= $tv[3] ?> </li>
                            <li><strong>Тип подсветки экрана: </strong> <?= $tv[4] ?> </li>
                            <li><strong>Диагональ экрана (дюйм): </strong> <?= $tv[5] ?> </li>
                            <li><strong>Частота обновления экрана: </strong> <?= $tv[6] ?>Гц </li>
                        </ul>
                        <form action="./vendor/finish-request.php" method="post">
                            <input type="hidden" name="id_request" value="<?= $tv[0] ?>">
                            <input type="text" name="price" placeholder="Цена за ремонт" required>
                            <input type="submit" value="Закончить ремонт">
                        </form>
                    <?php } ?>
            </div>
            <div>
                <h2>Телевизоры на утверждение ремонта</h2>
                <?php 
                    foreach($select_tv_before_repair as $tv) { ?>
                        <ul>
                            <li><strong>Название производителя: </strong> <?= $tv[2] ?> </li>
                            <li><strong>Название модели телевизора: </strong> <?= $tv[3] ?> </li>
                            <li><strong>Тип подсветки экрана: </strong> <?= $tv[4] ?> </li>
                            <li><strong>Диагональ экрана (дюйм): </strong> <?= $tv[5] ?> </li>
                            <li><strong>Частота обновления экрана: </strong> <?= $tv[6] ?>Гц </li>
                            <li><a href="./vendor/appoint-work.php?id_request=<?= $tv[0] ?>">Утвердить ремонт</a></li>
                            <li><a href="./vendor/cancel-work.php?id_request=<?= $tv[0] ?>">Отказаться от ремонта</a></li>
                        </ul>
                    <?php } ?>
            </div>
        </div>
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