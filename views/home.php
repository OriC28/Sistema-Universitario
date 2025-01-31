<?php
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    
    Session::startSession();
    
    define('BASE_URL', '/Sistema-Universitario/');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if(isset($_SESSION['cedula'])){
        if ($_SESSION['logged-in-student'] === true) {
            header("Location: " . BASE_URL . "index.php?controller=profileStudent&action=getStudentData");
            exit();
        } elseif ($_SESSION['logged-in-teacher'] === true) {
            header("Location: " . BASE_URL . "index.php?controller=table&action=mainTeacher");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Main</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Bienvenido</h1>
    </header>
    <main>
        <div class="container-main">
            <div class="card">
                <h2 class="main-title">DOCENTE</h2>
                <p>Para personal encargado de la gestión y registro de las calidicaciones academicas.</p>
                <button id="button-teacher">Iniciar Sesión</button>
            </div>

            <div class="card">
                <h2 class="main-title">ESTUDIANTE</h2>
                <p>Para estudiantes que desean ingresar al portal o registrarse.</p>
                <button id="button-student">Iniciar Sesión o Registrarse</button>
            </div>
        </div>
    </main>
    <script src="../assets/js/redirectUser.js"></script>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>
