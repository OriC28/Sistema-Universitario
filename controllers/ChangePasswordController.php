<?php 

require_once './model/User.php';
require_once './model/NoteModel.php';
require_once './model/ChangePasswordModel.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class ChangePasswordController extends RegisterController{
    private $noteModel;
    private $changePasswordModel;
    private $errors;

    public function __construct(){
        $this->noteModel = new NoteModel();
        $this->changePasswordModel = new ChangePasswordModel();
        $this->errors = [];
    }

    public function getCedula(){
        $cedula = User::validateCedula($_POST['cedula']);
        if(!$this->noteModel->existsCedula($cedula, true)){
            throw new Exception("El usuario no se encuentra registrado.", 1);
        }
        return $cedula;
    }

    public function changePasswordStep1(){
        $dataStep1 = ['cedula'];
        if($this->validateData($dataStep1)){
            $cedula = $this->getCedula();

            $_SESSION['cedula'] = serialize($cedula);
            $_SESSION['securityStepReady'] = true;

            header("Location: views/changePasswordStep2.php");
            exit();
        }
    } 
    
    public function changePasswordStep2(){
        $keys = ['primera-pregunta', 
                'primera-respuesta',
                'segunda-pregunta', 
                'segunda-respuesta', 
                'tercera-pregunta', 
                'tercera-respuesta'
            ]; 
        
        if($this->validateData($keys)){
            $questions = [
                'pregunta1' => $_POST[$keys[0]],
                'pregunta2' => $_POST[$keys[2]],
                'pregunta3' => $_POST[$keys[4]],
            ];

            $answers = [
                'respuesta1' => $_POST[$keys[1]],
                'respuesta2' => $_POST[$keys[3]],
                'respuesta3' => $_POST[$keys[5]],
            ];

            $cedula = unserialize($_SESSION['cedula']);
            
            $this->changePasswordModel->verifySecurityQuestions($cedula, $questions, $answers);
            
            $_SESSION['securityStepReady'] = true;
            
            header('Location: views/changePasswordStep3.php');
            exit();
        }
    }

    public function changePasswordStep3(){
        if($this->validateData(['new-password', 'password'])){
            $passwordsValidated = [];
            $cedula = unserialize($_SESSION['cedula']);
            $newPassword = $_POST['new-password'];
            $confirmPassword = $_POST['password'];

            if($this->changePasswordModel->validatePassword($newPassword) && 
                $this->changePasswordModel->validatePassword($confirmPassword)){
                if($newPassword != $confirmPassword){
                    throw new Exception("Las contraseñas no coinciden.", 1);
                } 
                $this->changePasswordModel->updatePassword($cedula, $newPassword);
                header('Location: views/loginStudent.php');
                exit();
            }
        }
    }
}