<?php

require_once "model/LoginModel.php";
require_once 'model/ErrorMessages.php';
require_once "model/Session.php";

class LoginController{
    private function validateData(array $data): bool{
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            throw new Exception("No se ha enviado ninguna petición.", 1);
            header("Location: signupForm.php");
            die();
        }
        foreach ($data as $param){
            if(!isset($_POST[$param]) && empty($_POST[$param])){
                throw new Exception("No se han enviado todos los datos requeridos.", 1);
            }
        }
        return true;
    }

    public function loginStudent(){
        if($this->validateData(['cedula', 'password'])){
            /**
             * De aquí se obtendrá la cédula con la que el usuario inicia sesión
             */
            # Es necesario validarlos
            $cedula = $_POST['cedula'];
            $password = $_POST['password']; 

            $loginModel = new LoginModel($cedula, $password);
            $passwordHashed = $loginModel->getDataUser();
            $rol = $loginModel->getDataUser();

            if(!$passwordHashed){
                throw new Exception("Contraseña o usuario incorrecto.");
            }
            if(!$loginModel->validateUser($passwordHashed['clave']) || $rol['rol']!= 'estudiante'){
                throw new Exception("El usuario ingresado no es válido.", 1);
            }

            $_SESSION['logged-in-student'] = true;
            $_SESSION['logged-in-teacher'] = false;
            $_SESSION['rol'] = $rol;
            $_SESSION['cedula'] = $cedula;
            header("Location: index.php?controller=profileStudent&action=getStudentData");
            exit();  
        }       
    }

    public function loginTeacher(){
        try{
            if($this->validateData(['cedula', 'password'])){

                $cedula = $_POST['cedula'];
                $password = $_POST['password'];

                $loginModel = new LoginModel($cedula, $password);
                $teacherPasswordHashed = $loginModel->getDataUser()['clave'];
                $rol = $loginModel->getDataUser()['rol'];

                if(!$teacherPasswordHashed){
                    throw new Exception("Contraseña o usuario incorrecto.");
                }
                if(!$loginModel->validateUser($teacherPasswordHashed) || $rol!= 'profesor'){
                    throw new Exception("El usuario ingresado es inválido.", 1);
                }
                $_SESSION['logged-in-student'] = false;
                $_SESSION['logged-in-teacher'] = true;
                $_SESSION['rol'] = $rol;
                header("Location: index.php?controller=table&action=mainTeacher");
                exit();  
            }
        }catch(Throwable $th){
            die($th->getMessage());
        }
    }
}