<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Registrar Cobros</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Estilos CSS personalizados -->
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?>
            <?php require 'menu/toolbar_lte.ctp'; ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php
                                    echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = '';
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Registrar Cobros</h3>
                                    <div class="box-tools">
                                        <a href="cobros_index.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER
                                        </a>
                                    </div>
                                </div>

                                <div class="box-body">

                                    <form action="cobros_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vcobro_cod" value="0">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="fac_fecha">Fecha:</label>
                                                <input type="date" class="form-control" name="fac_fecha" id="fac_fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                            <label for="vpac_cod" class="control-label col-lg-2">Pacientes:</label>
                                                <select class="form-control" id="vpac_cod" name="vpac_cod" required>
                                                    <option value="">Seleccionar Pacientes</option>
                                                    <?php
                                                    $pacientes = consultas::get_datos("SELECT * FROM v_paciente ORDER BY pac_cod");
                                                    foreach ($pacientes as $pac) {
                                                        echo "<option value='{$pac['pac_cod']}'>{$pac['paciente']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="cobros_index.php" class="btn btn-default">
                                                <i class="fa fa-remove"></i> CANCELAR
                                            </a>   
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <i class="fa fa-floppy-o"></i> Ir a Detalles
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?>
        </div>
        <!-- Modal para agregar cobros Tarjeta y Cheque -->
  
    </body>


    <?php require 'menu/js_lte.ctp'; ?>
</html>
