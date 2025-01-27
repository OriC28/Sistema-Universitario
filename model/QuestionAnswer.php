<?php

class QuestionAnswer{
    private $conn;
    private $securityQuestions = [];
    private $securityAnswers = [];

    public function __construct(array $securityQuestions=[], array $securityAnswers=[]){
        $this->securityQuestions = $securityQuestions;
        $this->securityAnswers = $securityAnswers;
        
        # Estableciendo la conexión a la base de datos
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }
    public function __sleep(){
        return array('securityQuestions', 'securityAnswers');
    }

    public function __wakeup(){
        # Estableciendo la conexión a la base de datos
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();
    }

    public function saveSecurityQuestions(int $cedula){
        $sql = "INSERT INTO preguntas_seguridad VALUES (
            :cedula, 
            :pregunta1, 
            :respuesta1, 
            :pregunta2, 
            :respuesta2, 
            :pregunta3, 
            :respuesta3);";

        $cursor = $this->conn->prepare($sql);

        $questions = $this->getSecurityQuestions();
        $answers = $this->getSecurityAnswers();

        echo var_dump($questions);

        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        $cursor->bindParam(':pregunta1', $questions[0], PDO::PARAM_STR);
        $cursor->bindParam(':respuesta1', $answers[0], PDO::PARAM_STR);
        $cursor->bindParam(':pregunta2', $questions[1], PDO::PARAM_STR);
        $cursor->bindParam(':respuesta2', $answers[1], PDO::PARAM_STR);
        $cursor->bindParam(':pregunta3', $questions[2], PDO::PARAM_STR);
        $cursor->bindParam(':respuesta3', $answers[2], PDO::PARAM_STR);
        if($cursor->execute()){
            return true;
        }
        throw new Exception("No se pudo registrar las preguntas de seguridad.", 1);
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

    public function setSecurityQuestions(array $data): void{
        foreach ($data as $key => $value) {
            $this->securityQuestions[] = $key;
            $this->securityAnswers[] = $value;
        }
    }

    public function getSecurityQuestions(): array{
        $errorLenght = "La pregunta(s) de seguridad debe(n) tener menos de 100 caracteres.";
        foreach ($this->securityQuestions as $question) {
            $this->validateQuestionAndAnswer($question, "Pregunta(s) de seguridad ausente(s).", "Pregunta(s) de seguridad inválida(s).", $errorLenght);
        }
        return [$this->securityQuestions[0],
                $this->securityQuestions[1],
                $this->securityQuestions[2]];
    }

    public function getSecurityAnswers(): array{
        $errorLenght = "La respuesta(s) de seguridad debe(n) tener menos de 100 caracteres.";
        foreach ($this->securityAnswers as $answer) {
            $this->validateQuestionAndAnswer($answer, "Respuesta(s) de seguridad ausente(s).", "Respuesta(s) de seguridad inválida(s).", $errorLenght);
        }
        return [password_hash($this->securityAnswers[0], PASSWORD_DEFAULT),
                password_hash($this->securityAnswers[1], PASSWORD_DEFAULT),
                password_hash($this->securityAnswers[2], PASSWORD_DEFAULT)];
    }


}