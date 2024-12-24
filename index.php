<?php
/**
* Inclusión de todos los controladores 
*
*/
#include("controllers/UserController (prueba inicial).php");
#include("controllers/TeacherController (prueba inicial).php");
include("controllers/NoteController.php");
include("controllers/TableController.php");
include("controllers/StudentDataController.php");
include("controllers/ViewerNoteController.php");

try{
    /** 
    * variable para obtener el controlador enviado como parámetro en la URL
    * @var string controlador 
    * @access public 
    */
    $controller =  htmlspecialchars(trim($_GET['controller']));
    /** 
    * variable para obtener el método o acción enviado como parámetro en la URL
    * @var string método
    * @access public 
    */ 
    $method  =  htmlspecialchars(trim($_GET['action']));

    /** 
    * variable para almacenar el nombre exacto del controlador empleado
    * @var string nombre del controlador
    * @access public 
    */ 
    $controllerName = ucfirst($controller) . 'Controller';
    /** 
    * variable para almacenar la construcción de la ruta exacta del controlador a utilizar
    * @var string ruta del controlador
    * @access public 
    */ 
    $controllerPath = "controllers/"."$controllerName".".php";

    # Verificar la existencia de la ruta para incluir el controlador ubicado en ella.
    if(!file_exists($controllerPath)){
        http_response_code(404);
        throw new Exception("Error 404. Ruta no encontrada.", 1);
    } 

    require_once $controllerPath;

    # Instanciar un objeto del controlador a utilizar
    $controllerInstance = new $controllerName();

    # Verificar si existe el método dentro del controlador
    if(!method_exists($controllerInstance, $method)){
        http_response_code(404);
        throw new Exception("Error 404. Ruta no encontrada.", 1);
    }

    $controllerInstance->$method(); # Llamar al método en caso de que exista
    
}catch(\Throwable $th) {
    die("Error. ".$th->getMessage());
}



