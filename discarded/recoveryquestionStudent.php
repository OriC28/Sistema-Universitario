<!DOCTYPE html>
<html lang="es">
<?php define('BASE_URL', '/Sistema-Universitario/');?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets\css\style_student.css?v=<?php echo time(); ?>" />
    <title>Preguntas de seguridad</title>
</head>

<body>
    <header>
        <h1>ESTUDIANTES</h1>
        <input class="button-logout" type="button" value="Cerrar Sesión">
    </header>
    <!-- MENÚ -->
    <aside>
        <div class="function">
            <span><img src="../assets\icons\perfil.png" alt="icon-profile"/></span>
            <a href="profileStudent.php">Perfil</a>
        </div>
        <div class="separator-menu"></div>
        <div class="function">
            <span><img src="../assets\icons\agregar.png" alt="icon-personal-data"/></span>
            <a href="contactData.php">Agregar datos de contacto</a>
        </div>
        <div class="separator-menu"></div>
        <div class="function">
            <span><img src="../assets\icons\calificaciones.png" alt="icon-calificaciones"/></span>
            <a href="viewNotes.php">Ver calificaciones</a>
        </div>
        <div class="function">
            <span><img src="../assets\icons\modificar.png" alt="icon-recovery"/></span>
            <a href="recoveryquestionStudent.php">Modificar preguntas de seguridad</a>
        </div>
        
    </aside>
    <!-- CONTENIDO -->
    <main>
        <div class="container-grid">
            <!-- BLOQUE DE LA CABECERA DEL MAIN -->
            <div class="header-inside-main">
                <h1>Preguntas de seguridad</h1>
                <div class="separator"></div>
            </div>
            <!-- BLOQUE BLANCO CON SU RESPECTIVO CONTENIDO -->
            <div class="div-white">
                <div class="div-flex">
                        <form class="form-flex" action="" method="">
                            <div class="form-recovery">
                                <div class="div-recovery-password">
                                <label for="question1">Pregunta 1</label>
                                <input class="input-recovery" type="text" placeholder="¿Cuál es mi color favorito?" required>
                                <label for="answer1">Respuesta 1</label>
                                <input class="input-recovery" type="text" placeholder="Amarillo" required>
                                </div>
                
                                <div class="div-recovery-password">
                                <label for="question2">Pregunta 2</label>
                                <input class="input-recovery" type="text" placeholder="¿Cuál es mi comida favorita?" required>
                                <label for="answer2">Respuesta 2</label>
                                <input class="input-recovery" type="text" placeholder="Pasticho" required>
                                </div>
                
                                <div class="div-recovery-password">
                                <label for="question3">Pregunta 3</label>
                                <input class="input-recovery" type="text" placeholder="¿Lugar favorito?" required>
                                <label for="answer3">Respuesta 3</label>
                                <input class="input-recovery" type="text" placeholder="Mi Casa" required>
                                </div>
                            </div>
                            
                                <input type="submit" class="button-right" name="submit" value="Aceptar">
                        </form>
                    
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>Copyright 2024 - Hecho por la demencia</p>
    </footer>
</body>
</html>