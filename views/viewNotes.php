<?php
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    require_once 'C:\xampp\htdocs\Sistema-Universitario\views\templates\sanitizeFile.php';
    
    Session::startSession();
     
    define('BASE_URL', '/Sistema-Universitario/');

    if(!isset($_SESSION['logged-in-student']) || empty($_SESSION['logged-in-student']) || !isset($_SESSION['rol']) || empty($_SESSION['rol'])){
        if(!$_SESSION['logged-in-student'] || $_SESSION['rol'] !== 'estudiante'){
            http_response_code(403);
            throw new Exception("Acceso denegado (Error 403).", 1);
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets\css\style_student.css?v=<?php echo time(); ?>" />
    <title>Calificaciones</title>
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
            <a href="<?= BASE_URL?>views/contactData.php">Agregar datos de contacto</a>
        </div>
        <div class="separator-menu"></div>
        <div class="function">
            <span><img src="assets\icons\calificaciones.png" alt="icon-calificaciones"/></span>
            <a href="<?= BASE_URL?>index.php?controller=viewerNote&action=viewNotes">Ver calificaciones</a>
        </div>
    </aside>

    <main>
        <div class="container-grid">
            <div class="header-inside-main">
                <h1>Calificaciones</h1>
                <div class="separator"></div>
            </div>

            <div class="div-white">
                <div class="div-flex">
                <h3>Materia: <?= sanitizeData($subject); ?></h3>
                <h3>Docente: <?=sanitizeData($teacher_name);?></h3>
            </div>
                <div class="div-flex2">
                <!-- BLOQUES DE LAS NOTAS -->
                    <?php if (!empty($notes)): ?>
                        <div class="notes">
                            <label for="">Corte I</label>
                            <h1><?= htmlspecialchars($notes['primer_corte'] ?? 0) ?></h1>
                        </div>
                        <div class="notes">
                            <label for="">Corte II</label>
                            <h1><?= htmlspecialchars($notes['segundo_corte'] ?? 0) ?></h1>
                        </div>
                        <div class="notes">
                            <label for="">Corte III</label>
                            <h1><?= htmlspecialchars($notes['tercer_corte'] ?? 0) ?></h1>
                        </div>
                        <div class="notes">
                            <label for="">Corte IV</label>
                            <h1><?= htmlspecialchars($notes['cuarto_corte'] ?? 0) ?></h1>
                        </div>
                        <div class="notes">
                            <label for="">Definitiva</label>
                            <h1><?= htmlspecialchars(round(
                                ($notes['primer_corte'] + 
                                 $notes['segundo_corte'] + 
                                 $notes['tercer_corte'] + 
                                 $notes['cuarto_corte']) / 4, 2)); ?></h1>
                        </div>
                    <?php else: ?>
                        <p>No hay calificaciones disponibles.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>Copyright 2024 - Hecho por la demencia</p>
    </footer>
</body>
</html>