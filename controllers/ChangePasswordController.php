<?php 

require_once 'model/User.php';
require_once 'model/NoteModel.php';
require_once 'model/ChangePasswordModel.php';
require_once 'model/ErrorMessages.php';
require_once 'model/Session.php';

Session::startSession();

class ChangePasswordController extends RegisterController{
    private $noteModel;
    private $changePasswordModel;
    private $errors;

    public function __construct(){
        $this->noteModel = new NoteModel();
        $this->changePasswordModel = new ChangePasswordModel();
        $this->errors = new ErrorMessages();
    }

    public function changePasswordStep1(){
        if($this->validateData(['cedula'])){
            $user = new User(trim($_POST['cedula']));

            $this->errors->verifyInputErrors($user, ['getCedula', 'checkCedula'], 'changePasswordErrors', 'changePasswordStep1');

            $_SESSION['changePasswordData'] = serialize($user);

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
            $inputs = [
                trim($_POST['primera-pregunta']) => trim($_POST['primera-respuesta']),
                trim($_POST['segunda-pregunta']) => trim($_POST['segunda-respuesta']),
                trim($_POST['tercera-pregunta']) => trim($_POST['tercera-respuesta'])
            ];
            
            $user = unserialize($_SESSION['changePasswordData']);
            if ($_SESSION['changePasswordData']) { $user->setSecurityQuestions($inputs); }
            $this->changePasswordModel->setCedula($user->getCedula());
            $this->changePasswordModel->setSecurityQuestions($inputs);
            $this->errors->verifyInputErrors($user, ['getSecurityQuestions', 'getSecurityAnswers'], 'changePasswordErrors', 'changePasswordStep2');
            $this->errors->verifyInputErrors($this->changePasswordModel, ["verifySecurityQuestions"], 'changePasswordErrors', 'changePasswordStep2');
            
            unset($_SESSION['changePasswordData']);
            $_SESSION['changePasswordData'] = serialize($user);
            $_SESSION["stepReady"] = false;
            $_SESSION["stepReady"] = true;
            
            header('Location: views/changePasswordStep3.php');
            exit();
        }
    }

    public function changePasswordStep3(){
        if($this->validateData(['new-password', 'password'])){
            $passwords = [
                trim($_POST['new-password']),
                trim($_POST['password'])
            ];
            
            if (isset($_SESSION['changePasswordData'])) {
                $user = unserialize($_SESSION['changePasswordData']);
                $user->setPasswords($passwords);
                $this->errors->verifyInputErrors($user, ['getPassword'], 'changePasswordErrors', 'changePasswordStep3');
                $this->changePasswordModel->updatePassword($user->getCedula(), $passwords[0]);
            }

            unset($_SESSION['changePasswordData']);
            header('Location: views/loginStudent.php');
            exit();
            // }
        }
    }
}