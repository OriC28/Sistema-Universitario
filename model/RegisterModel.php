<?php

class RegisterModel{
    private $conn;

    public function __construct(){
        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();

        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }
    public function registerUser(User $user){
        $sql = "INSERT INTO usuarios VALUES (:cedula, :clave, :rol);";
        $cursor = $this->conn->prepare($sql);
        
        $cedula = $user->getCedula();
        $password = $user->getPassword();
        $rol = $user->getRol();

        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        $cursor->bindParam(':clave', $password, PDO::PARAM_STR);
        $cursor->bindParam(':rol', $rol, PDO::PARAM_STR);
        if($cursor->execute()){
            return true;
        }
        return false;
    }

    public function registerStudent(User $user){
        $sql = "INSERT INTO estudiantes VALUES (:cedula, :primer_nombre, :segundo_nombre, :primer_apellido, :segundo_apellido, :telefono, :correo);";
        $cursor = $this->conn->prepare($sql);

        $cedula = $user->getCedula();
        $first_name =  $user->getNames()[0];
        $second_name =  $user->getNames()[1];
        $first_last_name = $user->getLastNames()[0];
        $second_last_name = $user->getLastNames()[1];
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
        }
        return false;
    }

}