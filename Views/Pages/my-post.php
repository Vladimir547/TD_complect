<!DOCTYPE html>
<?php

use Helpers\Utils;

include_once('./Views/Partials/head.php');
?>
<body>
<?php
include_once('./Views/Partials/header.php');
?>
<div class="container">
    <div class="group">
        <?php
        // отображение ошибок
        echo Utils::displayFlash('post_error', 'danger');
        echo Utils::displayFlash('post_success', 'success');

        ?>
    </div>
    <div class="group mt-5">
        <a href='/my' type="button" class="btn btn-primary">Все</a>
        <a href='/my/published' type="button" class="btn btn-primary">Опубликованые</a>
        <a href='/my/wait' type="button" class="btn btn-primary">На модерации</a>
        <a href='/my/deny' type="button" class="btn btn-primary">Отклонена</a>
    </div>
    <ul class="list-group mt-5">
        <?php
        if (empty($posts)) {
            ?><h2> Нет постов!</h2><?php
        } else {
            foreach ($posts as $post) {
                ?>
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?= $post['name'] ?></h5>
                        <small><?= $post['date'] ?></small>
                    </div>
                    <p class="mb-1"><?= $post['description'] ?></p>
                    <div class="d-flex w-100 align-items-center">
                        <h5 class="mb-1">Статус:</h5>
                        <small><?= $post['status'] ?></small>
                    </div>
                    <a href='/blogs/<?= $post['id'] ?>' type="button" class="btn btn-info">Подробнее</a>
                    <a href='/post/edit/<?= $post['id'] ?>' type="button" class="btn btn-secondary">Редактировать</a>
                    <a href='/post/delete/<?= $post['id'] ?>' type="button" class="btn btn-danger">Удалить</a>
                </li>

                <?php
            }
        }

        ?>
    </ul>
</div>
<?php
include_once('./Views/Partials/scripts.php');
?>

</body>