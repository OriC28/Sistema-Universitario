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
    private $security_answers = [];

    public function __construct(
        string $cedula, 
        string $rol = "", 
        string $first_name = "", 
        string $second_name = "", 
        string $last_name = "",
        string $second_last_name = "", 
        string $password = "", 
        string $confirm_password = "", 
        array $security_questions=[]
    ){
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

    /**
    * Valida la cédula de acuerdo a la longitud y si es un valor entero.
    *
    * @return int si la cédula cumple lo necesario para considerarse válida
    * @param int $cedula identificador único del estudiante
    * @throws Exception Si la cédula no es válida
    */
    public static function validateCedula(string $cedula): int{
        if (!empty($cedula) || isset($cedula)) {
            if(is_numeric($cedula) && (strlen($cedula) == 7 || strlen($cedula) == 8)){
                if(filter_var($cedula, FILTER_VALIDATE_INT)){
                    $cedula = (int)$cedula;
                    return $cedula;
                }
            }else{
                throw new Exception("Cédula inválida.", 1);
            }
        }else{
            throw new Exception("Cédula ausente.", 1);
        }
    }
    
    public function getCedula(): int{
        $cedulaValidated = self::validateCedula($this->cedula);
        return $cedulaValidated;
    }
    
    public function verifyCedula(): bool|Exception{
        $noteModel = new NoteModel();
        if((!isset($this->cedula) || empty($this->cedula) || !is_numeric($this->cedula))){
            return false;
        }elseif($noteModel->existsCedula($this->cedula, true)){
            throw new Exception("Cédula ya registrada.", 1);
        }else{
            return false;
        }
    }

    public function checkCedula(): bool|Exception{
        $noteModel = new NoteModel();
        if((!isset($this->cedula) || empty($this->cedula) || !is_numeric($this->cedula))){
            return false;
        }elseif(!$noteModel->existsCedula($this->cedula, true)){
            throw new Exception("La cédula no se encuentra registrada.", 1);
        }else{
            return false;
        }
    }

    public function getRol(bool $flag=false): string{
       if($this->rol != 'estudiante' && $this->rol != 'profesor'){
           throw new Exception("Rol inválido.", 1);
       }
       return $this->rol;
    }

    public function verifyRol(string $rol): bool{
        if ($this->rol !== $rol) {
            if ($rol !== "estudiante") {
                throw new Exception("El usuario no está registrado como estudiante.", 1);
            } else {
                throw new Exception("El usuario no está registrado como profesor.", 1);
            }
        } else {
            return true;
        }
    }

    public function validateNames(string $field, string $firstMessageError, string $secondMessageError, string $thirdMessageError): string{
        if(!isset($field) || empty($field)){
            throw new Exception($firstMessageError, 1);
        }elseif(!is_string($field) || !preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÑ\s]+$/u', $field)){
            throw new Exception($secondMessageError, 1);
        }elseif(strlen($field)<2 || strlen($field)>50){
            throw new Exception($thirdMessageError, 1);
        }
        return $field;
    }

    public function validateQuestionAndAnswer(string $field, string $firstMessageError, $secondMessageError, $thirdMessageError){
        if(!isset($field) || empty($field)){
            throw new Exception($firstMessageError, 1);
        }elseif(!is_string($field) || !preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÑ\s]+$/u', $field)){
            throw new Exception($secondMessageError, 1);
        }elseif(strlen($field)>100){
            throw new Exception($thirdMessageError, 1);
        }
        return $field;
    }

    public function getNames(): array{
        $lengthErrorFirstName = "El primer nombre debe tener una longitud de 2 a 50 caracteres.";
        $lengthErrorSecondName = str_replace('primer', 'segundo',  $lengthErrorFirstName);
   
        $this->validateNames($this->first_name, "Primer nombre ausente.", "Primer nombre inválido.", $lengthErrorFirstName);
        $this->validateNames($this->second_name, "Segundo nombre ausente.", "Segundo nombre inválido.", $lengthErrorSecondName);
        return [$this->first_name, $this->second_name];
    }

    public function getLastNames(): array{
        $lengthErrorFirstLastName = "El primer apellido debe tener una longitud de 2 a 50 caracteres.";
        $lengthErrorSecondLastName = str_replace('primer', 'segundo', $lengthErrorFirstLastName);

        $this->validateNames($this->last_name, "Primer apellido ausente.", "Primer apellido inválido.", $lengthErrorFirstLastName);
        $this->validateNames($this->second_last_name, "Segundo apellido ausente.", "Segundo apellido inválido.", $lengthErrorSecondLastName);
        return [$this->last_name, $this->second_last_name];
    }
    
    public function setPasswords(array $data): void{
        $this->password = $data[0];
        $this->confirm_password = $data[1];
        return;
    }

    public function getPassword(): array{
        if($this->validatePassword()){
            return [$this->password, password_hash($this->password, PASSWORD_DEFAULT)];
        }
    }

    public function validatePassword(): bool{
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!?@#$%&*\-_,.])(?!.*[<>'\"])[\p{L}\d!?@#$%&*(){}\-_,.]{8,72}$/u";
        $nojoda = ["password", "confirm_password"];
        foreach ($nojoda as $vaina) {
            if(!preg_match($pattern, $this->$vaina) || !isset($this->$vaina) || empty($this->$vaina)){
                throw new Exception("Contraseña(s) inválida(s).", 1);
            }
        }
        if($this->password !== $this->confirm_password){
            throw new Exception("Las contraseñas no coinciden.", 1);
        }
        return true;
    }

    public function verifyPasswords(string $hashedPassword) {
        if(password_verify($this->getPassword()[0], $hashedPassword)){
            return true;
        }else{
            throw new Exception("Contraseña incorrecta.");
        }
    }

    public function setSecurityQuestions(array $data): void{
        foreach ($data as $key => $value) {
            $this->security_questions[] = $key;
            $this->security_answers[] = $value;
        }
        return;
    }

    public function getSecurityQuestions(): array{
        $errorLenght = "La pregunta(s) de seguridad debe(n) tener menos de 100 caracteres.";
        foreach ($this->security_questions as $question) {
            $this->validateQuestionAndAnswer($question, "Pregunta(s) de seguridad ausente(s).", "Pregunta(s) de seguridad inválida(s).", $errorLenght);
        }
        return [$this->security_questions[0],
                $this->security_questions[1],
                $this->security_questions[2]];
    }

    public function getSecurityAnswers(): array{
        $errorLenght = "La respuesta(s) de seguridad debe(n) tener menos de 100 caracteres.";
        foreach ($this->security_answers as $answer) {
            $this->validateQuestionAndAnswer($answer, "Respuesta(s) de seguridad ausente(s).", "Respuesta(s) de seguridad inválida(s).", $errorLenght);
        }
        return [password_hash($this->security_answers[0], PASSWORD_DEFAULT),
                password_hash($this->security_answers[1], PASSWORD_DEFAULT),
                password_hash($this->security_answers[2], PASSWORD_DEFAULT)];
    }
}