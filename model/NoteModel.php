<?php

require_once 'User.php';

/**
* Modelo para manipular las calificaciones de los estudiantes.
*
*/
class NoteModel extends User{
   private $id_materia;
   private $conn;

    public function __construct(){
        $this->id_materia = 1;

        # Estableciendo la conexión a la base de datos
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }

     /**
    * Verifica la existencia de la cédula del estudiante en la tabla Calificaciones.
    *
    * @return boolean true si la cédula es encontrada en la base de datos 
    * @param int $cedula identificador único del estudiante
    */
    public function existsCedula(int $cedula, bool $flag=false): bool{
        if($flag){
            $sql = "SELECT * FROM usuarios WHERE cedula = :cedula";            
        }else{
            $sql = "SELECT * FROM calificaciones WHERE cedula = :cedula";
        }
        
        $cursor = $this->conn->prepare($sql);
        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        if($cursor->execute()){
            if($cursor->fetch(PDO::FETCH_ASSOC)){
                return true;
            }
        }
        return false;
    }
    
    /**
    * Valida y sanitiza cada nota del estudiante de forma individual.
    *
    * @return float si la nota cumple lo necesario para considerarse válida
    * @param float $note nota del estudiante
    * @throws Exception Si alguna nota no es de tipo flotante o numérica y si no se encuentra en el rango establecido
    */
    private function validateSingleNote(float $note): float{
        $note_sanitized = filter_var($note, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if($note_sanitized === false || !is_numeric($note_sanitized)){
            throw new Exception("Las notas no son válidas.", 1);
        }

        $note = (float)$note_sanitized;

        if($note<0 || $note>20){
            throw new Exception("Las notas deben estar en el rango de 0 a 20 puntos.", 1); 
        }
        return $note;
    }
   /**
    * Valida y sanitiza las notas del estudiante.
    *
    * @param array $notes notas del estudiante
    * @return array con las notas validadas y la nota definitiva
    * @throws Exception Si las notas no están completas o si alguna nota no es válida
    */
    public function validateNotes(array $notes=[]): array{
        if(count($notes)!=4){
            throw new Exception("Las notas no están completas. En caso de no 
                                contener notas en un corte coloque 0.", 1);
        } 
        $clean_notes = array_map([$this, 'validateSingleNote'], $notes);

        $definitiva = array_sum($notes)/4;
        return ['notes' => $clean_notes, 'definitiva' => $definitiva];
    }

    /**
     * Registra las notas de un estudiante en la base de datos.
     * 
     * @param int $cedula identificador único del estudiante
     * @param array $notes notas del estudiante
     * @throws Exception Si la cédula y notas no son válidas o si existe un error al registrar las notas
     */
    public function setNotes(string $cedula, array $notes = []): void{
        try{
            $cedula = User::validateCedula($cedula);
            $notes = $this->validateNotes($notes);

            # VERIFICAR SI LA CÉDULA Y LAS NOTAS SON VALIDAS
            if($cedula && $notes){
                # VERIFICAR SI EL ESTUDIANTE CON LA CÉDULA INGRESADA YA CUENTA CON LAS NOTAS CARGADAS
                if($this->existsCedula($cedula)){
                    throw new Exception("El estudiante ya tiene las notas cargadas.", 1);
                }

                $sql = "INSERT INTO calificaciones VALUES (:cedula, :id_materia, :primer_corte, 
                        :segundo_corte, :tercer_corte, :cuarto_corte, :definitiva);";
                
                $cursor = $this->conn->prepare($sql);
                $cursor->bindParam(':cedula', $cedula);
                $cursor->bindParam(':id_materia', $this->id_materia);
                $cursor->bindParam(':primer_corte', $notes['notes'][0]);
                $cursor->bindParam(':segundo_corte', $notes['notes'][1]);
                $cursor->bindParam(':tercer_corte', $notes['notes'][2]);
                $cursor->bindParam(':cuarto_corte', $notes['notes'][3]);
                $cursor->bindParam('definitiva', $notes['definitiva']);
                                
                if(!$cursor->execute()){
                    throw new Exception( "Las notas no pudieron ser agregadas.", 1);
                }
                echo "Las notas se agregaron con éxito";
            }
        }catch(\PDOException $e){
            throw new Exception("Error al intentar registrar las notas: " . $e->getMessage(), $e->getCode());
        }
    }   
    /**
    * Captura todas las notas de un estudiante de acuerdo a su cédula en la base de datos.
    *
    * @return array|false las notas del estudiante o falso si no se encontró una coincidencia
    * @param int $cedula identificador único del estudiante
    * @throws Exception Si no es posible obtener las notas o si la cédula no es correcta
    */
    public function getNotes(string $cedula): array|false{
        try{
           
            # VERIFICAR SI LA CÉDULA ES VALIDA
            $cedula = User::validateCedula($cedula);

            if($cedula){
                
                $sql = "SELECT primer_corte, segundo_corte, tercer_corte, cuarto_corte, 
                    nota_definitiva FROM calificaciones WHERE cedula = :cedula;";

                $cursor = $this->conn->prepare($sql);
                $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
                $cursor->execute();
                
                return $cursor->fetch(PDO::FETCH_ASSOC);
            }
        }catch(\PDOException $e){
            throw new Exception("Error al obtener las notas: " . $e->getMessage(), $e->getCode());
        }
    }
    /**
    * Actualiza las notas de un estudiante de acuerdo a su cédula en la base de datos.
    *
    * @return void
    * @param int $cedula identificador único del estudiante
    * @param array $notes notas que reemplazarán a las que están en la base de datos
    * @throws Exception Si la cédula y notas no son válidas o si existe un error al actualizar las notas
    */
    public function updateNotes(string $cedula, array $notes=[]): void{
        try{
            $cedula = User::validateCedula($cedula);
            $notes = $this->validateNotes($notes);

            if(!$this->existsCedula($cedula)){
                throw new Exception("El estudiante no tiene notas cargadas.", 1);
            }
            
            # VERIFICAR SI LA CÉDULA Y LAS NOTAS SON VALIDAS
            if($cedula && $notes){

                $sql = "UPDATE calificaciones SET primer_corte = :primer_corte, segundo_corte = :segundo_corte, 
                        tercer_corte = :tercer_corte, cuarto_corte = :cuarto_corte, nota_definitiva = :definitiva WHERE cedula = :cedula";
            
                $cursor = $this->conn->prepare($sql);
                $cursor->bindParam(':primer_corte', $notes['notes'][0]);
                $cursor->bindParam(':segundo_corte', $notes['notes'][1]);
                $cursor->bindParam(':tercer_corte', $notes['notes'][2]);
                $cursor->bindParam(':cuarto_corte', $notes['notes'][3]);
                $cursor->bindParam('definitiva', $notes['definitiva']);
                $cursor->bindParam(':cedula', $cedula);
        
                if(!$cursor->execute()){
                    throw new Exception( "Las notas no pudieron ser actualizadas.", 1);
                }
                echo "Las notas se actualizaron con éxito.";
            }
        }catch(\PDOException $e){
            throw new Exception("Error al actualizar las notas: " . $e->getMessage(), $e->getCode());
        }
    }
}