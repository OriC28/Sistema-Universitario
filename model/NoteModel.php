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
        if(strlen($cedula) == 7 || strlen($cedula) == 8){
            if(filter_var($cedula, FILTER_VALIDATE_INT)){
                $cedula = (int)$cedula;
                return $cedula;
            }
        }else{
            throw new Exception("Cédula inválida", 1);
        }
    }

    public function validateNotes(array $notes=[]){
        $total = 0;
        $clean_notes = [];
        if(count($notes)!=4){
            throw new Exception("Error, las notas no están completas. En caso de no 
                                contener notas en un corte coloque 0.", 1);
        }
        
        foreach($notes as $note){
            $note_sanitized = filter_var($note, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            
            if($note_sanitized === false || !is_numeric($note_sanitized)){
                throw new Exception("Las notas no son válidas.", 1);
            }

            $note = (float)$note_sanitized;
            if($note<0 || $note>20){
                throw new Exception("Las notas deben estar en el rango de 0 a 20 puntos.", 1); 
            }
            $total+=$note;
            $clean_notes[] = $note;
        }
        
        $definitiva = $total/4;
        return ['notes' => $clean_notes, 'definitiva' => $definitiva];
    }

    public function setNotes(string $cedula, array $notes = []){
        try{
            $cedula = $this->validateCedula($cedula);
            $notes = $this->validateNotes($notes);

            if(!$cedula || !$notes){
                throw new Exception("Se ha producido un error.", 1);
            }
                         
            $sql = "INSERT INTO calificaciones VALUES (:cedula, :id_materia, :corte1, 
                    :corte2, :corte3, :corte4, :definitiva);";
                            
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula);
            $cursor->bindParam(':id_materia', $this->id_materia);
            $cursor->bindParam(':corte1', $notes['notes'][0]);
            $cursor->bindParam(':corte2', $notes['notes'][1]);
            $cursor->bindParam(':corte3', $notes['notes'][2]);
            $cursor->bindParam(':corte4', $notes['notes'][3]);
            $cursor->bindParam('definitiva', $notes['definitiva']);
                            
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

    public function getNotes(string $cedula){
        try{
            $cedula = $this->validateCedula($cedula);

            $sql = "SELECT primer_corte, segundo_corte, tercer_corte, cuarto_corte, 
                    nota_definitiva FROM calificaciones WHERE cedula = :cedula;";
           
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula);

            if($cursor->execute()){
                return $cursor->fetch(PDO::FETCH_ASSOC);
            }else{
                return [];
            }
        }catch (\Throwable $th) {
            die("Error: ".$th->getMessage());
        }
    }

    public function updateNotes(string $cedula, $notes=[]){
        try{
            $cedula = $this->validateCedula($cedula);
            $notes = $this->validateNotes($notes);
    
            $sql = "UPDATE calificaciones SET primer_corte = :corte1, segundo_corte = :corte2, tercer_corte = :corte3, 
                    cuarto_corte = :corte4, nota_definitiva = :definitiva WHERE cedula = :cedula";
            
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':corte1', $notes['notes'][0]);
            $cursor->bindParam(':corte2', $notes['notes'][1]);
            $cursor->bindParam(':corte3', $notes['notes'][2]);
            $cursor->bindParam(':corte4', $notes['notes'][3]);
            $cursor->bindParam('definitiva', $notes['definitiva']);
            $cursor->bindParam(':cedula', $cedula);
    
            if($cursor->execute()){
                echo "Las notas se actualizaron con éxito.";
            }else{
                throw new Exception( "Las notas no pudieron ser actualizadas.", 1);
            }
        }catch (\Throwable $th) {
            die("Error: ".$th->getMessage());
        }
    }
}