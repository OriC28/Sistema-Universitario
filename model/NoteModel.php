<?php

class NoteModel{
   private $id_materia;
   private $conn;

    public function __construct(){
        $this->id_materia = 1;

        # Estableciendo la conexión a la base de datos
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();
    }

    public function validateCedula(string $cedula){
        if(strlen($cedula) == 8){
            $cedula = (int)$cedula;
            return $cedula;
        }else{
            throw new Exception("Cédula inválida", 1);
        }
    }

    public function validateNotes($notes=[]){
        $total = 0;
        $clean_notes = [];
        if(sizeof($notes)==4){
            foreach($notes as $note){
                if(filter_var($note, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)){
                    $note = (float)$note;
                    if($note>=0 && $note<=20){
                        $total+=$note;
                    }else{
                        throw new Exception("Las notas deben estar en el rango de 0 a 20 puntos.", 1);
                    }
                }else{
                    throw new Exception("Las notas no son válidas.", 1);
                }
            }
        }else{
            throw new Exception("Error, las notas no están completas. En caso de no contener notas en un corte coloque 0.", 1);
        }
        array_push($notes, $total/4);
        return $notes;
    }

    public function setNotes(string $cedula, $notes = []){
        try{
            $cedula = $this->validateCedula($cedula);
            $notes = $this->validateNotes($notes);
                         
            $sql = "INSERT INTO calificaciones VALUES (:cedula, :id_materia, :corte1, :corte2, :corte3, :corte4, :definitiva);";
                            
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula);
            $cursor->bindParam(':id_materia', $this->id_materia);
            $cursor->bindParam(':corte1', $notes[0]);
            $cursor->bindParam(':corte2', $notes[1]);
            $cursor->bindParam(':corte3', $notes[2]);
            $cursor->bindParam(':corte4', $notes[3]);
            $cursor->bindParam('definitiva', $notes[4]);
                            
            if($cursor->execute()){
                echo "Las notas se agregaron con éxito";
            }else{
                throw new Exception( "Las notas no pudieron ser agregadas.", 1);
            }
        }catch(\Throwable $th) {
            error_log($th->getMessage());
            die("Ocurrió un error al procesar su solicitud. Inténtelo más tarde.");
        }
    }  
    
    public function getNotes(){
        $notes_user = new NoteModel();
        $cedula = htmlspecialchars($_SESSION['cedula']);
        $notes = $notes_user->getNotes($cedula);
        require_once "views/editNotes.php";
    }
}