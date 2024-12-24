<?php

require_once './model/UserModel (prueba inicial).php';

class UserController{
    public function signup(){
        require_once "./views/signupForm.php";
    }

    public function login_student(){
        require_once "./views/loginStudent.php";
    }

    public function insertUser(){
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $user = new UserModel($cedula, $password, $confirm_password);

        $result = $user->insertUser();

        if($result){
            echo "Usuario registrado con éxito.";
        }else{
            echo "No se pudo registrar el usuario.";
        }
    }
    public function getUser(){
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];
        $user = new UserModel($cedula, $password);

        $result = $user->getUser();
    }
}