<?php

/**
 * VIEW: views/signup.php
 * VIEW: views/recoverypasswordForm.php
 * MODEL: 'model/RegisterModel.php'
 * MODEL: 'model/User.php'
 */

require_once 'model/RegisterModel.php'; 
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
        $this->errors = [];
    }
    /**
     * Valida los parámetros recibidos vía post desde la vista registro y de preguntas de seguridad
     */
    public function validateData(array $data): bool{
        if($_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['submit']){
            throw new Exception("No se ha enviado ninguna petición.", 1);
        }
        foreach ($data as $param){
            if(!isset($_POST[$param]) && empty($_POST[$param])){
                throw new Exception("Por favor, rellene todos los campos", 1);
            }
        }
        return true;
    }
    /**
     * Verifica y obtiene los mensajes de error que arrojan los métodos dentro del modelo User
     * @param User $user instancia de clase User
     * @return void
     */
    private function verifyInputErrors(User $user): void{
        $methods = ['getCedula', 
                    'verifyCedula',
                    'getNames', 
                    'getLastNames', 
                    'validatePassword', 
                    'getPassword'
                ];
        foreach ($methods as $method) {
            try{
                $user->$method();
            }catch (Exception $e){
                if ($method == "getPassword" && $e->getMessage() == "Contraseña inválida.") {
                    continue;
                }
                $this->errors[] = $e->getMessage();
            }
        }
        $this->checkErrors("signupForm");
    }
    /**
     * Almacena los errores captuadores en una variable de sesión y llama a la vista correspondiente
     * @param string $view vista a la cual se le mostrarán los errores
     * @return void
     */
    private function checkErrors(string $view): void{
        if ($this->errors) {
            $_SESSION["signupErrors"] = $this->errors;
            require_once "views/" . basename($view) . ".php";
            exit();
        }
    }
    /**
     * Elimina los errores de la variable de sesión antes creada
     * @return void
     */
    private function cleanErrors(): void{
        unset($_SESSION["signupErrors"]);
        $this->errors = [];
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
            
            $this->verifyInputErrors($user);

            $this->cleanErrors();

            $_SESSION["userSignupData"] = serialize($user);

            header("Location: views/recoverypasswordForm.php");
            exit();
        }
    }

    public function finishSignUp(){
        $keys = ['primera-pregunta', 
                'segunda-pregunta',
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

            try {
                $user->getSecurityQuestions();
            } catch (Exception $e){
                $this->errors[] = $e->getMessage();
            }

            $this->checkErrors("recoverypasswordForm");

            $this->cleanErrors();

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
                $this->model->registerStudent($user);
                $this->model->saveSecurityQuestions($user);
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
}