<?php

class QuestionAnswerModel{
    private $conn;

    public function __construct(array $questions, array $answers){

        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }

    public function validateQuestionField(string $question){
        if(!is_string($question) || !preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÑ]+$/u', $question)){
            throw new Exception("Por favor ingrese preguntas únicamente con letras.");
        }

        if(strlen($question)>200){
            throw new Exception("La longitud de las preguntas debe ser menor a 200 caracteres.", 1);
        }
        return $question;
    }

    public function validateAnswerField(string $answer){
        if(!preg_match('/^[a-zA-ZáéíóúüñÁÉÍÓÚÑ0-9]+$/')){
            throw new Exception("Las respuestas no pueden contener caracteres especiales.", 1);
        }

        if(strlen($answer)>200){
            throw new Exception("La longitud de las respuestas debe ser menor a 200 caracteres.", 1);
        }
        return $answer;
    }

    public function setQuestionAnswer(string $cedula){
        try{
            $questionsValidated = array_map('validateQuestionField', $questions);
            $answersValidated = array_map('validateAnswerField', $answers);

            $firstQuestion = $questionsValidated[0];
            $secondQuestion = $questionsValidated[1];
            $thirdQuestion = $questionsValidated[2];

            $firstAnswer = $answersValidated[0];
            $secondAnswer = $answersValidated[1];
            $thirdAnswer = $answersValidated[2];
        
            $sql = 'INSERT INTO preguntas_seguridad VALUES (
                :cedula,
                :first_question,
                :first_answer,
                :second_question,
                :second_answer,
                :third_question,
                :third_answer
            );';
    
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $cursor->bindParam(':first_question', $firstQuestion, PDO::PARAM_STR);
            $cursor->bindParam(':second_question', $secondQuestion, PDO::PARAM_STR);
            $cursor->bindParam(':third_question', $thirdQuestion, PDO::PARAM_STR);

            $cursor->bindParam(':first_answer', $firstAnswer, PDO::PARAM_STR);
            $cursor->bindParam(':second_answer', $secondAnswer, PDO::PARAM_STR);
            $cursor->bindParam(':third_answer', $thirdAnswer, PDO::PARAM_STR);
            
            if(!$cursor->execute()){
                return true;
            }
            return false;
        
        }catch (\Throwable $th) {
            die($th->getMessage());
        }
    }
}