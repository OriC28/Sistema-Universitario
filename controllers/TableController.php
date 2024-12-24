<?php

/**
*
* VIEW: ./views/mainTeacher.php
* MODEL: ./model/TableModel.php
* BASE DE DATOS: sistema_universitario
*
*/
require_once './model/TableModel.php';

/**
* Controlador conectado al modelo TableModel. Permite obtener todos los estudiantes registrados para ser mostrados en 
* la vista principal del docente en formato de tabla.
*
*/
class tableController{
    /**
    * Llama al método getAllStudents();
    *
    * @return void 
    */
    public function mainTeacher(): void{
        $this->getAllStudents();
    }
    /**
    * Llama al método getAllStudents() dentro del modelo TableModel para luego incluir la vista mainTeacher.php en donde se
    * utilizarán los datos del arreglo $students.
    *
    * @return string string desencriptado
    */
    public function getAllStudents(): void{
        $model_students = new TableModel();
        $students = $model_students->getAllStudents();
        require_once 'views/mainTeacher.php';
    }
}
?>