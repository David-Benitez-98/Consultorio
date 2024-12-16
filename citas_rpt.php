<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Sistema Consultorio</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-warning" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php
                                    echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = '';
                                    ?>
                                </div>

                            <?php } ?>
                            <div class="box box-warning">
                                <div class="box-header">
                                    <i class="fa fa-meh-o" aria-hidden="true"></i>
                                    <h3 class="box-title">Nicolás Cabrera T...(+_+)</h3><br><br>
                                    <i class="fa fa-list"></i> 
                                    <h3 class="box-title">REPORTE DE CITAS</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                            $opcion = "2";
                                            if (isset($_REQUEST['opcion'])) {
                                                $opcion = $_REQUEST['opcion'];
                                            }
                                            ?>
                                            <form action="citas_print.php" method="get" accept-charset="utf-8" class="form-horizontal" target="print">
                                                <input type="hidden" name="opcion" value="<?php echo $opcion; ?>"/>
                                                <div class="box-body">
                                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-heading">
                                                                <strong>OPCIONES</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="list-group">
                                                                    <a href="citas_rpt.php?opcion=1" class="list-group-item">Por Fechas</a>
                                                                    <a href="citas_rpt.php?opcion=2" class="list-group-item">Por Paciente</a>
                                                                    <a href="citas_rpt.php?opcion=3" class="list-group-item">Por Especialidad</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-lg-8">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-heading">
                                                                <strong>FILTROS</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                switch ($opcion) {
                                                                    case 1://por fecha 
                                                                        ?>
                                                                        <div class="form-group has-feedback">
                                                                            <label class="control-label col-lg-2 col-md-2">Desde:</label>
                                                                            <div class="col-lg-6 col-md-6">
                                                                                <input type="date" name="vdesde" class="form-control"/>
                                                                                <i class="fa fa-calendar form-control-feedback"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group has-feedback">
                                                                            <label class="control-label col-lg-2 col-md-2">Hasta:</label>
                                                                            <div class="col-lg-6 col-md-6">
                                                                                <input type="date" name="vhasta" class="form-control"/>
                                                                                <i class="fa fa-calendar form-control-feedback"></i>
                                                                            </div>
                                                                        </div>                                                                
                                                                        <?php
                                                                        break;
                                                                     case 2:
                                                            // Asegúrate de que consultas::get_datos está bien definido y retorna un array
                                                            $pacientes = consultas::get_datos("SELECT * FROM v_paciente WHERE pac_cod IN (SELECT pac_cod FROM citas)");
                                                            ?>
                                                            <div class="form-group">
                                                                <label class="control-label col-lg-2">Pacientes:</label>
                                                                <div class="col-lg-6">
                                                                    <select class="form-control select2" name="vpac_cod" required>
                                                                        <option value="">Seleccione un Paciente</option>
                                                                        <?php foreach ($pacientes as $pac) { ?>
                                                                            <option value="<?php echo $pac['pac_cod']; ?>"><?php echo htmlspecialchars($pac['paciente']); ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            break;
                                                                    case 3:
                                                                        $pacientes = consultas::get_datos("select * from especialidad where esp_cod in(select esp_cod from citas)");
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Especialidad:</label>
                                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                                <select class="form-control select2" name="vesp_cod" required="">
                                                                                    <?php foreach ($pacientes as $pac) { ?>
                                                                                        <option value="<?php echo $pac['esp_cod']; ?>"><?php echo $pac['esp_descri']; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>                                                                
                                                                        <?php
                                                                        break;
                                                                }
                                                                ?>                                                                 
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-warning pull-right">
                                                        <i class="fa fa-print"></i>LISTAR
                                                    </button>
                                                </div>  
                                                <div class="IrArriba"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
    </body>
</html>

