<?php

/**
*
* VIEW: ./views/editNotes.php
* VIEW: ./views/addNotes.php
* VIEW: ./views/templates/sub_header.php
* MODEL: ./model/NoteModel.php
* BASE DE DATOS: sistema_universitario
*
*/

require_once "./model/NoteModel.php";
require_once "./model/TeacherDataModel.php";
require_once "./model/Session.php";
require_once "./model/User.php";

/**
* Controlador conectado al modelo NoteModel. Permite cargar los datos (cédula, nombre y las notas) 
* del estudiante seleccionado y redirecciona al docente a la vista addNotes o editNotes de acuerdo al parámetro $site.
*
*/
class StudentDataController{
    /**
    * Descencripta los parámetros encriptados en la URL.
    *
    * @return string string desencriptado
    * @param string $encrypted dato encriptado
    * @param string $method sistema de cifrado
    * @param string $key clave criptográfica
    * @param string $iv vector de inicialización
    */
    private function decryptData(string $encrypted, string $method, string $key, string $iv):string{
        return openssl_decrypt(base64_decode($encrypted), $method, $key, 0, $iv);
    }
    /**
    * Valida cada parámetro pasado vía GET por la URL.
    *
    * @return boolean true si los parámetros existen
    * @param array $parameters parametros pasados por la URL
    */
    #valida
    private function validateGETParameters(array $parameters): bool{ 
        foreach ($parameters as $param){
            if(!isset($_GET[$param]) || empty($_GET[$param])){
                return false;
            }
        }
        return true;
    }
    /**
    * Inicia una sesión si no existe una y crea las variables de sesión cedula y name.
    *
    * @return void
    * @param string $cedula identificador único del estudiante
    * @param string $name nombre completo del estudiante
    */
    private function setSessionData(string $cedula, string $name): void {
        Session::startSession();
        Session::set('cedula', $cedula);
        Session::set('name', $name);
    }
    /**
    * Valida todos los datos recibidos (cedula, name y site) por la URL.
    *
    * @return array datos validados
    * @param string $cedula identificador único del estudiante
    * @param string $name nombre completo del estudiante
    * @param string $site_redirect nombre del sitio a redirigir
    * @throws Exception Si el nombre o el sitio son incorrectos.
    */
    private function validateData(int $cedula, string $name, string $site_redirect): array{
        if(!preg_match('/^[a-zA-Zs áéíóúÁÉÍÓÚñÑ]+\s/', $name)){
            throw new Exception("El nombre ingresado es incorrecto.", 1);
        }

        if(!preg_match('/^[a-zA-Zs]/', $site_redirect)){
            throw new Exception("El sitio a redigir no es correcto.", 1);
        }
        $notes_user = new NoteModel();

        $cedula_validated = User::validateCedula($cedula);

        if(!$notes_user->existsCedula($cedula_validated, true)){
            throw new Exception("La cédula no es válida.", 1);
        }
        $name = trim(htmlspecialchars($name));
        $site_redirect = trim(htmlspecialchars($site_redirect));
        
        if($cedula_validated && $name && $site_redirect){
            $this->setSessionData($cedula_validated, $name);
            return ['name' => $name, 
                    'cedula' => $cedula_validated,
                    'site' => $site_redirect,
                    'noteModelObject' => $notes_user];
        } 
    }
    /**
    * Llama a los métodos validateData() y decryptData().
    *
    * @return array datos desencriptados y validados
    */
    public function validateDecryptData(): array{
        include("./config/keys.php"); #<-- INCLUIR LAS KEYS NECESARIAS PARA DESENCRIPTAR LOS DATOS

        # DESENCRIPTADO DE DATOS
        $cedula = (int) htmlspecialchars($this->decryptData($_GET['id'],$method, $key, $iv));
        $name = $this->decryptData($_GET['n'], $method, $key, $iv);
        $site_redirect = $_GET['site'];

        return $this->validateData($cedula, $name, $site_redirect);
    }
    /**
    * Redirecciona al docente a la vista correspondiente de acuerdo al parámetro site y destina
    * los datos necesarios a cada una de ellas.
    *
    * @return void 
    * @param string $cedula identificador único del estudiante
    * @param string $name nombre completo del estudiante
    * @param string $site_redirect nombre del sitio a redirigir
    * @param NoteModel $notes_user instancia del modelo NoteModel
    * @throws Exception Si la ruta de dirección es inválida
    */
    private function setRedirectToView(string $cedula, string $name, string $site_redirect, NoteModel $notes_user): void{
        # DATOS DEL DOCENTE Y NOMBRE DE LA MATERIA
        $teacherModel = new TeacherDataModel();
        $subject = $teacherModel->getSubject();
        $teacher_name = $teacherModel->getTeacherName();
        
        if($site_redirect == "editnotes"){
            $notes = $notes_user->getNotes($cedula); 
            require_once "views/editNotes.php";
            require_once "views/templates/sub_header.php";

        }elseif($site_redirect == "addnotes"){
            require_once "views/addNotes.php";
            require_once "views/templates/sub_header.php";

        }else{
            throw new Exception("Ruta de redirección inválida.", 1);
        }
    }
    /**
    * Llama a los métodos validateGETParameters(), validateDecryptData(), setRedirectToView() y se emcarga de
    * obtener los datos del estudiante seleccionado de acuerdo a su cédula utilizando el modelo StudentDataModel
    * y su método getRowData().
    *
    * @return void 
    * @throws Exception Si ocurre una excepción en cualquier método llamado dentro de getRowData()
    */
    public function getRowData(): void{
        try{
            if($this->validateGETParameters(['id', 'n', 'site'])){

                $data = $this->validateDecryptData();
                if($data){
                    # DATOS
                    $cedula = $data['cedula'];
                    $name = $data['name'];
                    $site_redirect = $data['site'];
                    $notes_user = $data['noteModelObject'];

                    $this->setRedirectToView($cedula, $name, $site_redirect, $notes_user);
                }
            }else{
                throw new Exception("Ha ocurrido un error con la ruta.");
            }
        }catch(\Throwable $th){
            die($th->getMessage());
            http_response_code(500);
            exit();
        }
    }
}

?>