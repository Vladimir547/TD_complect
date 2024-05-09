<?php
include_once('./Helpers/Utils.php');
include_once("./Router/Router.php");
include_once("./Db/Db.php");
include_once('./Controllers/AuthController.php');
include_once('./Controllers/PostsController.php');
include_once('./Enums/StatusEnum.php');
include_once('./Enums/RoleEnum.php');

use Enums\RoleEnum;
use Enums\StatusEnum;
use Router\Router;
use Db\Db;
use Helpers\Utils;
use Controllers\AuthController;
use Controllers\PostsController;

session_start();
$router = new Router();


$router->addRoute('GET', '/', function () {
    $posts = new PostsController();
    $posts = $posts->show();
    include_once("./Views/Pages/main.php");
});
$router->addRoute('GET', '/my', function () {
    $posts = new PostsController();
    $posts = $posts->getMy();
    include_once("./Views/Pages/my-post.php");
});
$router->addRoute('GET', '/my/:status', function ($status) {
    $posts = new PostsController();
    $posts = $posts->getMy($status);
    include_once("./Views/Pages/my-post.php");
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
    $post = new PostsController();
    $post = $post->getOne((int) $blogID);
    $rights = null;
    if ($post && !Utils::checkAuth() && $post['status'] != StatusEnum::PUBLISHED->value) {
        $rights = 'Нет доступа!';
    }
    if ($post && Utils::checkAuth() && $post['status'] != StatusEnum::PUBLISHED->value && !Utils::checkRights($post)) {
        $rights = 'Нет доступа!';
    }
    include_once("./Views/Pages/post.php");
});

$router->matchRoute();