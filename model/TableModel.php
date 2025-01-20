<?php

require_once "BDModel.php";

/**
* Modelo que obtiene el listado de estudiantes que se mostrarán en la tabla de la vista mainTeacher.php
*
*/
class TableModel{
    private $conn;
    private $conn_object;

    public function __construct(){
        
        # ESTABLECIENDO LA CONEXIÓN A LA BASE DE DATOS 
        $config = include("./config/config.php");
        $this->conn_object = new BDModel($config);
        $this->conn = $this->conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }
    /**
    * Obitene todos los estudiantes registrados en la base de datos.
    *
    * @return array estudiantes registrados en la base de datos
    * @throws Exception Si no obtiene los datos de los estudiantes 
    */
    public function getAllStudents(): array{
        try{
            $cursor = $this->conn->prepare("SELECT * FROM estudiantes;");
            $cursor->execute();
            
            return $cursor->fetchAll(PDO::FETCH_ASSOC);

        }catch(\PDOException $e){
            throw new Exception("Error al obtener estudiantes: " . $e->getMessage(), $e->getCode());
        }finally{
            $this->conn_object->close();
        }
    }
}

?>