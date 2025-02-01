<?php

require_once "model/UserModel.php";
require_once 'model/ErrorMessages.php';
require_once 'model/Session.php';

Session::startSession();

class LoginController extends RegisterController{
    private $model;
    private $errors;

    public function __construct(){
        $this->model = new UserModel();
        $this->errors = new ErrorMessages();
    }

    public function loginStudent(){
        if($this->validateData(['cedula', 'password'])){
            $user = new User(trim(
                $_POST["cedula"]),
                "estudiante", 
                "",
                "",
                "",
                "",
                trim($_POST["password"]),
                trim($_POST["password"])
            );

            $userData = $this->validations($user, "loginStudent");

            if ($userData['rol'] === 'estudiante') {
                $_SESSION['logged-in-student'] = true;
                $_SESSION['logged-in-teacher'] = false;
                $_SESSION['cedula'] = $userData['cedula'];
                $_SESSION['rol'] = $userData['rol'];
                header("Location: index.php?controller=profileStudent&action=getStudentData");
                exit();
            } else {
                header("Location: views/loginStudent.php");
                exit();
            }
        }
    }

    public function loginTeacher(){
        if($this->validateData(['cedula', 'password'])){
            $user = new User(trim(
                $_POST["cedula"]),
                "profesor", 
                "",
                "",
                "",
                "",
                trim($_POST["password"]),
                trim($_POST["password"])
            );

            $userData = $this->validations($user, "loginTeacher");

            if ($userData['rol'] === 'profesor') {
                $_SESSION['logged-in-student'] = false;
                $_SESSION['logged-in-teacher'] = true;
                $_SESSION['cedula'] = $userData['cedula'];
                $_SESSION['rol'] = $userData['rol'];
                header("Location: index.php?controller=table&action=mainTeacher");
                exit();
            } else {
                header("Location: views/loginTeacher.php");
                exit();
            }
        }
    }

    private function validations(User $user, string $view): array{
        $this->errors->verifyInputErrors($user, ['getCedula', 'checkCedula', 'getPassword'], "loginErrors", "$view");
        $this->model->setUser($user);
        $this->errors->verifyInputErrors($this->model, ['getUserData'], "loginErrors", "$view");

        $data = $this->model->getUserData();
       
        if(isset($data['clave']) && isset($data['rol'])){

            $clave = $data['clave'];
            $rol = $data['rol'];

            $this->errors->verifyInputErrors($user, ['verifyPasswords'], "loginErrors", "$view", $clave);
            $this->errors->verifyInputErrors($user, ['verifyRol'], "loginErrors", "$view", $rol);

            return $this->model->getUserData();
        }else{
            throw new Exception('Ha ocurrido un error en la validación.', 1);
        }
    }
}

