<?php

namespace Controllers;

use Db\Db;
use Helpers\Utils;
use PDO;


class AuthController
{
    public function register($name, $email, $password, ) {
        $login = Utils::sanitize($name);
        $email = Utils::sanitize($email);
        $password = Utils::sanitize($password);
        $confirm_password = Utils::sanitize($confirm_password);
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

    public function login($login, $password) {

        $login = Utils::sanitize($login);
        $password = Utils::sanitize($password);
        $data = ['status'=> 'success'];
        $sql = 'SELECT * FROM user WHERE login = :login';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $token = Utils::gen_token();
                $sql = 'UPDATE user SET token = :token WHERE id = :id';
                $stmt = Db::conn()->prepare($sql);
                $stmt->execute([
                    'id' => $user['id'],
                    'token' => $token,
                ]);
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'login' => $user['login'],
                    'token' => $token];
                echo json_encode($data);
            } else {
                Utils::setFlash('login_error', 'Пароли не совподают!');
//                var_dump(1);
                $data['status'] = 'error';
                echo json_encode($data);
            }
        } else {
//            var_dump(2);
            Utils::setFlash('login_error', 'Такого пользователся нет!');
            $data['status'] = 'error';
            echo json_encode($data);
        }
    }
}