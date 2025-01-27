<?php 
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if(!isset($_SESSION['cedula']) || empty($_SESSION['cedula']) || !isset($_SESSION['securityStepReady']) || empty($_SESSION['securityStepReady'])){
        header('Location: '.BASE_URL.'views/changePasswordStep1.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<?php define('BASE_URL', '/Sistema-Universitario/'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Cambiar contraseña</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Establecer contraseña nueva</h1>
    </header>
    <main>
        <div class="container">
            <form action="<?=BASE_URL?>index.php?controller=changePassword&action=changePasswordStep3" method="post">
                <label for="">Contraseña nueva</label>
                <div class="div-input-password">
                    <span><img src="..\assets\icons\password.png" alt="icon-password"/></span>
                    <input class="input-signup" type="text" name="new-password" id="">
                </div>
                    
                <label for="">Confirmar contraseña</label>
                <div class="div-input-password">
                    <span><img src="..\assets\icons\password.png" alt="icon-password"/></span>
                    <input class="input-signup" type="text" name="password" id="">
                </div>
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