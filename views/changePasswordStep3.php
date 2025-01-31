<?php 
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\ErrorMessages.php';
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    
    Session::startSession();
    
    define('BASE_URL', '/Sistema-Universitario/');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    if(!isset($_SESSION["changePasswordData"]) || !$_SESSION["stepReady"]){
        header("Location: changePasswordStep1.php");
        exit();
    }
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
        <h1>Establecer contraseña nueva</h1>
    </header>
    <main>
        <div class="container">
            <form action="<?= BASE_URL ?>index.php?controller=changePassword&action=changePasswordStep3" method="post">
                <label for="">Contraseña nueva</label>
                <div class="div-input-password">
                    <span><img src="<?= BASE_URL ?>assets\icons\password.png" alt="icon-password"/></span>
                    <input class="input-signup" type="text" name="new-password" id="" autocomplete="off">
                </div>
                    
                <label for="">Confirmar contraseña</label>
                <div class="div-input-password">
                    <span><img src="<?= BASE_URL ?>assets\icons\password.png" alt="icon-password"/></span>
                    <input class="input-signup" type="text" name="password" id="" autocomplete="off">
                </div>
                <?php ErrorMessages::showErrors('changePasswordErrors'); ?>
                <div class="center-button2">
                    <input class="button-styles" type="submit" name="submit" value="Confirmar">
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>