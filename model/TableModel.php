<?php

require_once "BDModel.php";

class TableModel{
    private $conn;
    private $conn_object;

    public function __construct(){
        $config = include("./config/config.php");
        $this->conn_object = new BDModel($config);
        $this->conn = $this->conn_object->connect();
    }
    public function getAllStudents(){
        try{
            $cursor = $this->conn->prepare("SELECT * FROM estudiantes;");
            if($cursor->execute()){
                return $cursor->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return [];
            }
        } catch (\Throwable $th){
            die("No se pudieron obtener los datos de los estudiantes.");
        }finally{
            $this->conn_object->close();
        }
    }
}