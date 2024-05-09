<!DOCTYPE html>
<?php

use Helpers\Utils;

include_once('./Views/Partials/head.php');
?>
<body>
<?php
    include_once('./Views/Partials/header.php');
?>
<body class="bg-dark bg-gradient">
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header">
                    <h1 class="fw-bold text-secondary">Login</h1>
                </div>
                <div class="card-body p-5">
                    <?php
                    // Display flash messages
                    echo Utils::displayFlash('register_success', 'success');
                    echo Utils::displayFlash('login_error', 'danger');

                    ?>
                    <form action="/login" method="POST" id="login__form">
                        <div class="mb-3">
                            <label for="email" class="form-label">Логин</label>
                            <input type="text" name="login" id="login" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3 d-grid">
                            <input type="submit" value="Login" class="btn btn-primary">
                        </div>
                        <p class="text-center">Нет логина? <a href="/register.php">Регистрация</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once('./Views/Partials/scripts.php');
?>
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        document.querySelector('#login__form').addEventListener('submit', async (e) => {
            e.preventDefault();
            let formData = new FormData(document.querySelector('#login__form'))
            let response  = await fetch("/login",
                {
                    method: 'POST',
                    body: formData,
                })
            let answer = await response.json();
            if(answer.status === 'error') {
                console.log('err')
                window.location.reload();
            } else  {
                window.location.href = '/';
            }
        })
    });
</script>
</body>
