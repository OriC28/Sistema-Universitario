<?php 
/**
 * Modelo de la vista de perfil de estudiante
 */
class ProfileStudentModel{
    private $conn;
    private $conn_object;

    public function __construct(){

        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $this->conn_object = new BDModel($config);
        $this->conn = $this->conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }
    /**
     * Obtiene los datos de un estudiante
     * @param int $cedula identificador único del estudiante
     * @return array
     * @throws Exception si no se encuentran los datos
     */
    public function getStudentData(int $cedula){
        try{
            # PREPARANDO LA CONSULTA Y SUS PARÁMETROS
            $sql = "SELECT * FROM estudiantes WHERE cedula = :cedula";
            
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            
            # VERIFICAR SI SE REALIZÓ LA CONSULTA
            if(!$cursor->execute()){
                throw new Exception("Datos no disponibles.", 1);  
            }
            return $cursor->fetch(PDO::FETCH_ASSOC);
        }catch (\Throwable $th) {
           die($th->getMessage());
        }finally{
            $this->conn_object->close();
        }
    }
}

?>