<?php

/**
 * VIEW: views/signup.php
 * VIEW: views/recoverypasswordForm.php
 * MODEL: 'model/RegisterModel.php'
 * MODEL: 'model/ErrorMessages.php';
 * MODEL: 'model/User.php'
 */
require_once 'model/RegisterModel.php';
require_once 'model/ErrorMessages.php';
require_once 'model/User.php';

# Verificar si hay una session activa antes de iniciar una
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Controlador que maneja el proceso de registro de los datos del estudiante y las preguntas de seguridad.
 */
class RegisterController{
    private $model;
    private $errors;

    public function __construct(){
        $this->model = new RegisterModel();
        $this->errors = new ErrorMessages();
    }

    /**
     * Valida los parámetros recibidos vía post desde la vista registro y de preguntas de seguridad
     */
    public function validateData(array $data): bool{
        if($_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['submit']){
            throw new Exception("No se ha enviado ninguna petición.", 1);
            header("Location: loginStudent.php");
            die();
        }
        foreach ($data as $param){
            if(!isset($_POST[$param]) && empty($_POST[$param])){
                throw new Exception("Por favor, rellene todos los campos", 1);
            }
        }
        return true;
    }

    public function startSignUp(){
        if(isset($_SESSION["userSignupData"])){
            unset($_SESSION["userSignupData"]);
        }

        $data = ['cedula', 
                'primer-nombre',
                'segundo-nombre', 
                'primer-apellido', 
                'segundo-apellido', 
                'password', 
                'confirm_password'
            ];

        if($this->validateData($data)){
            $user = new User(trim($_POST['cedula']),
                            'estudiante', 
                            trim($_POST['primer-nombre']), 
                            trim($_POST['segundo-nombre']), 
                            trim($_POST['primer-apellido']), 
                            trim($_POST['segundo-apellido']), 
                            trim($_POST['password']), 
                            trim($_POST['confirm_password'])
                        );
            
            $this->errors->verifyInputErrors(
                $user, 
                ['getCedula', 'verifyCedula', 'getNames',  'getLastNames',  'validatePassword', 'getPassword'], 
                "signupErrors", 
                "signupForm");

            $_SESSION["userSignupData"] = serialize($user);
            header("Location: views/recoverypasswordForm.php");
            exit();
        }
    }

    public function finishSignUp(){
        $keys = ['primera-pregunta',
                'primera-respuesta',
                'segunda-pregunta',
                'segunda-respuesta', 
                'tercera-pregunta', 
                'tercera-respuesta'
            ];

        if($this->validateData($keys)){
            $inputs = [
                trim($_POST['primera-pregunta']) => trim($_POST['primera-respuesta']),
                trim($_POST['segunda-pregunta']) => trim($_POST['segunda-respuesta']),
                trim($_POST['tercera-pregunta']) => trim($_POST['tercera-respuesta'])
            ];

            $user = unserialize($_SESSION["userSignupData"]);
            $user->setSecurityQuestions($inputs);
            $this->errors->verifyInputErrors($user, ['getSecurityQuestions', 'getSecurityAnswers'], "signupErrors", "recoverypasswordForm");
            
            $this->signup($user);
            unset($_SESSION["userSignupData"]);
            header("Location: views/loginStudent.php");
            exit();
        }
    }
    
    private function signup(User $user){
        try {
            $this->model->registerUser($user);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}