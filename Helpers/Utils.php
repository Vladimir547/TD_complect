<?php

namespace Helpers;

use Db\Db;
use PDO;
use Enums\RoleEnum;


class Utils
{
    public static function sanitize(string $data): string
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }

    // метод для редиректа
    public static function redirect(string $page): void
    {
        $home_url = $_SERVER['HTTP_HOST'];
        header('location: /' . $page);
    }

    // метод для установки сообщения
    public static function setFlash(string $name, string $message): void
    {
        if (!empty($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
        $_SESSION[$name] = $message;
    }

    //метод для вывода сообщения
    public static function displayFlash(string $name, string $type): void
    {
        if (isset($_SESSION[$name])) {
            echo '<div class="alert alert-' . $type . '">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
        }
    }

    // метод для проверки авторизации пользователя
    public static function isLoggedIn(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function gen_token(): string
    {
        $token = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        return $token;
    }

    public static function existUser(string $login, string $email): bool
    {
        $sql = 'select * from user where login=:login or email=:email';
        $user = Db::conn()->prepare($sql);
        $user->execute([
            'login' => $login,
            'email' => $email,
        ]);
        if ($user->fetchAll(PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
        return true;
    }

    public static function validPassword(string $password): string|bool
    {


        if (strlen($password) < 8) {
            $passwordErr = "Пароль должен содержать больше 8 символов";
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
        $passwordErr = "Пароль должен содержать минимум 1 цифру!";
        }
        elseif(!preg_match("#[A-ZА-Я]+#",$password)) {
        $passwordErr = "Пароль должен содержать минимум 1 заглавную букву!";
        }
        elseif(!preg_match("#[a-zа-я]+#",$password)) {
        $passwordErr = "Пароль должен содержать минимум 1 не заглавную букву!";
        }
        return !empty($passwordErr) ? $passwordErr : true;
    }

    public static function checkAuth (): bool
    {
        if(!empty($_SESSION['user'])) {
            $sql = 'select * from user where id=:id or token=:token';
            $user = Db::conn()->prepare($sql);
            $user->execute([
                'id' => $_SESSION['user']['id'],
                'token' => $_SESSION['user']['token'],
            ]);
            $user = $user->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
    public static function checkRights ($post): bool
    {
        if(!empty($_SESSION['user'])) {
            $sql = 'select * from user where id=:id or token=:token';
            $user = Db::conn()->prepare($sql);
            $user->execute([
                'id' => $_SESSION['user']['id'],
                'token' => $_SESSION['user']['token'],
            ]);
            $user = $user->fetch(PDO::FETCH_ASSOC);
            if ($user['id'] === $post['user_id']) {
                return true;
            } elseif($user['role'] === RoleEnum::ADMIN->value) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
        return false;
    }
    public static function isAdmin (): bool
    {
        $sql = 'select * from user where id=:id or token=:token';
        $user = Db::conn()->prepare($sql);
        $user->execute([
            'id' => $_SESSION['user']['id'],
            'token' => $_SESSION['user']['token'],
        ]);
        $user = $user->fetch(PDO::FETCH_ASSOC);
        if($user['role'] === RoleEnum::ADMIN->value) {
            return true;
        } else {
            return false;
        }

    }
}