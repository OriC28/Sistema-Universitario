<?php 

class User{
    private $cedula;
    private $rol;
    private $first_name;
    private $second_name;
    private $last_name;
    private $second_last_name;
    private $password;
    private $confirm_password;
    private $security_questions = [];
    private $security_answer = [];

    public function __construct(string $cedula, string $rol, string $first_name, string $second_name, 
                                string $last_name,string $second_last_name, string $password, string $confirm_password, 
                                array $security_questions=[], array $security_asnwers=[]){
        $this->cedula = $cedula;
        $this->rol = $rol;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->last_name = $last_name;
        $this->second_last_name = $second_last_name;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->security_questions = $security_questions;
    }

    public function getCedula(): int{
        $noteModel = new NoteModel();
        $cedulaValidated = $noteModel->validateCedula($this->cedula);
        return $cedulaValidated;
    }
    
    public function verifyCedula(): bool{
        $noteModel = new NoteModel();
        if($noteModel->existsCedula($this->cedula, true)){
            throw new Exception("Cédula ya registrada.", 1);
        }else{
            return false;
        }
    }


    public function getRol(): string{
       if($this->rol != 'estudiante' && $this->rol != 'profesor'){
           throw new Exception("Rol inválido.", 1);
       }
       return $this->rol;
    }

    public function validateStringFields(string $field, string $firstMessageError, string $secondMessageError): string{
        if(!isset($field) || empty($field)){
            throw new Exception($firstMessageError, 1);
        }elseif(!is_string($field) || is_numeric($field) || !preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÑ\s]+$/u', $field)){
            throw new Exception($secondMessageError, 1);
        }
        $fieldSanitized = filter_var($field, FILTER_SANITIZE_STRING);
        return $fieldSanitized;
    }

    public function getNames(): array{
        $this->validateStringFields($this->first_name, "Primer nombre ausente.", "Primer nombre inválido.");
        $this->validateStringFields($this->second_name, "Segundo nombre ausente.", "Segundo nombre inválido.");
        return [$this->first_name, $this->second_name];
    }

    public function getLastNames(): array{
        $this->validateStringFields($this->last_name, "Primer apellido ausente.", "Primer apellido inválido.");
        $this->validateStringFields($this->second_last_name, "Segundo apellido ausente.", "Segundo apellido inválido.");
        return [$this->last_name, $this->second_last_name];
    }

    public function validatePassword(): string{ #(?=.*[^<>'\"])
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!?@#$%&*\-_,.])(?!.*[<>'\"])[\p{L}\d!?@#$%&*(){}\-_,.]{8,72}$/u";
        if(!isset($this->password) || empty($this->password)){
            throw new Exception("Contraseña ausente.", 1);
        }
        elseif(!preg_match($pattern, $this->password)){
            throw new Exception("Contraseña inválida.", 1);
        }
        return true;
    }

    public function getPassword(): string{
        $passwordsValidated = "";

        if($this->validatePassword($this->password) && $this->validatePassword($this->confirm_password)){
            if($this->password != $this->confirm_password){
                throw new Exception("Las contraseñas no coinciden.", 1);
            } else{
                $passwordsValidated = [$this->password, $this->confirm_password];
            }
        }

        return password_hash($passwordsValidated[0], PASSWORD_DEFAULT);
    }

    public function setSecurityQuestions(array $data): void{
        foreach ($data as $key => $value) {
            $this->security_questions[] = $key;
            $this->security_answer[] = $value;
        }
    }

    public function getSecurityQuestions(): array{
        foreach ($this->security_questions as $question) {
            $this->validateStringFields($question, "Pregunta(s) de seguridad ausente(s).", "Pregunta(s) de seguridad inválida(s).");
        }
        return [$this->security_questions[0],
                $this->security_questions[1],
                $this->security_questions[2]];
    }

    public function getSecurityAnswers(): array{
        foreach ($this->security_answer as $answer) {
            $this->validateStringFields($answer, "Respuesta(s) de seguridad ausente(s).", "Respuesta(s) de seguridad inválida(s).");
        }
        return [password_hash($this->security_answer[0], PASSWORD_DEFAULT),
                password_hash($this->security_answer[1], PASSWORD_DEFAULT),
                password_hash($this->security_answer[2], PASSWORD_DEFAULT)];
    }
}