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
    <ul class="list-group mt-5">
        <?php
        if(empty($posts)) {
            ?><h2> Нет опубликованных постов!</h2><?php
        } else {
            foreach ($posts as $post) {
                ?>
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?=$post['name']?></h5>
                        <small><?=$post['date']?></small>
                    </div>
                    <p class="mb-1"><?=$post['description']?></p>
                    <a href='/blogs/<?=$post['id']?>' type="button" class="btn btn-info">Подробнее</a>
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
