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
//$users = Db::conn()->prepare('select * from user where login=:login or email=:email');
//$users->execute([
//    'login' => '123',
//    'email' => '123@123',
//]);
//$row = $users->fetchAll(PDO::FETCH_ASSOC);

$router->addRoute('GET', '/', function () {
    echo "Main!";

});
$router->addRoute('GET', '/login', function () {
    include_once("./Views/Pages/Login.php");
});
$router->addRoute('GET', '/logout', function () {
    echo "Logout!";
});
$router->addRoute('GET', '/register', function () {
    include_once("./Views/Pages/Register.php");
});
$router->addRoute('POST', '/register', function () {
//    $auth->register(1,1,1);
        $auth = new AuthController();
        $auth->register($_POST['login'], $_POST['email'], $_POST['password']);
});
$router->addRoute('GET', '/blogs/:blogID', function ($blogID) {
    echo "My route is working with blogID => $blogID !";
});

$router->matchRoute();