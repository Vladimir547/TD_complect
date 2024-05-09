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
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <h1 class="fw-bold text-secondary">Регистрация</h1>
                </div>
                <div class="card-body p-5">
                    <?php
                    // Display error message if any
                    echo Utils::displayFlash('register_error', 'danger');
                    ?>
                    <form action="/register" method="POST" id="register">
                        <input type="hidden" name="register" value="1">
                        <div class="mb-3">
                            <label for="login" class="form-label">Логин</label>
                            <input type="text" name="login" id="login" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Почта</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Подтверждение пароля</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                   required>
                        </div>
                        <div class="mb-3 d-grid">
                            <input type="submit" value="Регистрация" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once('./Views/Partials/scripts.php');
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            document.querySelector('#register').addEventListener('submit', async (e) => {
                e.preventDefault();
                let formData = new FormData(document.querySelector('#register'))
                let response = await fetch("/register",
                    {
                        method: 'POST',
                        body: formData,
                    })
                let answer = await response.json();
                if (answer.status === 'error') {
                    window.location.reload();
                } else {
                    window.location.href = '/login';
                }
            })
        });
    </script>
</div>
</body>
