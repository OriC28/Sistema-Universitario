<?php

require_once './model/TeacherModel.php';

class TeacherController{
    public function login_teacher(){
        require_once "./views/loginTeacher.php";
    }
    public function getTeacher(){
        $cedula = $_POST['cedula'];
        $password = $_POST['password'];
        $teacher = new TeacherModel($cedula, $password);

        $result = $teacher->getTeacher();
    }
}