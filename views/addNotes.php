<?php
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    
    Session::startSession();
    
    define('BASE_URL', '/Sistema-Universitario/');

    if(!isset($_SESSION['logged-in-teacher']) || empty($_SESSION['logged-in-teacher']) || !isset($_SESSION['rol']) || empty($_SESSION['rol'])){
        if(!$_SESSION['logged-in-teacher'] || $_SESSION['rol'] !== 'profesor'){
            header('Location: '.BASE_URL.'views/loginTeacher.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/styles_edit_add_notes.css?v=<?php echo time(); ?>" />
    <title>Agregar calificaciones</title>
</head>
<body>
    <!--HEADER-->
    <header>
        <div class="container-admin">
            <h1>DOCENTES</>
            
        </div>
        <a class="button-logout" href="views/templates/logout.php">Cerrar Sesión</a>
    </header>
    <!--CONTENIDO-->
    <main>
        <!--SUB-HEADER-->
        <?php require_once "views/templates/sub_header.php"; ?>
        <!--SEPARADOR-->
        <div class="separator"><p></p></div>

        <!--DATOS DE LA MATERIA Y DOCENTE-->
        <div class="container-subject">
            <h3>Materia: <?= htmlspecialchars($subject);?></h3>
            <h3>Docente: <?=htmlspecialchars($teacher_name);?></h3>
        </div>
        <!--INGRESO DE LAS NOTAS POR CORTE-->
        <div class="container-form">
            <form action="<?=BASE_URL?>index.php?controller=note&action=setNotes" method="post">
                <div class="container-notes">
                    <!--CORTES-->
                    <div class="field">
                        <h3 for="">Corte I</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte1" required>
                    </div>
                    <div class="field">
                        <h3 for="">Corte II</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte2" required>
                    </div>
                    <div class="field">
                        <h3 for="">Corte III</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte3" required>
                    </div>
                    <div class="field">
                        <h3 for="">Corte IV</h3>
                        <input class="input-corte" type="number" pattern="[0-9]{1,2}" step="0.1" min="0" max="20" name="corte4" required>
                    </div>
                </div>
                <!--BOTÓN PARA ENVIAR EL FORMULARIO-->
                <input class="button-right" type="submit"  name="submit" value="Guardar">
            </form>
        </div>
    </main>
    <!--FOOTER-->
    <footer>Copyright 2024 - Hecho por la demencia</footer>
</body>
</html>