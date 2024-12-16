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
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php
                                    echo $_SESSION['mensaje'];
                                    $_SESSION['mensaje'] = '';
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-list"></i><i class="fa fa-plus"></i> 
                                    <h3 class="box-title">AGREGAR DETALLE DE RECETAS E INDICACIONES</h3>
                                    <div class="box-tools">
                                        <a href="recetasindicaciones_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER
                                        </a>
                                    </div>
                                </div>

                                <!--Inicio de cabecera -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                        <?php
                                        $recetas = consultas::get_datos("select * FROM v_recetasindicaciones WHERE re_cod =  " . $_REQUEST['vre_cod']);
                                        if (!empty($recetas)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Paciente</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($recetas as $rec) { ?>
                                                            <tr>
                                                                <td class="re_cod"><?php echo $rec['re_cod']; ?></td>
                                                                <td data-title="Fecha"><?php echo $rec['re_fecha']; ?></td>
                                                                <td data-title="Paciente"><?php echo $rec['paciente']; ?></td>
                                                                <td data-title="Tipo de Consulta"><?php echo $rec['re_estado']; ?></td>

                                                            </tr>  
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado la Cabecera...
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--Fin de cabecera -->


                                <!--Inicio de detalle agregar-->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                        $detallerecetas = consultas::get_datos("select * from v_recetasindicacionesdetalle where re_cod=  " . $_REQUEST['vre_cod']);
                                        if (!empty($detallerecetas)) {
                                            ?>
                                            <div class="box">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-list"></i>
                                                    <h3 class="box-title">DETALLES</h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>MEDICAMENTOS</th>
                                                                    <th>INDICACIONES</th>
                                                                    <th>HORA</th>
                                                                    <th>DOSIS</th>
                                                                    <th>CANTIDAD</th>
                                                                    <th class="text-center">Acciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($detallerecetas as $detalles) { ?>
                                                                    <tr>
                                                                        <td data-title="#"><?php echo $detalles['re_cod']; ?></td>
                                                                        <td data-title="Medicamentos"><?php echo $detalles['medi_descri']; ?></td>
                                                                        <td data-title="Indicaciones"><?php echo $detalles['re_indi']; ?></td>
                                                                        <td data-title="Hora"><?php echo $detalles['hora']; ?></td>
                                                                        <td data-title="Dosis"><?php echo $detalles['dosis']; ?></td>
                                                                        <td data-title="Cantidad"><?php echo $detalles['det_cantidad']; ?></td>
                                                                        <td class="text-center">
                                                                            <a onclick="editar(<?php echo $detalles['re_cod']; ?>, <?php echo $detalles['medi_cod']; ?>)"
                                                                               class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a> 
                                                                            <a onclick="borrar('<?php echo $detalles['re_cod'] . "_" . $detalles['medi_cod']; ?>')"
                                                                               data-toggle="modal" data-target="#borrar" class="btn btn-danger btn-sm" role="button" data-title="Quitar" rel="tooltip" data-placement="top">
                                                                                <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr> 
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                Lo agregado aún no tiene detalle
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>

                                <!--Fin de detalle -->
                                <div class="box-body">
                                    <form action="recetasindicacionesdetalle_control.php" method="post">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="vre_cod"value="<?php echo $recetas[0]['re_cod'] ?>"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-header text-center" style="background-color: #28a745; color: #ffffff;">
                                                    COMPLETA LOS DATOS DEL DETALLE
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="vmedi_cod">Medicamentos:</label>
                                                <?php
                                                $medicamentos = consultas::get_datos("SELECT * FROM v_medicamentostipo ORDER BY medi_cod");
                                                ?>
                                                <select class="form-control" name="vmedi_cod" required id="vmedi_cod">
                                                    <option value="0">Seleccionar Medicamentos</option>
                                                    <?php foreach ($medicamentos as $med) : ?>
                                                        <option value="<?php echo $med['medi_cod']; ?>"><?php echo $med['medi_descri']; ?> -
                                                            <?php echo $med['tipomedi_descri']; ?> <?php endforeach; ?>
                                                </select>
                                                <div id="doctores"></div>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Indicaciones</label>
                                                <input type="text" class="form-control" name="vre_indi" id="vdetalle_obser" >
                                            </div>
                                            <div class="col-md-3">
                                                <label>Observaciones</label>
                                                <input type="text" class="form-control" name="vre_observ" id="vdetalle_obser" >
                                            </div>

                                            <div class="col-md-3">
                                                <label>HORA:</label>
                                                <input type="time" class="form-control" name="vhora" value="07:00">
                                            </div>
                                            <br>
                                            <div class="col-md-3">
                                                <label>Dosis:</label>
                                                <input type="text" class="form-control" name="vdosis" value="1">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Cantidad:</label>
                                                <input type="numeric" class="form-control" name="vcantidad" value="1">
                                            </div>


                                        </div>
                                        <div class="box-footer">
                                            <a href="tratamiento_index.php" class="btn btn-default">
                                                <i class="fas fa-times"></i> CERRAR <!-- Utilizo el ícono 'times' de Font Awesome para cerrar -->
                                            </a> 
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <i class="fas fa-save"></i> Registrar <!-- Utilizo el ícono 'save' de Font Awesome para registrar -->
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
            <!-- INICIO MODAL confirmar-->

            <!-- fin MODAL confirmar-->
            <div class="modal" id="borrar" role="dialog">
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
            <!-- FIN MODAL BORRAR--> 
            <!-- MODAL EDITAR-->
            <div class="modal" id="editar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" id="detalles"></div>
                </div>
            </div>
            <!-- FIN MODAL EDITAR-->
        </div>   
        <?php require 'menu/js_lte.ctp'; ?> 
        <script>
            function borrar(datos) {
                var dat = datos.split('_');
                $('#si').attr('href', 'recetasindicacionesdetalle_control.php?vre_cod=' + dat[0] + '&vmedi_cod=' + dat[1] + '&accion=2');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
        Deseas Borrar el detalle de la Receta/Indicacion N° <strong>' + dat[0] + '</strong> ?');
            }

            function editar(consulta, sintomas) {
                $.ajax({
                    type: "GET",
                    url: "recetasdetalle_modificar.php?vre_cod=" + consulta + "&vmedi_cod=" + sintomas,
                    cache: false,
                    beforeSend: function () {
                        $("#detalles").html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                    },
                    success: function (data) {
                        $("#detalles").html(data)
                    }
                })
            }
            ;
        </script>

        <script>
            $('#mensaje').delay(4000).slideUp(200, function () {
                $(this).alert('close');
            }
            );
        </script><!-- Agrega tus scripts JavaScript si es necesario -->
    </body>
</html>

