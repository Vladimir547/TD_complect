<?php

namespace Controllers;

use Db\Db;
use Helpers\Utils;
use PDO;
use Enums\RoleEnum;


class AuthController
{
    /**
     * регистрация
     *
     * @params $name, $email, $password, $confirm_password
     *
     *  @return void
     */
    public function register($name, $email, $password, $confirm_password)
    {
        $login = Utils::sanitize($name);
        $email = Utils::sanitize($email);
        $password = Utils::sanitize($password);
        $confirm_password = Utils::sanitize($confirm_password);
        $data = ['status' => 'success'];
        $validate = Utils::validPassword($_POST['password']);
        // валидация
        if ($validate != 1) {
            Utils::setFlash('register_error', $validate);
            $data['status'] = 'error';
            echo json_encode($data);
            return;
        }
        // проверка на совпадение пароля
        if ($password !== $confirm_password) {
            Utils::setFlash('register_error', 'Пароли не совпадают!');
            $data['status'] = 'error';
            echo json_encode($data);
        } else {
            $userExist = Utils::existUser($login, $email);
            $auth = new AuthController();
            // проверка на существование такого пользолвателя
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
                    'role' => RoleEnum::USER->value,
                ]);
                Utils::setFlash('register_success', 'Ты зарегестрирован, можешь логинится!');
                echo json_encode($data);
            }
        }
    }
    /**
     * логин
     *
     * @params $login, $password
     *
     *  @return void
     */
    public function login($login, $password)
    {

        $login = Utils::sanitize($login);
        $password = Utils::sanitize($password);
        $data = ['status' => 'success'];
        $sql = 'SELECT * FROM user WHERE login = :login';
        $stmt = Db::conn()->prepare($sql);
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // есть ди такой пользователь
        if ($user) {
            // проверка пароля
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
                $data['status'] = 'error';
                echo json_encode($data);
            }
        } else {
            Utils::setFlash('login_error', 'Такого пользователся нет!');
            $data['status'] = 'error';
            echo json_encode($data);
        }
    }
}