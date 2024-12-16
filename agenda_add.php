<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
    <title>Agregar Agenda - Sistema Consultorio</title>
    <!-- Incluye tus estilos CSS personalizados aquí -->
    <?php session_start(); require 'menu/css_lte.ctp'; ?>
    <style>
        /* Custom Styles */
        .container {
            margin-top: 20px;
        }

        .box {
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        .box-header {
            background-color: #3c8dbc;
            color: #fff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }

        .form-control:focus {
            border-color: #3c8dbc;
            box-shadow: 0 0 5px rgba(60, 141, 188, 0.5);
        }

        .btn-primary {
            background-color: #3c8dbc;
            border-color: #367fa9;
        }

        .btn-primary:hover {
            background-color: #367fa9;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .box-footer {
            text-align: right;
            padding-top: 20px;
        }

        .card {
            border: 1px solid #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 15px;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Agregar Agenda</h3>
                                </div>
                                <div class="box-body">
                                    <form action="agenda_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vagen_cod" value="<?php echo isset($vagen_cod) ? $vagen_cod : ''; ?>"/>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <?php $fecha = consultas::get_datos("SELECT current_date as fecha"); ?>
                                                            <label class="control-label">Fecha:</label>
                                                            <input type="date" name="vagen_fecha" class="form-control" required="" value="<?php echo $fecha[0]['fecha']; ?>" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label class="control-label">FECHA INICIO:</label>
                                                            <input type="date" name="vfecha_inicio" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label class="control-label">FECHA FIN:</label>
                                                            <input type="date" name="vfecha_fin" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="agenda_index.php" class="btn btn-danger">
                                                <i class="fa fa-remove"></i> CANCELAR
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-floppy-o"></i> Ir a Detalles
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
    </div>
    <?php require 'menu/js_lte.ctp'; ?>
    <script>
        $('#mensaje').delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>
