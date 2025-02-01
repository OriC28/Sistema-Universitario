<?php

class RegisterModel{
    private $conn;
    private $data;
    public function __construct(User $user){
        # ESTABLECIENDO CONEXIÓN A LA BASE DE DATOS
        $config = include("./config/config.php");
        $conn_object = new BDModel($config);
        $this->conn = $conn_object->connect();
        $this->data =  $this->fetchUserData($user);
        if(!$this->conn){
            throw new Exception("No se pudo establecer la conexión a la base de datos.", 1);  
        }
    }

    private function fetchUserData(User $user): array{
        return [
            'cedula' => $user->getCedula(),
            'first_name' => $user->getNames()[0] ?? null,
            'second_name' => $user->getNames()[1] ?? null,
            'first_last_name' => $user->getLastNames()[0] ?? null,
            'second_last_name' => $user->getLastNames()[1] ?? null,
            'password' => $user->getPassword(),
            'rol' => $user->getRol(),
        ];
    }

    public function validateDataRegister(): void{
        try{
            $cedula = $this->data['cedula'];
            $first_name = $this->data['first_name'];
            $second_name = $this->data['second_name'];
            $first_last_name = $this->data['first_last_name'];
            $second_last_name = $this->data['second_last_name'];
            $password = $this->data['password'];
        }catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);   
        }
    }

    public function existsUser(int $cedula){
        $sql = "SELECT COUNT(cedula) FROM usuarios WHERE cedula = :cedula;";
        $cursor = $this->conn->prepare($sql);

        $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        $cursor->execute();

        return $cursor->fetchColumn()>0;
    }


    public function registerUser(){

        $cedula = $this->data['cedula'];
        $password = $this->data['password'];
        $rol = $this->data['rol'];

        if($this->existsUser($cedula)){
            throw new Exception("El usuario ya se encuentra registrado.", 1);
        }
        try{
            $sql = "INSERT INTO usuarios (cedula, clave, rol) VALUES (:cedula, :clave, :rol);";
            $cursor = $this->conn->prepare($sql);
        
            $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            $cursor->bindParam(':clave', $password, PDO::PARAM_STR);
            $cursor->bindParam(':rol', $rol, PDO::PARAM_STR);

            return $cursor->execute();

        }catch(PDOException $e){
            throw new Exception("Error al registrar el usuario: ".$e->getMessage(), 1);
            
        }
    }

    public function registerStudent(){
        $sql = "INSERT INTO estudiantes VALUES (
                :cedula, 
                :primer_nombre, 
                :segundo_nombre, 
                :primer_apellido, 
                :segundo_apellido, 
                :telefono, 
                :correo
        );";

        $cursor = $this->conn->prepare($sql);

        $cedula = $this->data['cedula'];
        $first_name =  $this->data['first_name'];
        $second_name =  $this->data['second_name'];
        $first_last_name = $this->data['first_last_name'];
        $second_last_name = $this->data['second_last_name'];
        $password = $this->data['password'];
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
        throw new Exception("Error al registrar el estudiante.", 1);
    }
}