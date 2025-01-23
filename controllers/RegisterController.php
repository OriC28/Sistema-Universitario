<?php

require_once 'model/RegisterModel.php'; 
require_once 'model/User.php';

class RegisterController{
    private $model;

    public function __construct(){
        $this->model = new RegisterModel();
    }
    
    private function validateData(array $data): bool{
        if($_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['submit']){
            throw new Exception("No se ha enviado ninguna petición.", 1);
        }
        foreach ($data as $param){
            if(!isset($_POST[$param]) && empty($_POST[$param])){
                throw new Exception("Al menos un campo del formulario se encuentra vacío.", 1);
            }
        }
        return true;
    }

    public function signup(){
        $data = ['cedula', 'primer-nombre','segundo-nombre', 'primer-apellido', 'segundo-apellido', 'password', 'confirm_password'];
        if($this->validateData($data)){
            $user = new User($_POST['cedula'], 'estudiante', $_POST['primer-nombre'], $_POST['segundo-nombre'], $_POST['primer-apellido'], 
                            $_POST['segundo-apellido'], $_POST['password'], $_POST['confirm_password']);
            if($this->model->registerUser($user)){
                $this->model->registerStudent($user);
            }
        }
    }
}