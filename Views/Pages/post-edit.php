<!DOCTYPE html>
<?php

use Helpers\Utils;

include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Partials/head.php');
?>
<body>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Partials/header.php');
?>
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <?php
        if (!empty($rights)) {
            ?>
            <div class="card-header">
                <h1 class="fw-bold text-secondary">Нет доступа</h1>
            </div>
            <?php
        } else {
            ?>
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h1 class="fw-bold text-secondary">Редоктировать пост</h1>
                    </div>
                    <div class="card-body p-5">
                        <?php
                        // отображение ошибок
                        echo Utils::displayFlash('post_edit_error', 'danger');
                        echo Utils::displayFlash('post_edit_success', 'success');
                        if (!empty($post)) {
                            ?>
                            <form action="/post/edit" method="POST" id="posts">
                                <input type="hidden" name="id" id="id" class="form-control" value="<?= $post['id'] ?>"
                                       required>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Название</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="<?= $post['name'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Описание</label>
                                    <textarea type="text" name="description" id="description" class="form-control"
                                              required><?= $post['description'] ?></textarea>
                                </div>
                                <?php
                                if (Utils::isAdmin()) {
                                    ?>
                                    <div class="mb-3">
                                        <select class="form-select" name="status" aria-label="Default select example">

                                            <?php
                                            foreach (\Enums\StatusEnum::cases() as $status) {
                                                ?>
                                                <option value="<?=$status->value?>" <?=$status->value == $post['status'] ? 'selected' : '' ?>><?=$status->value?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="mb-3 d-grid">
                                    <input type="submit" value="Добавить" class="btn btn-primary">
                                </div>
                            </form>
                            <?php
                        } else {
                            echo '<h5>Нет такого поста</h5>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Partials/scripts.php');
?>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        document.querySelector('#posts').addEventListener('submit', async (e) => {
            e.preventDefault();
            let formData = new FormData(document.querySelector('#posts'))
            let response = await fetch("/post/edit/",
                {
                    method: 'POST',
                    body: formData,
                })
            let answer = await response.json();
            if (answer.status) {
                window.location.reload();
            }
        })
    });
</script>
</body>

