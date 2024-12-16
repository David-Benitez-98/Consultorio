<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
    <title>Sistema Consultorio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    session_start(); /* Reanudar sesión */
    require 'menu/css_lte.ctp';
    ?>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('img/consul.jpg'); /* Ruta de la imagen de fondo */
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }

        .box-header {
            text-align: center;
            padding: 20px;
            color: white;
        }

        .box-title {
            font-size: 36px;
        }

        .current-time {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?><!-- CABECERA PRINCIPAL-->
        <?php require 'menu/toolbar_lte.ctp';?><!-- MENU PRINCIPAL-->
<div class="content-wrapper">
    <div class="box-header">
        <h1 class="box-title" style="color: black; font-size: 48px;"><b><font face="small fonts">SISTEMA DE ATENCIÓN MÉDICA</font></b></h1>
        <!-- Código para mostrar la hora actual -->
        <?php
        date_default_timezone_set('America/Asuncion');
        $current_time = date('H:i:s - Y-m-d');
        ?>
        <div class="current-time" style="color: black;">
            <?= $current_time; ?>
        </div>
        <img src="img/fondoprincipal.jpg" width="1350" height="380">
    </div>
</div>


        <?php require 'menu/footer_lte.ctp'; ?>
    </div>
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
