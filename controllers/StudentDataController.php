<?php

require_once "./model/StudentDataModel.php";
require_once "./model/NoteModel.php";

class StudentDataController{

    private function decrypt_data(string $encrypted, $key, $iv){
        return openssl_decrypt(base64_decode($encrypted), "aes-256-cbc", $key, 0, $iv);
    }

    public function getRowData(){
        if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['n']) && !empty($_GET['n']) && 
            isset($_GET['site']) && !empty($_GET['site'])){

            include("./config/keys.php"); #<-- INCLUIR LAS KEYS NECESARIAS PARA DESENCRIPTAR LOS DATOS
            
            # DESENCRIPTADO DE DATOS
            $cedula = $this->decrypt_data($_GET['id'], $key, $iv);
            $name = $this->decrypt_data($_GET['n'], $key, $iv);
            $site_redirect = $_GET['site'];

            # VALIDAR CÉDULA
            if(strlen(trim($cedula)) == 7 || strlen(trim($cedula)) == 8){
                if(filter_var($cedula,FILTER_VALIDATE_INT)){
                    $cedula = trim($cedula);
                     # VALIDAR NOMBRE COMPLETO Y SITIO AL CUAL REDIRIGIR
                    if(preg_match('/^[a-zA-Zs áéíóúÁÉÍÓÚñÑ]+\s/', $name) && preg_match('/^[a-zA-Zs]/', $site_redirect)){
                        $name = trim(htmlspecialchars($name));
                        $site_redirect = trim(htmlspecialchars($site_redirect));
                    }
                }
            }else{
                http_response_code(404);
                die("Error 404: Ruta no encontrada.");
            }
        }else{
            header("Location: index.php?controller=table&action=mainTeacher");
            exit();
        }
        $notes_user = new NoteModel();
        
        if($site_redirect == "editnotes"){

            $notes = $notes_user->getNotes($cedula);
            require_once "views/editNotes.php";
            require_once "views/templates/sub_header.php";

        }elseif($site_redirect == "addnotes"){
            
            require_once "views/addNotes.php";
            require_once "views/templates/sub_header.php";
        }

        $model = new StudentDataModel();
        $model->getRowData($cedula, $name);
    }
}

?>