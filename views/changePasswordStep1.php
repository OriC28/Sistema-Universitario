<?php
    define('BASE_URL', '/Sistema-Universitario/');

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION['changePasswordData'])) {
        unset($_SESSION['changePasswordData']);
    }

    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\ErrorMessages.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Cambiar contraseña</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Identificación (1/3)</h1>
    </header>
    <main>
        <div class="container">
            <form action="<?=BASE_URL?>index.php?controller=changePassword&action=changePasswordStep1" method="post">
                <label for="">Cédula</label>
                <div class="div-input-password">
                    <span><img src="<?=BASE_URL?>assets\icons\user.png" alt="icon-user"/></span>
                    <input class="input-signup" type="text" name="cedula" id="" required autocomplete="off">
                </div>
                <?php ErrorMessages::showErrors('changePasswordErrors'); ?>
                <div class="center-button2">
                    <input class="button-styles" type="submit" name="submit" value="Siguiente">
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>