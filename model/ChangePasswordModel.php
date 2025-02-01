<?php

class ChangePasswordModel{
    private $conn;
    private $cedula;
    private $security_questions = [];
    private $security_answers = [];

    public function __construct(int $cedula = 0, array $security_questions=[]){
        $this->cedula = $cedula;
        $this->security_questions = $security_questions;

        # Estableciendo la conexión a la base de datos
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }

    public function setCedula(int $cedula): void{
        $this->cedula = $cedula;
    }

    public function setSecurityQuestions(array $data): void{
        $i = 1;
        foreach ($data as $key => $value) {
            $this->security_questions["pregunta" . $i] = $key;
            $this->security_answers["respuesta" . $i] = $value;
            $i++;
        }
    }

    public function getAnswersQuestionsTo(bool $flag=false): array|false{
        if($flag){
            $sql = "SELECT respuesta1, respuesta2, respuesta3 FROM preguntas_seguridad WHERE cedula = :cedula;";
        }else{
            $sql = "SELECT pregunta1, pregunta2, pregunta3 FROM preguntas_seguridad WHERE cedula = :cedula;";
        }

        $cursor = $this->conn->prepare($sql);
        $cursor->bindParam(':cedula', $this->cedula, PDO::PARAM_INT);
        if($cursor->execute()){
            return $cursor->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function verifyAnswers(array $answers, array $answersDB, array $errorMessage){
        foreach($answersDB as $key => $answerHashed){
            if(!password_verify($answers[$key], $answerHashed)){
                throw new Exception($errorMessage[$key], 1);
            }
        }
    }

    public function verifyQuestions(array $question, array $questionsDB, array $errorMessage){
        foreach($questionsDB as $key => $questionDB){
            if($question[$key] !== $questionDB){
                throw new Exception($errorMessage[$key], 1);
            }
        }
    }

    public function verifySecurityQuestions(): void{
        $answersDB = $this->getAnswersQuestionsTo(true);
        $questionsDB = $this->getAnswersQuestionsTo();
            $errors = [
            'preguntas' => [
                'pregunta1' => 'Primera pregunta incorrecta.',
                'pregunta2' => 'Segunda pregunta incorrecta.',
                'pregunta3' => 'Tercera pregunta incorrecta.'
            ],
            'respuestas' => [
                'respuesta1' => 'Primera respuesta incorrecta.', 
                'respuesta2' => 'Segunda respuesta incorrecta.',
                'respuesta3' => 'Tercera respuesta incorrecta.'
            ]
            ];

        $this->verifyQuestions($this->security_questions, $questionsDB, $errors['preguntas']);
        $this->verifyAnswers($this->security_answers, $answersDB, $errors['respuestas']);
    }

    public function validatePassword(string $password): string{
        $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!?@#$%&*\-_,.])(?!.*[<>'\"])[\p{L}\d!?@#$%&*(){}\-_,.]{8,72}$/u";
        if(!isset($password) || empty($password)){
            throw new Exception("Contraseña ausente.", 1);
        }
        elseif(!preg_match($pattern, $password)){
            throw new Exception("Contraseña inválida.", 1);
        }
        return true;
    }

    public function updatePassword(int $cedula, string $newPassword){
        $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $cursor = $this->conn->prepare("UPDATE usuarios SET clave = :clave WHERE cedula = :cedula;");
        $cursor->bindParam(':clave', $newPasswordHashed, PDO::PARAM_STR);
        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);

        if($cursor->execute()){
            return true;
        }
        throw new Exception("No se pudo cambiar la contraseña.", 1);
    }
}