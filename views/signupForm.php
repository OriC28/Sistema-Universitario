<?php
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\ErrorMessages.php';
    require_once 'C:\xampp\htdocs\Sistema-Universitario\model\Session.php';
    
    Session::startSession();

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<?php define('BASE_URL', '/Sistema-Universitario/');?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Regístrate</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Registro</h1>
    </header>
    <main>
        <div class="container">
            <form action="<?= BASE_URL?>index.php?controller=register&action=startSignUp" method="post" id="form">
                <div class="container-flex">
                    <div class="children-container-flex">
                        <div class="div-inputs-data">
                            <label for="name1">Primer Nombre</label>
                            <input class="input-signup" type="text" name="primer-nombre" placeholder="    María" required autocomplete="off">
                        </div>
                        <div class="div-inputs-data">
                            <label for="lastname1">Primer Apellido</label>
                            <input class="input-signup" type="text" name="primer-apellido" placeholder="    Álvarez" required autocomplete="off">
                        </div>
                    </div>
                        
                    <div class="children-container-flex">
                        <div class="div-inputs-data">
                            <label for="name2">Segundo Nombre</label>
                            <input class="input-signup" type="text" name="segundo-nombre" placeholder="    José" required autocomplete="off">
                        </div>
                        
                        <div class="div-inputs-data">
                            <label for="lastname2">Segundo Apellido</label>
                            <input class="input-signup" type="text" name="segundo-apellido" placeholder="    Marin" required autocomplete="off">
                        </div>
                    </div>
                </div>
                
                <div class="container-flex">
                    <div id="cedula">
                        <label for="cedula">Cédula</label>
                        <input class="input-signup" type="text" name="cedula" placeholder= "    30846853" required autocomplete="off">
                    </div>
                </div>

                <div class="container-flex">
                    <div id="passwords">
                        <label for="password">Contraseña</label>
                        <input class="input-signup" type="password" name="password" placeholder="    Ingresa tu contraseña" required autocomplete="off">
                    
                        <label for="confirm_password">Confirmar contraseña</label>
                        <input class="input-signup" type="password" name="confirm_password" placeholder="   Confirma tu contraseña" required autocomplete="off">
                    </div>
                </div>
                <?php ErrorMessages::showErrors("signupErrors"); ?>
                <div class="center-button2">
                    <input type="submit" name="submit" class="button-styles" value="Siguiente">
                    <span><a id="link-signup" href="views/loginStudent.php">O inicia sesión</a></span>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>