<?php 

session_start();
if(!empty($_SESSION['cedula']) && !empty($_SESSION['name'])){
    $cedula = htmlspecialchars($_SESSION['cedula']);
    $name = htmlspecialchars($_SESSION['name']);
}

?>

<!--SUB-HEADER-->
<div class="student-data">
    <div class="container-name">
        <h2><?php echo $name; ?></h2>
    </div>
    <p>V-<?php echo $cedula; ?></p>
</div>