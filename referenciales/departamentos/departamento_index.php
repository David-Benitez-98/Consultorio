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
        session_start();
        require '../../menu2/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require '../../menu2/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
<?php require '../../menu2/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-md-12">
<?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = '';
                                    ?>
                                </div>
<?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-clipboard"></i>
                                    <h3 class="box-title">DEPARTAMENTO</h3>
                                    <div class="box-tools">
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" role="button" data-target="#registrar">
                                            <i class="fa fa-plus"></i></a>
                                        <a href="departamento_print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <form method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="input-group custom-search-form">                                                                
                                                                <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus=""/>
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary btn-flat" data-title="Buscar" rel="tooltip">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form> 
                                            <?php
                                            $departamentos = consultas::get_datos("select * from departamento where depar_descri ilike '%" . (isset($_REQUEST['buscar']) ? $_REQUEST['buscar'] : "") . "%' order by depar_cod");
                                            if (!empty($departamentos)) {
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                        <thead>
                                                        <th>Departamento</th>
                                                        <th>Estado</th>
                                                        <th class="text-center">Acciones</th>
                                                        </thead>
                                                        <tbody>
    <?php foreach ($departamentos as $depar) { ?>
                                                                <tr>
                                                                    <td data-title="Descripcion"><?php echo $depar['depar_descri']; ?></td>
                                                                    <td data-title="Estado"><?php echo $depar['depar_estado']; ?></td>
                                                                    <td data-title="Acciones" class="text-center">
        <?php if ($depar['depar_estado'] == 'ACTIVO') { ?>
                                                                            <a onclick="editar('<?php echo $depar['depar_cod'] . "_" . $depar['depar_descri']; ?>')"       
                                                                               class="btn btn-xs btn-warning" role="button" data-title="Editar"
                                                                               rel="tooltip" data-placement="top" data-toggle="modal" data-target="#editar">
                                                                                <span class="glyphicon glyphicon-pencil"></span> Editar</a>
                                                                            <a onclick="deshabilitar('<?php echo $depar['depar_cod'] . "_" . $depar['depar_descri']; ?>')" 
                                                                               class="btn btn-xs btn-danger" role="button" data-title="Deshabilitar"
                                                                               rel="tooltip" data-placement="top" data-toggle="modal" data-target="#deshabilitar">
                                                                                <span class="glyphicon glyphicon-remove"></span> Deshabilitar</a>
        <?php } else { ?>
                                                                            <a onclick="activar('<?php echo $depar['depar_cod'] . "_" . $depar['depar_descri']; ?>')" 
                                                                               class="btn btn-xs btn-primary" role="button" data-title="Activar"
                                                                               rel="tooltip" data-placement="top" data-toggle="modal" data-target="#activar">
                                                                                <span class="glyphicon glyphicon-ok-sign"></span> Activar</a>
                                                                <?php } ?> 
                                                                    </td>
                                                                </tr>
                                                <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
<?php } else { ?>
                                                <div class="alert alert-info flat">
                                                    <span class="glyphicon glyphicon-info-sign"></span>
                                                    No se han registrado departamentos..
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
<?php require '../../menu2/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
            <!--INICIA MODAL REGISTRAR-->
            <div class="modal fade" id="registrar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title">Registrar Departamento</h4>
                        </div>
                        <form action="departamento_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <input name="accion" value="1" type="hidden"/>
                            <input name="vdepar_cod" value="0" type="hidden"/>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Departamento</label>
                                    <div class="col-sm-5 col-lg-5 col-xs-5 col-md-5">
                                        <input type="text" class="form-control" name="vdepar_descri" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default">
                                    <a class="fa fa-remove"></a> Cerrar</button>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <a class="fa fa-floppy-o"></a> Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--FIN MODAL REGISTRAR-->
            <!--INICIA MODAL EDITAR-->
            <div class="modal fade" id="editar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title">Editar Departamento</h4>
                        </div>
                        <form action="departamento_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <input name="accion" value="2" type="hidden"/>
                            <input id="cod" name="vdepar_cod" type="hidden"/>
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Descripcion</label>
                                    <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                                        <input id="descri" type="text" class="form-control" name="vdepar_descri" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default">
                                    <a class="fa fa-remove"></a> Cerrar</button>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <a class="fa fa-floppy-o"></a> Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--FIN MODAL EDITAR-->
            <!--INICIA MODAL ANULAR-->
            <div class="modal fade" id="deshabilitar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="data-title custom_align" id="Heading" >Atencion!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" id="confirmacion"></div>
                        </div>
                        <div class="modal-footer">
                            <a id="si" role="button" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--FIN MODAL ANULAR-->
            <!--INICIA MODAL ACTIVAR-->
            <div class="modal fade" id="activar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="data-title custom_align" id="Heading" >Atencion!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning" id="confirmacion">Desea activar el registro?</div>
                        </div>
                        <div class="modal-footer">
                            <a id="si_activar" role="button" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--FIN MODAL ACTIVAR-->
        </div>                  
<?php require '../../menu2/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('input:text:visible:first').focus();
            });
        </script>
        <script>
           function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);
            }
            function deshabilitar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href', 'departamento_control.php?vdepar_cod=' + dat[0] + '&vdepar_descri=' + dat[1] + '&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                 Desea inhabilitar el departamento <i><strong>' + dat[1] + '</strong></i>');
            }
            function activar(datos) {
                var dat = datos.split("_");
                var vdepar_cod = dat[0];
                var vdepar_descri = dat[1];
                var vdepar_estado = dat[2];
                // Configurar la URL para enviar los datos al script departamento_control.php
                var url = 'departamento_control.php?accion=4&vdepar_cod=' + vdepar_cod + '&vdepar_descri=' + vdepar_descri + '&vdepar_estado=' + vdepar_estado;

                // Actualizar el enlace 'si' con la URL correcta
                $('#si_activar').attr('href', url);

                // Configurar el mensaje de confirmación
                var mensaje = 'Desea activar la departamento <strong>' + vdepar_descri + '</strong>?';
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> ' + mensaje);
            }
        </script>
         </body>
</html>