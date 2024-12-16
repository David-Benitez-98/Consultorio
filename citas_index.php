<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Citas Médicas - Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Agrega tu CSS personalizado aquí -->
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?><!-- ARCHIVOS CSS -->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?>
            <?php require 'menu/toolbar_lte.ctp'; ?>
            <div class="content-wrapper">
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
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
                                <div class="box-header">
                                    <i class="fa fa-meh-o" aria-hidden="true"></i>
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">Citas Médica</h3>
                                    <div class="box-tools">
                                        <a href="citas_add.php" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip">
                                            <i class="fa fa-plus"></i> Agregar Citas
                                        </a>

                                        <a href="citas_print.php" class="btn btn-default btn-sm" onclick="ImprimirCitas()" data-title="Imprimir" rel="tooltip">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="citas_index.php" method="post" accept-charset="utf8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control" name="buscar" placeholder="Buscar..." autofocus=""/>
                                                                <a href="citas_add.php"></a>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-success btn-flat" data-title="Buscar" data-placement="bottom" rel="tooltip">
                                                                        <span class="fa fa-search"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Mostrar la tabla de citas -->
                                            <?php
                                            $citas = consultas::get_datos("SELECT * FROM v_citas WHERE cita_fecha::text ILIKE '%%' ORDER BY cita_cod DESC;");
                                            if (!empty($citas)) {
                                                ?>
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Doctor</th>
                                                    <th>Especialidad</th>
                                                    <th>Hora</th>
                                                    <th>Paciente</th>
                                                    <th>Turnos</th>
                                                    <th>Dias</th>
                                                    <th>Razon Cita</th>
                                                    <th>Estado</th>
                                                    <th class="text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($citas as $cit) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $cit['cita_cod']; ?></td>
                                                                <td data-title="Fecha"><?php echo $cit['cita_fecha']; ?></td>
                                                                <td data-title="Doctor"><?php echo $cit['doctor']; ?></td>
                                                                <td data-title="Especialidad"><?php echo $cit['esp_descri']; ?></td>
                                                                <td data-title="Hora"><?php echo $cit['cita_hora']; ?></td>
                                                                <td data-title="Paciente"><?php echo $cit['paciente']; ?></td>
                                                                <td data-title="Turnos"><?php echo $cit['tur_descri']; ?></td>
                                                                <td data-title="Dias"><?php echo $cit['dia_descri']; ?></td>
                                                                <td data-title="Razon Cita"><?php echo $cit['razon_cita']; ?></td>
                                                                <td data-title="Estado"><?php echo $cit['cita_estado']; ?></td>
                                                                <td data-title="Acciones" class="text-center">
                                                                    <?php if ($cit['cita_estado'] == 'PENDIENTE') { ?>
                                                                        <a onclick="confirmar(<?php echo "'" . $cit['cita_cod'] . "_" . $cit['paciente'] . "_" . $cit['cita_fecha'] . "'"; ?>)" 
                                                                           class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                                                            <i class="fa fa-check"></i></a>
                                                                        <a href="citas_edit.php?vagen_cod=<?php echo $cit['cita_cod']; ?>" class="btn btn-warning btn-sm" role="button" data-title="Editar" 
                                                                           rel="tooltip" data-placement="top">
                                                                            <span class="glyphicon glyphicon-edit"></span></a>
                                                                        <a onclick="anular(<?php echo "'" . $cit['cita_cod'] . "_" . $cit['paciente'] . "_" . $cit['cita_fecha'] . "'"; ?>)"
                                                                           class="btn btn-danger btn-sm" role="button" data-title="Anular" rel="tooltip" data-placement="top" 
                                                                           data-toggle="modal" data-target="#anular">
                                                                            <span class="glyphicon glyphicon-remove"></span></a>
                                                                    <?php } ?>
                                                                    <a href="citas_print.php?vcita_cod=<?php echo $cit['cita_cod']; ?>" class="btn btn-primary btn-sm" role="button" 
                                                                       data-title="Imprimir" rel="tooltip" data-placement="top" target="print">
                                                                        <span class="glyphicon glyphicon-print"></span></a>                                                                          
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado Citas...
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; ?>
        <div class="modal" id="anular" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" id="confirmacion"></div>
                    </div>
                    <div class="modal-footer">
                        <a id="si" role="buttom" class="btn btn-danger">
                            <span class="glyphicon glyphicon-ok-sign"></span> SI
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> NO
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL confirmar-->
        <div class="modal" id="confirmar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" id="confirmacionc"></div>
                    </div>
                    <div class="modal-footer">
                        <a id="sic" role="buttom" class="btn btn-success">
                            <span class="glyphicon glyphicon-ok-sign"></span> SI
                        </a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> NO
                        </button>
                    </div>
                </div>
            </div>
        </div>
 
    <script>
        $("#mensaje").delay(4000).slideUp(200, function () {
            $(this).alert('close');
        });
    </script>
    <script>
        function anular(datos) {
            var dat = datos.split('_');
            $('#si').attr('href', 'citas_control.php?vcita_cod=' + dat[0] + '&accion=4');
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
       Desea anular la Cita N° <strong>' + dat[0] + '</strong> del Paciente <strong>' + dat[1] + '</strong> de fecha  <strong>' + dat[2] + ' ?</strong>')
        }
        function confirmar(datos) {
            var dat = datos.split('_');
            $('#sic').attr('href', 'citas_control.php?vcita_cod=' + dat[0] + '&accion=3');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
       Desea confirmar la Cita N° <strong>' + dat[0] + '</strong> del Paciente <strong>' + dat[1] + '</strong> de fecha  <strong>' + dat[2] + ' ?</strong>')
        }
    </script> 
    <script>
        function ImprimirCitas() {
            window.print();
        }
    </script>
    <?php require 'menu/js_lte.ctp'; ?>
</body>
</html>
