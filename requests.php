<?php

session_start();

if(empty($_COOKIE['id_user'])) {
    $_SESSION['errLogin'] = "Авторизуйтесь!";
    header("Location: ./login.php");
}

require_once("./db/db.php"); // Подключаем файл с настройками базы данных

$repair_requests_created = mysqli_query($connect, "SELECT * FROM `requests` WHERE `status` = 1 ORDER BY `id` DESC");
$repair_requests_created = mysqli_fetch_all($repair_requests_created);

$select_all_finish_requests = mysqli_query($connect, "SELECT * FROM `requests` WHERE `status` = 4 ORDER BY `id` DESC");
$select_all_finish_requests = mysqli_fetch_all($select_all_finish_requests);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки на ремонт</title>
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
    <a href="./logout.php">Выйти</a> | <a href="./index.php">На Главную</a>
    <br><br>

    <?php if($_COOKIE['role'] == 1) { ?>
        <h2>Все заявки</h2>
        <?php foreach($repair_requests_created as $request) { 
            if ($request[7] == 1) { ?>
                <ul>
                    <li><strong>Название производителя: </strong> <?= $request[2] ?> </li>
                    <li><strong>Название модели телевизора: </strong> <?= $request[3] ?> </li>
                    <li><strong>Тип подсветки экрана: </strong> <?= $request[4] ?> </li>
                    <li><strong>Диагональ экрана (дюйм): </strong> <?= $request[5] ?> </li>
                    <li><strong>Частота обновления экрана: </strong> <?= $request[6] ?>Гц </li>
                    <?php 
                        $id_master = $_COOKIE['id_user'];
                        $master_ids = explode(',', $request[1]);
                        if (!in_array($id_master, $master_ids)) { ?>
                            <li>
                                <?php 
                                    if($request[7] == 1) { ?>
                                        <a href="./vendor/appoint-request.php?id_request=<?= $request[0] ?>">Откликнуться</a>
                                    <?php }
                                ?>
                            </li>
                        <?php } else {
                            echo "<br> Вы уже откликнулись!";
                        }
                    ?>
                </ul>
                <hr>
            <?php } ?>
        <?php } ?>
    <?php } elseif ($_COOKIE['role'] == 2) { ?>
        <div class="wrapper">
            <div>
                <h2>Созданные заявки на ремонт</h2>
                <?php foreach($repair_requests_created as $request) { ?>
                    <ul>
                        <li><strong>Название производителя: </strong> <?= $request[2] ?> </li>
                        <li><strong>Название модели телевизора: </strong> <?= $request[3] ?> </li>
                        <li><strong>Тип подсветки экрана: </strong> <?= $request[4] ?> </li>
                        <li><strong>Диагональ экрана (дюйм): </strong> <?= $request[5] ?> </li>
                        <li><strong>Частота обновления экрана: </strong> <?= $request[6] ?>Гц </li>
                        <li>
                            <strong>Статус ремонта: </strong> 
                            <?php
                                if($request[7] == 1) {
                                    echo "Ожидание выбора мастера";
                                } elseif($request[7] == 2) {
                                    echo "На утверждении мастера";
                                } elseif($request[7] == 3) {
                                    echo "В работе";
                                } else {
                                    echo "Ремонт окончен";
                                }
                            ?>
                        </li>
                        <li>
                        <?php
                            if($request[7] == 1) { ?>
                                <a href='./vendor/delete-request.php?id_request=<?= $request[0] ?>'>Отменить заявку</a>
                            <?php }
                        ?>
                        </li>
                        <?php 
                            if (!empty($request[1])) {
                                $master_ids = explode(',', $request[1]);
                                $ids_str = implode(',', $master_ids);
                                $select_fullname_master = mysqli_query($connect, "SELECT `id`, `fullname` FROM `users` WHERE `id` IN ($ids_str)"); ?>
                                <li>
                                    <strong>Откликнувшиеся мастера:</strong>
                                    <ul>
                                        <?php while ($row = mysqli_fetch_assoc($select_fullname_master)) { ?>
                                            <li>
                                                <a href="./master.php?id_master=<?= $row['id'] ?>"><?= $row['fullname'] ?></a> | <a href="./vendor/appoint-master.php?id_master=<?= $row['id'] ?>&id_request=<?= $request[0] ?>">Утвердить</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php }
                        ?>
                    </ul>
                    <hr>
                <?php } ?>
            </div>
            <div>
                <h2>Отремонтированные телевизоры</h2>
                <?php foreach($select_all_finish_requests as $request) { ?>
                    <ul>
                        <li><strong>Название производителя: </strong> <?= $request[2] ?> </li>
                        <li><strong>Название модели телевизора: </strong> <?= $request[3] ?> </li>
                        <li><strong>Тип подсветки экрана: </strong> <?= $request[4] ?> </li>
                        <li><strong>Диагональ экрана (дюйм): </strong> <?= $request[5] ?> </li>
                        <li><strong>Частота обновления экрана: </strong> <?= $request[6] ?>Гц </li>
                        <li><strong>Цена за ремонт: </strong> <?= $request[8] ?> Руб.</li>
                        <li>
                            <strong>Мастер выполнивший ремонт: </strong> 
                            <?php 
                                $id_master = $request[1];
                                $select_master = mysqli_query($connect, "SELECT `fullname` FROM `users` WHERE `id`='$id_master'");
                                $select_master = mysqli_fetch_assoc($select_master);
                            ?>

                            <a href="./master.php?id_master=<?= $request[1] ?>"><?= $select_master['fullname'] ?></a>

                        </li>
                    </ul>
                    <hr>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</body>
</html>