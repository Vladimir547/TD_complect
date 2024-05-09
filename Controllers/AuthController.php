<?php

namespace Controllers;

use Db\Db;
use Helpers\Utils;


class AuthController
{
    public function register($name, $email, $password) {
        $login = Utils::sanitize($_POST['login']);
        $email = Utils::sanitize($_POST['email']);
        $password = Utils::sanitize($_POST['password']);
        $confirm_password = Utils::sanitize($_POST['confirm_password']);
        $data = ['status'=> 'success'];
        $validate = Utils::validPassword($_POST['password']);
        if ($validate != 1) {
            Utils::setFlash('register_error', $validate);
            $data['status'] = 'error';
            echo json_encode($data);
            return;
        }

        if ($password !== $confirm_password) {
            Utils::setFlash('register_error', 'Пароли не совпадают!');
            $data['status'] = 'error';
            echo json_encode($data);
        } else {
            $userExist = Utils::existUser($login ,$email);
            $auth = new AuthController();

            if ($userExist) {
                Utils::setFlash('register_error', 'Юзер с таким логином и паролем уже существует!');
                $data['status'] = 'error';
                echo json_encode($data);
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = 'INSERT INTO user (login, email, password, role) VALUES (:login, :email, :password, :role)';
                $stmt = Db::conn()->prepare($sql);
                $stmt->execute([
                    'login' => $name,
                    'email' => $email,
                    'password' => $hashed_password,
                    'role' => 'user',
                ]);
                Utils::setFlash('register_success', 'Ты зарегестрирован, можешь логинится!');
                echo json_encode($data);
            }
        }
    }
}