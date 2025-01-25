<?php

require_once 'model/RegisterModel.php'; 
require_once 'model/User.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class RegisterController{
    private $model;
    private $errors;

    public function __construct(){
        $this->model = new RegisterModel();
        $this->errors = [];
    }
    
    private function validateData(array $data): bool{
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

    private function verifyInputErrors(user $user){
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

    private function checkErrors(string $view): void{
        if ($this->errors) {
            $_SESSION["signupErrors"] = $this->errors;
            require_once "views/" . basename($view) . ".php";
            exit();
        }
    }

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
        $keys = ['question1', 
                'answer1',
                'question2', 
                'answer2', 
                'question3', 
                'answer3'
            ];

        if($this->validateData($keys)){
            $inputs = [
                $_POST['question1'] => $_POST['answer1'],
                $_POST['question2'] => $_POST['answer2'],
                $_POST['question3'] => $_POST['answer3']
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