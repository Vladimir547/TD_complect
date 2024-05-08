<?php
include("./Router/Router.php");
include("./Db/Db.php");

use Router\Router;
use Db\Db;

session_start();
$router = new Router();
$users = Db::conn()->prepare('SELECT * FROM user');
$users->execute();
$row = $users->fetchAll(PDO::FETCH_ASSOC);
var_dump($_SESSION['test']);

$router->addRoute('GET', '/', function () {
    echo "My route is working!";
});
$router->addRoute('GET', '/login', function () {
    echo "Login!";
});
$router->addRoute('GET', '/logout', function () {
    echo "Logout!";
});
$router->addRoute('GET', '/register', function () {
    echo "Register!";
});
$router->addRoute('GET', '/blogs/:blogID', function ($blogID) {
    echo "My route is working with blogID => $blogID !";
});

$router->matchRoute();