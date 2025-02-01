<?php

/**
*
* VIEW: ./views/viewNotes.php
* MODEL: ./model/NoteModel.php
* BASE DE DATOS: sistema_universitario
*
*/

/**
* Controlador conectado al modelo NoteModel. Permite obtener las notas del estudiante que inició sesión.
*
*/

require_once "./model/NoteModel.php";
require_once "./model/User.php";
require_once "./model/TeacherDataModel.php";


class ViewerNoteController{
    /**
    * Verifica si el usuario se encuentra en una sesión y valida la cédula.
    *
    * @return int identificador único del estudiante validado
    * @param NoteModel instancia del modelo NoteModel
    */
    public function existsStudentInSession(): int {
        if(!isset($_SESSION['cedula']) || empty($_SESSION['cedula'])){
            http_response_code(403);
            throw new Exception("Acceso denegado (Error 403).", 1);
        }
        $cedula = htmlspecialchars($_SESSION['cedula']);
        return User::validateCedula($cedula);
    }
    /**
    * Llama al método existsStudentInSession() y emplea el método getNotes() dentro del modelo NoteModel para obtener las notas
    * del estudiante de la sesión actual.
    *
    * @return void identificador único del estudiante
    */
    public function viewNotes(): void{
        try{
            $model = new NoteModel();
            $cedula = $this->existsStudentInSession();
            $notes = $model->getNotes($cedula);

            # DATOS DEL DOCENTE Y NOMBRE DE LA MATERIA
            $teacherModel = new TeacherDataModel();
            $subject = $teacherModel->getSubject();
            $teacher_name = $teacherModel->getTeacherName();
        
            include('views/viewNotes.php');
        }
        catch(Exception $e){
            echo '<p>Error: '.$e->getMessage().'<p>';
        }
    }
}
?>