<?php

require_once './model/TableModel.php';

class tableController{

    public function mainTeacher(){
        $this->getAllStudents();
    }

    public function getAllStudents(){
        $model_students = new TableModel();
        $students = $model_students->getAllStudents();
        require_once 'views/mainTeacher.php';
    }
}
?>