<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets\css\style_student.css?v=<?php echo time(); ?>" />
    <title>Perfil</title>
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
        <div class="function">
            <span><img src="../assets\icons\agregar.png" alt="icon-personal-data"/></span>
            <a href="contactData.php">Agregar datos de contacto</a>
        </div>
        <div class="function">
            <span><img src="../assets\icons\calificaciones.png" alt="icon-calificaciones"/></span>
            <a href="viewNotes.php">Ver calificaciones</a>
        </div>
        <div class="function">
            <span><img src="../assets\icons\modificar.png" alt="icon-recovery"/></span>
            <a href="recoveryquestionStudent.php">Modificar preguntas de seguridad</a>
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
                    <img id="profile-main" src="../assets\icons\perfil1.png" alt="icon-profile">
                </div>
                <div class="name">
                    <h2>Genesys Jose</h2>
                    <h2>Alvarado Marin</h2>
                </div>
                </div>
                <div class="separator"></div>
            </div>
            
            <!-- BLOQUE BLANCO CON SU RESPECTIVO CONTENIDO -->
            <div class="div-white">
                <div class="data"> 
                    <h3>Cédula:</h3><label for="">V-30846853</label>
                </div>
                <div class="data"> 
                    <h3>Teléfono:</h3><label for="">0412-0646612</label>
                </div>
                <div class="data"> 
                    <h3>Correo electrónico:</h3>
                    <label for="">
                        genesys@gmail.com
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