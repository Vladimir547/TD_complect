<!DOCTYPE html>
<?php

use Helpers\Utils;

include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Partials/head.php');
?>
<body>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Partials/header.php');
?>
<div class="container">
    <ul class="list-group mt-5">
        <?php
        if (empty($post)) {
            ?><h1> Нет такого поста!</h1><?php
        } elseif (!empty($rights)) {
            ?><h1> Нет доступа!</h1><?php
        } else {
            ?>
            <h1 class="h2"><?=$post['name']?></h1>
            <p><?=$post['description']?></p>
            <p> Дата: <span class="text-info"><?=$post['date']?></span></p>
            <p> Автор: <span class="text-secondary"><?=$post['author']?></span></p>
            <p>Thanks! <span class="text-danger">♥</span></p>
            <?php
        }

        ?>
    </ul>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Partials/scripts.php');
?>

</body>

