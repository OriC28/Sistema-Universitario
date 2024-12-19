<?php

include("controllers/UserController.php");
include("controllers/TeacherController.php");
include("controllers/NoteController.php");
include("controllers/TableController.php");
include("controllers/addNotesController.php");

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



