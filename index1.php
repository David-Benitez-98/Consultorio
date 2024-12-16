<?php

session_start();

// Resetear intentos después de 5 minutos
if (isset($_SESSION['ultimo_intento']) && time() - $_SESSION['ultimo_intento'] > 300) {
  unset($_SESSION['intentos']);
}

$intentos = isset($_SESSION['intentos']) ? $_SESSION['intentos'] : 0;

if ($intentos === 3) {
  $error = "Cuenta bloqueada por exceder el número de intentos";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Usuario y contraseña de prueba
  $usuario_valido = 'usuario';
  $clave_valida = password_hash('miclavesegura', PASSWORD_DEFAULT);

  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];

  // Validar contra la contraseña hasheada
  if (password_verify($clave, $clave_valida)) {

    session_regenerate_id();
    $_SESSION['usuario'] = $usuario;

    // Guardar IP
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

    // Token CSRF
    $_SESSION['csrf'] = bin2hex(random_bytes(32));

    header('Location: menu.php');
    exit;

  } else {

    $intentos++;
    $_SESSION['intentos'] = $intentos;

    $error = "Usuario o contraseña incorrectos ($intentos/3)";

  }

  // Guardar último intento
  $_SESSION['ultimo_intento'] = time();
}

// Manejo de errores
try {
  // Código aquí

} catch (Exception $e) {
  $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">-->
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" href="cl-icon/css/all.min.css">
<!--    <link rel="icon" href="/sistema_consultorio/img/fondo.jpg" type="image/jpg">-->
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        body {
            width: 100vw;
            height: 80vh;
            background: #081b29;
            display: grid;
            justify-content: center;
            align-content: center;
        }

        .wrapper {
            position: relative;
            width: 800px;
            height: 65vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 3px solid #00ffff;
            box-shadow: 0 0 50px 0 #00a6bc;
        }

        .form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .title {
            font-size: 35px;
        }

        .inp {
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }

        .input {
            border: none;
            outline: none;
            background: none;
            width: 260px;
            margin-top: 40px;
            padding-right: 10px;
            font-size: 17px;
            color: #0ef;
        }

        .submit {
            border: none;
            outline: none;
            width: 288px;
            margin-top: 25px;
            padding: 10px 0;
            font-size: 20px;
            border-radius: 40px;
            letter-spacing: 1px;
            cursor: pointer;
            background: linear-gradient(45deg, #0ef, #c800ff);
        }

        .footer {
            margin-top: 30px;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .link {
            color: #0ef;
            text-decoration: none;
        }

        .banner {
            position: absolute;
            top: 0;
            right: 0;
            width: 450px;
            height: 100%;
            background: linear-gradient(to right, #0ef, #c800ff);
            clip-path: polygon(0 0, 100% 0, 100% 100%, 60% 100%);
            padding-right: 70px;
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
        }

        .wel_text {
            font-size: 40px;
            margin-top: -50px;
            line-height: 50%;
        }

        .para {
            margin-top: 10px;
            font-size: 18px;
            line-height: 24px;
            letter-spacing: 1px;
        }

/*         Estilos para el body (sin cambios) 
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        body, html {
            background: url(img/fondo.jpg) no-repeat center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

         Estilos para el contenedor del formulario (sin cambios) 
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

         Estilos para el formulario de inicio de sesión (sin cambios) 
        .login-form input[type="text"],
        .login-form input[type="password"] {
            margin-bottom: 15px;
        }
        .login-form .form-group {
            margin-bottom: 20px;
        }
        .login-form .btn {
            width: 100%;
        }
        .login-form .checkbox {
            margin-bottom: 15px;
        }*/
    </style>
</head>
<body>
 <div class="wrapper">
<!--    <div class="text-center">
         Logo de la empresa 
       
    </div>-->
    <form class="form" action="acceso.php" method="post">
        <h1 class="title">Inicio</h1>
        <div class="inp">
            <input type="text"  name="usuario" class="input" required="" autofocus="" placeholder="Usuario"/>
            <i class="fa-solid fa-user"></i>
        </div>
       <div class="inp">
            <input type="password" name="clave" class="input" required="" placeholder="Contraseña"/>
             <i class="fa-solid fa-lock"></i>
        </div>
        <div class="form-group checkbox">
            <label>
                <input type="checkbox" value="1" name="recuerdame"> No cerrar sesión
            </label>
        </div>
        <button class="submit">Iniciar Sesión</button>
        <?php if (!empty($mensaje_error)) { ?>
            <div class="alert alert-danger" role='alert'>
                <span class="glyphicon glyphicon-exclamation-sign"></span>
                <?php echo $mensaje_error; ?>
            </div>
        <?php } ?>
    </form>
    <div class="banner">
        <h1 class="wel_text">BIENVENIDO<br/></h1>
        <p class="para">Gracias por visitar este sitio web<br/>Acceso<br/>@consultorionedicinafamiliar</p>
    </div>
</div>
<!-- Archivo JS -->
<!--<script src="js/jquery-1.12.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>-->
</body>
</html>
