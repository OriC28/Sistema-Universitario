<?php

include("controllers/UserController.php");
include("controllers/TeacherController.php");
include("model/UserTest.php");

$user = new User();
#$user->insertUser();
#$user->personalData();
#$user->updateEmail("orianacolina@gmail.com");
$user->updatePhone("04246438485");


$controller = $_GET['controller'];
$method = $_GET['action'];

$controllerName = ucfirst($controller) . 'Controller';
$controllerPath = "controllers/"."$controllerName".".php";

if(file_exists($controllerPath)){
    require_once $controllerPath;

    $controllerInstance = new $controllerName();
    if(method_exists($controllerInstance, $method)){
        $controllerInstance->$method();
    }else{
        echo "No se encontró el método $method";
    }

}else{
    echo "No se encontró el controlador $controllerName";
}



