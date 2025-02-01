<?php

require_once 'NoteModel.php';

class UserModel{
    private $conn;
    private $user;

    public function __construct(){
        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }

    public function setUser(User $user): void{
        $this->user = $user;
    }

    public function getUserData(){
        try{
            $cedula = $this->user->getCedula();
            $sql = "SELECT * FROM usuarios WHERE cedula = :cedula";
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);

            if($cursor->execute()){
                return $cursor->fetch(PDO::FETCH_ASSOC);
            }else{
                throw new Exception("Usuario no registrado.", 1);
            }
        }catch (PDOException $e){
            throw new Exception("Error: ".$e->getMessage(), 1);
        }
    }

    public function registerUser(): bool{
        $cedula = $this->user->getCedula();
        $password = $this->user->getPassword()[1];
        $rol = $this->user->getRol();

        $noteModel = new NoteModel();

        if($noteModel->existsCedula($cedula, true)){
            throw new Exception("El usuario ya está registrado.", 1);
        }

        try{
            $sql = "INSERT INTO usuarios (cedula, clave, rol) VALUES (:cedula, :clave, :rol);";
            
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $cursor->bindParam(':clave', $password, PDO::PARAM_STR);
            $cursor->bindParam(':rol', $rol, PDO::PARAM_STR);
            
            if($cursor->execute()){
                $this->saveStudentData();
                $this->saveSecurityQuestions();
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            throw new Exception("Error al registrar el usuario: ".$e->getMessage(), 1);
        }
    }

    private function saveStudentData(): bool{
        $sql = "INSERT INTO estudiantes VALUES (
                :cedula, 
                :primer_nombre, 
                :segundo_nombre, 
                :primer_apellido, 
                :segundo_apellido, 
                :telefono, 
                :correo
        );";
        
        $cursor = $this->conn->prepare($sql);

        $cedula = $this->user->getCedula();
        $first_name =  $this->user->getNames()[0];
        $second_name =  $this->user->getNames()[1];
        $first_last_name = $this->user->getLastNames()[0];
        $second_last_name = $this->user->getLastNames()[1];
        $missing_data = NULL;

        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        $cursor->bindParam(':primer_nombre', $first_name, PDO::PARAM_STR);
        $cursor->bindParam(':segundo_nombre', $second_name, PDO::PARAM_STR);
        $cursor->bindParam(':primer_apellido', $first_last_name, PDO::PARAM_STR);
        $cursor->bindParam(':segundo_apellido', $second_last_name , PDO::PARAM_STR);
        $cursor->bindParam(':telefono', $missing_data, PDO::PARAM_NULL);
        $cursor->bindParam(':correo', $missing_data, PDO::PARAM_NULL);
        if($cursor->execute()){
            return true;
        }else{
            throw new Exception("No se pudo registrar los datos del usuario.", 1);
        }
    }

    private function saveSecurityQuestions(): bool{
        $sql = "INSERT INTO preguntas_seguridad VALUES (:cedula, :pregunta1, :respuesta1, :pregunta2, :respuesta2, :pregunta3, :respuesta3);";
        $cursor = $this->conn->prepare($sql);

        $cedula = $this->user->getCedula();
        $questions = $this->user->getSecurityQuestions();
        $answers = $this->user->getSecurityAnswers();

        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        $cursor->bindParam(':pregunta1', $questions[0], PDO::PARAM_STR);
        $cursor->bindParam(':respuesta1', $answers[0], PDO::PARAM_STR);
        $cursor->bindParam(':pregunta2', $questions[1], PDO::PARAM_STR);
        $cursor->bindParam(':respuesta2', $answers[1], PDO::PARAM_STR);
        $cursor->bindParam(':pregunta3', $questions[2], PDO::PARAM_STR);
        $cursor->bindParam(':respuesta3', $answers[2], PDO::PARAM_STR);
        if($cursor->execute()){
            return true;
        }else{
            throw new Exception("No se pudo registrar las preguntas de seguridad.", 1);
        }
    }
}