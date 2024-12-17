<?php

require_once "BDModel.php";

class User{
    private $conn;
    private $cedula;
    private $password;
    private $confirm_password;
    private $rol;

    private $first_name;
    private $second_name;
    private $first_lastname;
    private $second_lastname;

    public function __construct(){
        $this->cedula = "31525588";
        $this->password = "12345";
        $this->confirm_password = "12345";
        $this->rol = "estudiante";

        $this->first_name = "Oriana";
        $this->second_name = "Guadalupe";
        $this->first_lastname = "Colina";
        $this->second_lastname = "Perea";

        $config = require_once("./config/config.php");
        $connection_object = new BDModel($config);
        $this->conn = $connection_object->connect();
    }

    public function InsertUser(){
        try{
            if($this->password != $this->confirm_password){
                throw new Exception("Error Processing Request", 1);
            }

            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuarios (cedula, clave, rol) VALUES (:cedula, :password, :rol);";
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $this->cedula);
            $cursor->bindParam(':password', $this->password);
            $cursor->bindParam(':rol', $this->rol);
            if($cursor->execute()){
                $this->personalData();
                echo "El usuario se registró correctamente.";
            }else{
                echo "Ocurrió un error al registrar el usuario";
            }
        } catch (\Throwable $th) {
            die("Error: ".$th->getMessage());
        }
    }

    public function updatePhone(string $phone){
        try{
            if(strlen($phone) == 11 && preg_match('/^04(12|14|24|26)/', $phone)){
                $sql = "UPDATE estudiantes SET telefono = :phone WHERE cedula = :cedula;";
                $cursor = $this->conn->prepare($sql);
                $cursor->bindParam(':phone', $phone);
                $cursor->bindParam(':cedula', $this->cedula);
                if($cursor->execute()){
                    echo "Número de teléfono actualizado correctamente.";
                }else{
                    echo "No se pudo actualizar el número de teléfono.";
                }
            }else{
                throw new Exception("Número de teléfono inválido", 1);
            }
        }catch (\Throwable $th) {
            die("Error: ".$th->getMessage());
        }
    }

    public function updateEmail(string $email){
        try{
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = "UPDATE estudiantes SET correo_electronico = :email WHERE cedula = :cedula;";
                $cursor = $this->conn->prepare($sql);
                $cursor->bindParam(':email', $email);
                $cursor->bindParam(':cedula', $this->cedula);
                if($cursor->execute()){
                    echo "Correo actualizado correctamente";
                }else{
                    echo "No se pudo actualizar el correo electrónico.";
                }
            }else{
                throw new Exception("Correo electrónico inválido", 1);
            }
        }catch(\Throwable $e){
            die("Error: ".$e->getMessage());
        }
    }


    public function personalData(){
        if(!empty($this->first_name) && !empty($this->second_name) && !empty($this->first_lastname) && !empty($this->second_lastname)){
            $sql = "INSERT INTO estudiantes (cedula, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido) VALUES (:cedula, :first_name, :second_name, :first_lastname, :second_lastname);";

            $cursor = $this->conn->prepare($sql);

            $cursor->bindParam(':cedula', $this->cedula);
            $cursor->bindParam(':first_name', $this->first_name);
            $cursor->bindParam(':second_name', $this->second_name);
            $cursor->bindParam(':first_lastname', $this->first_lastname);
            $cursor->bindParam(':second_lastname', $this->second_lastname);
            if($cursor->execute()){
                echo "Los datos personales se registraron correctamente";
            }else{
                echo "No se pudo agregar los datos personales";
            }
        }
    }
}