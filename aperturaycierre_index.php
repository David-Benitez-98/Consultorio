<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/sistema_consultorio/favicon.ico">
        <title>Apertura y Cierre de Caja - Sistema Consultorio</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style>
            .title-container {
                display: flex; /* Usar flexbox para centrar el contenido */
                justify-content: center; /* Centrar horizontalmente */
                align-items: center; /* Centrar verticalmente */
                height: 120px; /* Altura ajustada para resaltar el título */
                overflow: hidden; /* Ocultar contenido que sobresalga */
                background-color: #f4f4f4; /* Fondo suave para resaltar el texto */
                border: 1px solid #ddd; /* Borde sutil para profesionalismo */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para darle profundidad */
                white-space: nowrap; /* Evitar saltos de línea */
                padding: 10px; /* Espaciado interno */
            }

            /* Estilo base del título */
            .box-title {
                font-size: 52px; /* Tamaño grande para un impacto visual */
                font-weight: bold;
                color: #000; /* Color negro profesional */
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Fuente moderna y legible */
                animation: moveTitle 8s linear infinite; /* Animación más suave */
                letter-spacing: 1px; /* Espaciado entre letras para claridad */
            }

            /* Animación del movimiento */
            /*@keyframes moveTitle {
                0% {
                    transform: translateX(100%);  Comienza fuera del contenedor a la derecha 
                }
                50% {
                    transform: translateX(0);  Se centra brevemente 
                }
                100% {
                    transform: translateX(-100%);  Termina fuera del contenedor a la izquierda 
                }
            }*/

        </style>

        <?php
        session_start();
        require 'menu/css_lte.ctp';
        ?>
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

                                    <div class="title-container">
                                        <h3 class="box-title" class="ion ion-clipboard" >Apertura y Cierre de Caja</h3>
                                    </div>

                                    <div class="box-tools">
                                        <a href="#" id="btnAbrir" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#documentosModal">
                                            <i class="fa fa-plus"></i> ARQUEO DE CAJA
                                        </a>
                                        <a href="apertura_cierre_add.php" id="btnAbrir" class="btn btn-success btn-sm" value="Abrir" rel="tooltip" data-placement="left" onclick="apertura();">
                                            <i class="fa fa-plus"></i> ABRIR
                                        </a>
                                        <a href="factura_add.php" class="btn btn-vimeo btn-sm" data-title="Cobrar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i> Cobrar
                                        </a> 
                                        <a href="apertura_cierre_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form action="apertura_cierre_index.php" method="post" accept-charset="utf8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" class="form-control" name="buscar" placeholder="Buscar..." autofocus=""/>
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
                                            <!-- Mostrar la tabla de apertura y cierre de caja -->
                                            <?php
                                            $apertura_cierre = consultas::get_datos("SELECT * FROM v_apertura_cierre WHERE "
                                                            . "(aper_cod::varchar || fecha_apertura::varchar) ILIKE '%" .
                                                            (isset($_REQUEST['buscar']) ? $_REQUEST['buscar'] : "") . "%' ORDER BY aper_cod DESC");
                                            if (!empty($apertura_cierre)) {
                                                ?>
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Fecha Apertura</th>
                                                    <th>Fecha Cierre</th>
                                                    <th>Monto Apertura</th>
                                                    <th>Monto Cierre Efectivo</th>
                                                    <th>Monto Cierre Tarjeta</th>
                                                    <th>Monto Cierre Cheque</th>
                                                    <th>Total a Cierre</th>
                                                    <th class="text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($apertura_cierre as $apc) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $apc['aper_cod']; ?></td>
                                                                <td data-title="Fecha Apertura"><?php echo $apc['fecha_apertura']; ?></td>
                                                                <td data-title="Fecha Cierre"><?php echo $apc['fecha_cierre']; ?></td>
                                                                <td data-title="Monto Apertura"><?php echo $apc['aper_monto']; ?></td>
                                                                <td data-title="Monto Cierre Efectivo"><?php echo $apc['monto_efectivo']; ?></td>
                                                                <td data-title="Monto Cierre Tarjeta"><?php echo $apc['monto_tarjeta']; ?></td>
                                                                <td data-title="Monto Cierre Cheque"><?php echo $apc['monto_cheque']; ?></td>
                                                                <td data-title="Diferencia Cierre"><?php echo $apc['total_cierre']; ?></td>
                                                                <td class="text-center">
                                                                    <?php if ($apc['estado_aper'] == 'ABIERTA') { ?>
                                                                        <button class="btn btn-default btn-sm" data-title="Cerrado" rel="tooltip">
                                                                            Caja Cerrada
                                                                        </button> 
                                                                    <?php } else { ?>
                                                                        <a onclick="cerrar('<?php echo $apc['aper_cod']; ?>_<?php echo $apc['aper_monto']; ?>_<?php echo $apc['caj_cod']; ?>')" 
                                                                           class="btn btn-warning btn-sm" data-title="Cerrar" rel="tooltip" data-toggle="modal" data-target="#cierreModal">
                                                                            CERRAR CAJA
                                                                        </a>
                                                                    <?php } ?>
                                                                    <a href="aperturacierre.print.php?vaper_cod=<?php echo $apc['aper_cod']; ?>" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="print">
                                                                        <i class="fa fa-print"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            <?php } else { ?>
                                                <div class="alert alert-info">
                                                    <span class="glyphicon glyphicon-info-sign"></span> 
                                                    No se han registrado aperturas ni cierres de caja...
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

                    <!-- Modal para agregar apertura -->
                    <div class="modal fade" id="documentosModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="arqueo_control.php" method="post" class="form-horizontal"> 
                                   

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Detalles de Arqueo de Caja</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input name="accion" value="generar_arqueo" type="hidden" />
                                        <input type="hidden" name="usu_cod" value="<?php echo $_SESSION['usu_cod']; ?>">

                                        <!-- Tabla de Arqueos -->
                                        <div class="form-group">
                                            <?php
                                            $arqueos = consultas::get_datos("SELECT * FROM v_arqueocaja WHERE estado_arqueo = 'ACTIVO' ORDER BY codigo_arqueo DESC;");
                                            if ($arqueos) {
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Código Apertura</th>
                                                                <th>Fecha Apertura</th>
                                                                <th>Monto Apertura</th>
                                                                <th>Monto Efectivo</th>
                                                                <th>Monto Cheque</th>
                                                                <th>Monto Tarjeta</th>
                                                                <th>Estado Arqueo</th>
                                                                <th class="text-center">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($arqueos as $arq) { ?>
                                                                <tr>
                                                                    <td><?php echo $arq['codigo_arqueo']; ?></td>
                                                                    <td><?php echo $arq['codigo_apertura']; ?></td>
                                                                    <td><?php echo $arq['fecha_apertura']; ?></td>
                                                                    <td><?php echo number_format($arq['monto_apertura'], 0, ',', '.'); ?> Gs</td>
                                                                    <td><?php echo number_format($arq['monto_efectivo'], 0, ',', '.'); ?> Gs</td>
                                                                    <td><?php echo number_format($arq['monto_cheque'], 0, ',', '.'); ?> Gs</td>
                                                                    <td><?php echo number_format($arq['monto_tarjeta'], 0, ',', '.'); ?> Gs</td>
                                                                    <td><?php echo $arq['estado_arqueo']; ?></td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-info btn-sm">
                                                                            <i class="fa fa-eye"></i> Ver
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php } else { ?>
                                                <div class="alert alert-warning" role="alert">
                                                    No hay datos de arqueos disponibles.
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-default">
                                            <i class="fa fa-remove"></i> Cerrar
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-floppy-o"></i> Generar Nuevo Arqueo
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Modal para confirmar eliminación -->


                    <!-- Modal de confirmación para el cierre de caja -->
                    <div class="modal fade" id="cierreModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                    <h4 class="modal-title custom_align">Atención!!!</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" id="confirmacion"></div>
                                </div>
                                <div class="modal-footer">
                                    <a id="si" role="button" class="btn btn-danger">
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
                        function cerrar(datos) {
                            // Split the 'datos' parameter to get individual values
                            var dat = datos.split('_');

                            // Check if 'dat' has exactly 3 elements (aper_cod, aper_monto, caj_cod)
                            if (dat.length === 3) {
                                var aperCod = dat[0];
                                var aperMonto = dat[1];
                                var cajCod = dat[2];

                                // Update the confirmation message
                                $("#confirmacion").html(
                                        '<span class="glyphicon glyphicon-warning-sign"></span> ' +
                                        '¿Desea cerrar la Apertura n° <strong>' + aperCod + '</strong>?');

                                // Set the href attribute of the 'SI' button to perform the close action
                                $('#si').attr('href', 'aperturaycierre_control.php?vaper_cod=' + aperCod + '&vaper_monto=' + aperMonto + '&vcaj_cod=' + cajCod + '&accion=2');
                            } else {
                                console.error('Datos insuficientes para cerrar la caja.');
                            }
                        }

                    </script>


                    <?php require 'menu/js_lte.ctp'; ?>
                    </body>
                    </html>
