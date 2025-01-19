<?php

require_once "BDModel.php";

class TeacherModel{
    private $conn;
    private $cedula;
    private $password;
    private $rol;
    private $config;

    public function __construct(string $cedula, string $password){
        $this->cedula = $cedula;
        $this->password = $password;

        $this->config = include("./config/config.php");
        $conn_object = new BDModel($this->config);
        $this->conn = $conn_object->connect();
    }

    public function getTeacher(){
        try{
            $sql = "SELECT cedula, password, rol FROM users WHERE cedula = :cedula;";
                
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $this->cedula);
           
            if($cursor->execute()){
                $user_data = $cursor->fetch(PDO::FETCH_ASSOC);
                if($user_data){
                    if(password_verify($this->password, $user_data['password']) && $user_data['rol'] == 'profesor'){
                        # header("Location: "); # <--- Redirigir al profesor
                        exit();
                    }else{
                        echo "Cedula o contraseña incorrectos";
                    }
                }
                else{
                    echo "Cedula o contraseña incorrrectos.";
                }
            }
        }catch (\Throwable $th) {
            die("Error: ".$th->getMessage());
        }  
    }
}
