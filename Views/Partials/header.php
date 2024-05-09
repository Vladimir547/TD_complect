<?php

use Helpers\Utils;

?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Главная</a>
                </li>
                <?php
                    if(Utils::checkAuth()) {
                        ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Открыть
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/admin">Админка</a>
                                <a class="dropdown-item" href="/my-posts">Мои посты</a>
                                <a class="dropdown-item" href="/logout">Выйти</a>
                            </div>
                        </li>
                        <?php
                    } else {
                        ?>
                            <li class="nav-item active">
                                <a class="nav-link" href="/login">Логин</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="/register">Регистрация</a>
                            </li>
                        <?php
                    }
                ?>

            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <?php
        include_once('./Views/Partials/error-message.php');
    ?>
</div>