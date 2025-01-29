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
        // $this->errors = [];
        $this->errors = new ErrorMessages();
    }

    /**
     * Valida los parámetros recibidos vía post desde la vista registro y de preguntas de seguridad
     */
    public function validateData(array $data): bool{
        if($_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['submit']){
            throw new Exception("No se ha enviado ninguna petición.", 1);
            header("Location: views/signupForm.php");
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
        $data = ['cedula', 
                'primer-nombre',
                'segundo-nombre', 
                'primer-apellido', 
                'segundo-apellido', 
                'password', 
                'confirm_password'
            ];

        if($this->validateData($data)){
            $user = new User($_POST['cedula'],
                            'estudiante', 
                            $_POST['primer-nombre'], 
                            $_POST['segundo-nombre'], 
                            $_POST['primer-apellido'], 
                            $_POST['segundo-apellido'], 
                            $_POST['password'], 
                            $_POST['confirm_password']
                        );
            
            $this->errors->verifyInputErrors($user, ['getCedula', 
                                                    'verifyCedula',
                                                    'getNames', 
                                                    'getLastNames', 
                                                    'validatePassword', 
                                                    'getPassword'], "signupForm");

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
                $_POST['primera-pregunta'] => $_POST['primera-respuesta'],
                $_POST['segunda-pregunta'] => $_POST['segunda-respuesta'],
                $_POST['tercera-pregunta'] => $_POST['tercera-respuesta']
            ];

            $user = unserialize($_SESSION["userSignupData"]);
            $user->setSecurityQuestions($inputs);

            $this->errors->verifyInputErrors($user, ['getSecurityQuestions'], "recoverypasswordForm");

            $this->signup($user);
            /**
             * (issue): hay que evitar que el usuario pueda regresarse a la vista de las preguntas de seguridad.
             */
            header("Location: views/loginStudent.php");
            exit();
        }
    }
    
    private function signup(User $user){
        try {
            if ($this->model->registerUser($user)) {
                $this->model->saveStudentData($user);
                $this->model->saveSecurityQuestions($user);
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}