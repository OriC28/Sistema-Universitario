<?php
/**
 * Modelo de datos para las vistas que requieran información del profesor y la materia que imparte.
 */
class TeacherDataModel{
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
     * Obtiene el nombre de la materia que imparte el profesor.
     * 
     * @return string nombre de la materia 
     * @throws Exception si ocurre un error al obtener los datos
     */ 
    public function getSubject(): string{
        try{
            $sql = "SELECT nombre_materia FROM materias WHERE id_materia = :id_materia;";
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':id_materia', $this->id_materia, PDO::PARAM_INT);
            if($cursor->execute()){
                $subject = $cursor->fetch(PDO::FETCH_ASSOC);
                if(!$subject){
                    throw new Exception("Ocurrió algo inesperado con los datos de esta vista.", 1);
                }
                return  $subject['nombre_materia'];
            }
        }catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
        }
    }
    /**
     * Obtiene el nombre completo del profesor que imparte la materia.
     * 
     * @return string nombre completo del profesor
     * @throws Exception si ocurre un error al obtener los datos
     */
    public function getTeacherName(): string{
        try{
            $sql = "SELECT primer_nombre_profesor, segundo_nombre_profesor, 
            primer_apellido_profesor, segundo_apellido_profesor
            FROM profesores WHERE id_materia = :id_materia;";

            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':id_materia', $this->id_materia, PDO::PARAM_INT);
            if($cursor->execute()){
                $data = $cursor->fetch(PDO::FETCH_ASSOC);
                if(!$data){
                    throw new Exception("Ocurrió algo inesperado con los datos de esta vista.", 1);
                }
                $fullNameTeacher =  $data['primer_nombre_profesor'] . 
                                ' ' . $data['segundo_nombre_profesor'] . 
                                ' ' . $data['primer_apellido_profesor'] . 
                                ' ' . $data['segundo_apellido_profesor'];
                return $fullNameTeacher;
            }
        }catch (\Throwable $th){
            throw new Exception($th->getMessage(), 1);
        }
    }
}


