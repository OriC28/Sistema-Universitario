<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login-register.css?v=<?php echo time(); ?>" />
    <title>Regístrate</title>
</head>
<body class="responsive">
    <header class="header">
        <h1>Registro</h1>
    </header>
    <main>
        <div class="container">
            <form action="" method="post" id="form">

                <div class="container-flex">
                    <div class="children-container-flex">
                        <div class="div-inputs-data">
                            <label for="name1">Primer Nombre</label>
                            <input class="input-signup" type="text" name="primer-nombre" placeholder="    María" required>
                        </div>
                        <div class="div-inputs-data">
                            <label for="lastname1">Primer Apellido</label>
                            <input class="input-signup" type="text" name="primer-apellido" placeholder="    Álvarez" required>
                        </div>
                    </div>
                        
                    <div class="children-container-flex">
                        <div class="div-inputs-data">
                            <label for="name2">Segundo Nombre</label>
                            <input class="input-signup" type="text" name="segundo-nombre" placeholder="    José" required>
                        </div>
                        
                        <div class="div-inputs-data">
                            <label for="lastname2">Segundo Apellido</label>
                            <input class="input-signup" type="text" name="segundo-apellido" placeholder="    Marin" required>
                        </div>
                    </div>
                </div>
                
                <div class="container-flex">
                    <div id="cedula">
                        <label for="cedula">Cédula</label>
                        <input class="input-signup" type="text" name="cedula" placeholder= "    30846853" required>
                    </div>
                </div>

                <div class="container-flex">
                    <div id="passwords">
                        <label for="password">Contraseña</label>
                        <input class="input-signup" type="password" name="password" placeholder="    Ingresa tu contraseña" required>
                    
                        <label for="confirm_password">Confirmar contraseña</label>
                        <input class="input-signup" type="password" name="confirm_password" placeholder="   Confirma tu contraseña" required>
                    </div>
                </div>

                <div class="center-button2">
                    <input type="submit" name="submit" class="button-styles" value="Siguiente">
                    <span><a id="link-signup" href="loginStudent.php">O inicia sesión</a></span>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>copinai</p>
    </footer>
</body>
</html>