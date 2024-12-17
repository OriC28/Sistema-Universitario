const button_student = document.getElementById("button-student");
const button_teacher = document.getElementById("button-teacher");


button_student.addEventListener("click", ()=>{
    window.location.href = "../views/loginStudent.php";
});


button_teacher.addEventListener("click", ()=>{
    window.location.href = "../views/loginTeacher.php";
});