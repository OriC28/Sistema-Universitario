<?php

require_once "BDModel.php";

class tableModel{
    private $conn;
    
    public function __construct(){
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();
    }
    public function getAllStudents(){
        $sql = "SELECT * FROM estudiantes;";
        $cursor = $this->conn->prepare($sql);

        if($cursor->execute()){
            return $cursor->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return [];
        }
    }
}