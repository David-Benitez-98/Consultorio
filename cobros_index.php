<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?>
            <?php require 'menu/toolbar_lte.ctp'; ?>
            <div class="content-wrapper">
                <div class="content">
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
                                    <h3 class="box-title">COBROS</h3>
                                    <div class="box-tools">
                                        <a href="cobroscabecera.php" class="btn btn-success btn-sm"
                                           data-title="Agregar" rel="tooltip"> <i class="fa fa-plus"> </i> Agregar Cobros</a>
                                        <a href="cobros_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip"
                                           data-placement="left"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="cobros_index.php" method="post" accept-charset="utf8"
                                                  class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control"
                                                                       name="buscar" placeholder="Buscar..." autofocus=""/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-success btn-flat"
                                                                            data-title="Buscar" data-placement="bottom"
                                                                            rel="tooltip"><span class="fa fa-search"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Mostrar la tabla de facturas -->
                                            <?php
                                            $factura = consultas::get_datos("SELECT * FROM v_cobros WHERE cobro_estado = 'PENDIENTE' AND cobro_fecha::text ILIKE '%%' ORDER BY cobro_cod DESC;");
                                            if ($factura) {
                                                ?>
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Cobros</th>
                                                            <th>Fechas</th>
                                                            <th>Clientes</th>
                                                            <th>Condicion</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($factura as $agen) { ?>
                                                            <tr>
                                                                <td data-title="Nro"><?php echo $agen['fac_cod']; ?></td>
                                                                <td data-title="Nro"><?php echo $agen['fac_nro']; ?></td>
                                                                <td data-title="Fecha"><?php echo $agen['fac_fecha']; ?></td>
                                                                <td data-title="Cliente"><?php echo $agen['paciente']; ?></td>
                                                                <td data-title="Condición"><?php echo $agen['fac_condicion']; ?></td>
                                                                <td data-title="Estado"><?php echo $agen['fac_estado']; ?></td>
                                                                <td data-title="Acciones" class="text-center">
                                                                    <?php if ($agen['fac_estado'] == 'PENDIENTE') { ?>
                                                                        <a onclick="confirmar('<?php echo $agen['fac_cod']; ?>', '<?php echo $agen['paciente']; ?>', '<?php echo $agen['fac_fecha']; ?>', '<?php echo $agen['tim_cod']; ?>')" 
                                                                           class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                                                            <i class="fa fa-check"></i>
                                                                        </a>

                                                                        <a onclick="anular('<?php echo $agen['fac_cod']; ?>', '<?php echo $agen['paciente']; ?>', '<?php echo $agen['fac_fecha']; ?>')"  
                                                                           class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#anular">
                                                                            <i class="fa fa-remove"></i>
                                                                        </a>
                                                                        <a href="facturadetalle_add.php?vfac_cod=<?php echo $agen['fac_cod']; ?>" 
                                                                           class="btn btn-success btn-sm" role="button" data-title="Detalles" 
                                                                           rel="tooltip" data-placement="top">
                                                                            <span class="glyphicon glyphicon-list"></span></a>
                                                                    <?php } ?>
                                                                    <a href="factura_print.php?vfac_cod=<?php echo $agen['fac_cod']; ?>" class="btn btn-primary btn-sm" role="button" 
                                                                       data-title="Imprimir" rel="tooltip" data-placement="top" target="print">
                                                                        <span class="glyphicon glyphicon-print"></span></a>                                                                             
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php } else { ?>
                                                <div class="alert alert-info">
                                                    <span class="glyphicon glyphicon-info-sign"></span> 
                                                    No se han registrado Facturas...
                                                </div>      
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?>
            <!-- MODAL Anular-->
            <div class="modal fade" id="anular" role="dialog">
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
            <!-- FIN MODAL Anular--> 

            <!-- MODAL Confirmar -->
            <div class="modal fade" id="confirmar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                            <h4 class="modal-title custom_align">ATENCIÓN...!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" id="confirmacionc"></div>
                        </div>
                        <div class="modal-footer">
                            <a id="sic" role="button" class="btn btn-success">
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
                function confirmar(fac_cod, paciente, fac_fecha, tim_cod) {
                    if (!fac_cod || !tim_cod) {
                        alert("Error: Código de factura o timbrado inválido.");
                        return;
                    }
                    $('#sic').attr('href', 'factura_control.php?vfac_cod=' + fac_cod + '&tim_cod=' + tim_cod + '&accion=2');
                    $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
Desea confirmar la Factura N° <strong>' + fac_cod + '</strong> del Paciente <strong>' + paciente + '</strong> de fecha <strong>' + fac_fecha + ' ?</strong>');
                }

                function anular(fac_cod, paciente, fac_fecha) {
                    $('#si').attr('href', 'factura_control.php?vfac_cod=' + fac_cod + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
Desea anular la Factura N° <strong>' + fac_cod + '</strong> del cliente <strong>' + paciente + '</strong> de fecha <strong>' + fac_fecha + ' ?</strong>');
                }
            </script> 
            <script>
                // Ocultar el mensaje después de 5 segundos
                $(document).ready(function () {
                    setTimeout(function () {
                        $('#mensaje').fadeOut('slow');
                    }, 5000); // 5000 milisegundos = 5 segundos
                });
                function ImprimirCitas() {
                    window.print();
                }
            </script>
            <?php require 'menu/js_lte.ctp'; ?>
    </body>
</html>
