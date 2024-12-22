<?php

include("controllers/UserController.php");
include("controllers/TeacherController.php");
include("controllers/NoteController.php");
include("controllers/TableController.php");
include("controllers/StudentDataController.php");

$controller =  htmlspecialchars(trim($_GET['controller']));
$method     =  htmlspecialchars(trim($_GET['action']));

$controllerName = ucfirst($controller) . 'Controller';
$controllerPath = "controllers/"."$controllerName".".php";

if(file_exists($controllerPath)){
    require_once $controllerPath;

    $controllerInstance = new $controllerName();
    if(method_exists($controllerInstance, $method)){
        $controllerInstance->$method();
    }else{
        http_response_code(404);
        die("Error 404: Ruta no encontrada.");
    }
}else{
    http_response_code(404);
    die("Error 404: Ruta no encontrada.");
}



