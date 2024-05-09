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
                        <h1 class="fw-bold text-secondary">Добавить пост</h1>
                    </div>
                    <div class="card-body p-5">
                        <?php
                        // отображение ошибок
                        echo Utils::displayFlash('post_error', 'danger');
                        echo Utils::displayFlash('post_success', 'success');

                        ?>
                        <form action="/post/create" method="POST" id="posts">
                            <div class="mb-3">
                                <label for="name" class="form-label">Название</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea type="text" name="description" id="description" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3 d-grid">
                                <input type="submit" value="Добавить" class="btn btn-primary">
                            </div>
                        </form>
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
            let response = await fetch("/post/create",
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

