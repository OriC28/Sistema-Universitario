<?php 

class StudentDataModel{
    private $conn;
    private $conn_object;

    public function __construct(){
        $config = include("./config/config.php");
        $this->conn_object = new BDModel($config);
        $this->conn = $this->conn_object->connect();
    }

    public function getRowData(string $cedula, string $name){
        try{
            # PREPARANDO LA CONSULTA Y SUS PARÁMETROS
            $sql = "SELECT * FROM estudiantes WHERE cedula = :cedula";
            
            $cursor = $this->conn->prepare($sql);
            $cursor->bindParam(':cedula', $cedula, PDO::PARAM_INT);
            # VERIFICAR SI SE REALIZÓ LA CONSULTA
            if($cursor->execute()){
                # VERIFICAR SI EXISTE EL ESTUDIANTE CON LA CÉDULA SUMINISTRADA
                if($cursor->fetch(PDO::FETCH_ASSOC)){
                        $_SESSION['cedula'] = $cedula;
                        $_SESSION['name'] = $name;
                }else{
                    http_response_code(404);
                    die("Error 404: Ruta no encontrada.");
                }
            }else{
                echo "El estudiante no existe en la base de datos.";
            }
        }catch (\Throwable $th) {
           die("Ocurrió un error: ".$th->getMessage());
        }finally{
            $this->conn_object->close();
        }
    }
}

?>