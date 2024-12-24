<?php

/**
*
* VIEW: ./views/viewNotes.php
* MODEL: ./model/NoteModel.php
* BASE DE DATOS: sistema_universitario
*
*/

#include('./model/NoteModel.php');

/**
* Controlador conectado al modelo NoteModel. Permite obtener las notas del estudiante que inició sesión.
*
*/

class ViewerNoteController{
    /**
    * Verifica si el usuario se encuentra en una sesión y valida la cédula.
    *
    * @return int identificador único del estudiante validado
    * @param NoteModel instancia del modelo NoteModel
    */
    public function existsStudentInSession(NoteModel $modelObject): int {
        $cedula = htmlspecialchars($_SESSION['cedula']);
        if(!$cedula){
            throw new Exception("Usuario fuera de sesión.", 1);
        }
        return $modelObject->validateCedula($cedula);
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
            $cedula = $this->existsStudentInSession($model);
            $notes = $model->getNotes($cedula);

            include('views/viewNotes.php');
        }
        catch(Exception $e){
            echo '<p>Error: '.$e->getMessage().'<p>';
        }
    }
}
?>