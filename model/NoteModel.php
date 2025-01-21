<?php

/**
* Modelo para manipular las calificaciones de los estudiantes.
*
*/
class NoteModel{
   private $id_materia;
   private $conn;

    public function __construct(){
        $this->id_materia = 1;

        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }
     /**
    * Valida la cédula de acuerdo a la longitud y si es un valor entero.
    *
    * @return int si la cédula cumple lo necesario para considerarse válida
    * @param int $cedula identificador único del estudiante
    * @throws Exception Si la cédula no es válida
    */
    public function validateCedula(int $cedula): int{
        if(strlen($cedula) == 7 || strlen($cedula) == 8){
            if(filter_var($cedula, FILTER_VALIDATE_INT)){
                $cedula = (int)$cedula;
                return $cedula;
            }
        }else{
            throw new Exception("Cédula inválida.", 1);
        }
    }
    /**
    * Verifica la existencia de la cédula del estudiante en la tabla indicada.
    *
    * @return boolean true si la cédula es encontrada en la base de datos 
    * @param int $cedula identificador único del estudiante
    * @param string $table nombre de la tabla donde se buscará la cédula
    */
    public function existsCedula(int $cedula, string $table): bool{
        $sql = "SELECT * FROM calificaciones WHERE cedula = :cedula;"; 
        if($table == 'estudiantes'){
            $sql = "SELECT * FROM estudiantes WHERE cedula = :cedula;";
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
        foreach($notes as $note){
            if($note<0 || $note>20){
                throw new Exception("Las notas deben estar en el rango de 0 a 20 puntos.", 1); 
            }
        }

        $clean_notes = filter_var_array($notes, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $definitiva = array_sum($clean_notes)/4;
        return ['notes' => $clean_notes, 'definitiva' => $definitiva];
    }

    /**
     * Registra las notas de un estudiante en la base de datos.
     * 
     * @param int $cedula identificador único del estudiante
     * @param array $notes notas del estudiante
     * @throws Exception Si la cédula y notas no son válidas o si existe un error al registrar las notas
     */
    public function setNotes(int $cedula, array $notes = []): void{
        try{
            $cedula = $this->validateCedula($cedula);
            $notes = $this->validateNotes($notes);

            # VERIFICAR SI LA CÉDULA Y LAS NOTAS SON VALIDAS
            if($cedula && $notes){
                # VERIFICAR SI EL ESTUDIANTE CON LA CÉDULA INGRESADA YA CUENTA CON LAS NOTAS CARGADAS
                if($this->existsCedula($cedula, 'calificaciones')){
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
    public function getNotes(int $cedula): array|false{
        try{
            $cedula = $this->validateCedula($cedula);

            # VERIFICAR SI LA CÉDULA ES VALIDA
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
    public function updateNotes(int $cedula, array $notes=[]): void{
        try{
            $cedula = $this->validateCedula($cedula);
            $notes = $this->validateNotes($notes);
            
            if(!$this->existsCedula($cedula, 'calificaciones')){
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