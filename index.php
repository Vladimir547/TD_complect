<?php
include_once('./Helpers/Utils.php');
include_once("./Router/Router.php");
include_once("./Db/Db.php");
include_once('./Controllers/AuthController.php');

use Router\Router;
use Db\Db;
use Helpers\Utils;
use Controllers\AuthController;

session_start();
$router = new Router();


$router->addRoute('GET', '/', function () {
    include_once("./Views/Pages/main.php");
});
$router->addRoute('GET', '/login', function () {
    if(Utils::checkAuth()) {
        header('Location: /');
    }
    include_once("./Views/Pages/Login.php");
});
$router->addRoute('POST', '/login', function () {
    if(Utils::checkAuth()) {
        echo json_encode(['status'=> 'error', 'message'=>'вы уже авторизованы']);
    } else {
        $auth = new AuthController();
        $auth->login($_POST['login'], $_POST['password']);
    }
});
$router->addRoute('GET', '/logout', function () {
    if(Utils::checkAuth()) {
        unset($_SESSION['user']);
        Utils::redirect('login');
    } else {
        Utils::setFlash('login_error', 'Вы не были зарегистрированы!');
        Utils::redirect('login');
    }
});
$router->addRoute('GET', '/register', function () {
    if(Utils::checkAuth()) {
        header('Location: /');
    }
    include_once("./Views/Pages/Register.php");
});
$router->addRoute('POST', '/register', function () {
//    $auth->register(1,1,1);
    if(Utils::checkAuth()) {
        echo json_encode(['status'=> 'error', 'message'=>'вы уже авторизованы']);
    } else {
        $auth = new AuthController();
        $auth->register($_POST['login'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
    }
});
$router->addRoute('GET', '/blogs/:blogID', function ($blogID) {
    echo "My route is working with blogID => $blogID !";
});

$router->matchRoute();