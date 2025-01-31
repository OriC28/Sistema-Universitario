<?php
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    
    Session::startSession();
    
    define('BASE_URL', '/Sistema-Universitario/');

    if(!isset($_SESSION['logged-in-student']) || empty($_SESSION['logged-in-student']) || !isset($_SESSION['rol']) || empty($_SESSION['rol'])){
        if(!$_SESSION['logged-in-student'] || $_SESSION['rol'] !== 'estudiante'){
            header('Location: '.BASE_URL.'views/loginStudent.php');
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets\css\style_student.css?v=<?php echo time(); ?>" />
    <title>Perfil</title>
</head>

<body>
    <header>
        <h1>ESTUDIANTES</h1>
        <a class="button-logout" href="views/templates/logout.php">Cerrar Sesión</a>
    </header>

    <!-- MENÚ -->
    <aside>
        <div class="function">
            <span><img src="assets\icons\perfil.png" alt="icon-profile"/></span>
            <a href="<?= BASE_URL?>index.php?controller=profileStudent&action=getStudentData">Perfil</a>
        </div>
        <div class="separator-menu"></div>
        <div class="function">
            <span><img src="assets\icons\agregar.png" alt="icon-personal-data"/></span>
            <a href="<?= BASE_URL?>views\contactData.php">Agregar datos de contacto</a>
        </div>
        <div class="separator-menu"></div>
        <div class="function">
            <span><img src="assets\icons\calificaciones.png" alt="icon-calificaciones"/></span>
            <a href="<?= BASE_URL?>index.php?controller=viewerNote&action=viewNotes">Ver calificaciones</a>
        </div>
    </aside>
    <!-- --CONTENIDO-- -->
    <main>
        <div class="container-grid">
            <!-- BLOQUE DEL ICONO Y NOMBRE DEL ESTUDIANTE -->
            <div class="header-inside-main">
                <h1>Perfil</h1>
                <div class="separator"></div>
                <div class="profile">
                <div class="icon">
                    <img id="profile-main" src="assets\icons\perfil1.png" alt="icon-profile">
                </div>
                <div class="name">
                    <h2>
                        <?= 
                            htmlspecialchars($data['primer_nombre_estudiante']).
                        " ".htmlspecialchars($data['segundo_nombre_estudiante']).
                        " ".htmlspecialchars($data['primer_apellido_estudiante']).
                        " ".htmlspecialchars($data['segundo_apellido_estudiante']);
                        ?>
                    </h2>
                </div>
                </div>
                <div class="separator"></div>
            </div>
            
            <!-- BLOQUE BLANCO CON SU RESPECTIVO CONTENIDO -->
            <div class="div-white">
                <div class="data"> 
                    <h3>Cédula:</h3><label for=""><?= htmlspecialchars($data['cedula']); ?></label>
                </div>
                <div class="data"> 
                    <h3>Teléfono:</h3><label for=""><?= htmlspecialchars($data['telefono']);?></label>
                </div>
                <div class="data"> 
                    <h3>Correo electrónico:</h3>
                    <label for="">
                        <?= htmlspecialchars($data['correo_electronico']);?>
                    </label>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>Copyright 2024 - Hecho por la demencia</p>
    </footer>
</body>
</html>