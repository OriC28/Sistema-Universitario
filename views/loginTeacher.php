<?php
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\ErrorMessages.php';
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    
    Session::startSession();

    define('BASE_URL', '/Sistema-Universitario/');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if(isset($_SESSION['cedula'])){
        header("Location: " . BASE_URL . "index.php?controller=table&action=mainTeacher");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Iniciar Sesión</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Iniciar Sesión</h1>
    </header>
    <main>
        <div class="container">
            <h2>Docente</h2>
            <form action="<?= BASE_URL ?>index.php?controller=login&action=loginTeacher" method="post">
                <label for="email">Cedula</label>
                <div class="div-input-email">
                    <span><img src="<?= BASE_URL ?>assets\icons\user.png" alt="icon-user"/></span>
                    <input class="input-login" type="text" name="cedula" placeholder="Ej: 27980416" required autocomplete="off">
                </div>
                
                <label for="password">Contraseña</label>
                <div class="div-input-password">
                    <span><img src="<?= BASE_URL ?>assets\icons\password.png" alt="icon-password"/></span>
                    <input class="input-login" type="password" name="password" placeholder="Ingresa tu contraseña" required autocomplete="off">
                </div>

                <?php ErrorMessages::showErrors('loginErrors'); ?>

                <div class="center-button2">
                    <input type="submit" class="button-styles" name="submit" value="Iniciar sesión">
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>

