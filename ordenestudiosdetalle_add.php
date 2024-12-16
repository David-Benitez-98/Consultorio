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
                                    <h3 class="box-title">AGREGAR DETALLE DE ORDEN DE ESTUDIO</h3>
                                    <div class="box-tools">
                                        <a href="ordenestudios_index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                     <div class="buttons-container">
                                        <a href="diagnostico_add.php" class="btn btn-success btn-secondary"
                                           data-title="Agregar" rel="tooltip"> <i class="fa fa-plus">  </i>Diagnostico</a>
                                    </div>
                                </div>
                                <!--Inicio de cabecera -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                        <?php
                                        $consulta = consultas::get_datos("select * FROM v_consultadetalle WHERE cod_consulta = (select max(cod_consulta) from v_consultadetalle)");
                                        if (!empty($consulta)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Paciente</th>
                                                            <th>Tipo de Consulta</th>
                                                            <th>Motivo</th>
                                                            <th>Sintoma</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($consulta as $consul) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $consul['cod_consulta']; ?></td>
                                                                <td data-title="Fecha"><?php echo $consul['con_fecha']; ?></td>
                                                                <td data-title="Paciente"><?php echo $consul['paciente']; ?></td>
                                                                <td data-title="Tipo de Consulta"><?php echo $consul['tipcon_descri']; ?></td>
                                                                <td data-title="Motivo"><?php echo $consul['con_motivo']; ?></td>
                                                                <td data-title="Sintomas"><?php echo $consul['sin_descri']; ?></td>

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
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                                                     
                                        <?php
                                        $ordenestudios = consultas::get_datos("select * FROM v_ordenestudio WHERE oe_cod = (select max(oe_cod) from v_ordenestudio)");
                                        if (!empty($ordenestudios)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">

                                                    <tbody>
                                                        <?php foreach ($ordenestudios as $oe) { ?>
                                                            <tr>
                                                                <td  class="oe_cod"><?php echo $oe['oe_cod']; ?></td>
                                                            </tr>  
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--Fin de cabecera -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                               
                                        <?php
                                        $detalletratamientos = consultas::get_datos("select * from v_ordenestudiosdetalle where oe_cod= " . $_REQUEST['voe_cod']);
                                        if (!empty($detalletratamientos)) {
                                            ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalle Orden de Estudios</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tipo de Orden de Estudio</th>
                                                            <th>Observacion</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalletratamientos as $detalles) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $detalles['oe_cod']; ?></td>
                                                                <td data-title="Doctor"><?php echo $detalles['tipooe_descri']; ?></td>
                                                                <td data-title="Especialidad"><?php echo $detalles['observacion']; ?></td>
                                                                <td class="text-center">

                                                                    <a onclick="editar(<?php echo $detalles['oe_cod']; ?>, <?php echo $detalles['tipooe_cod']; ?>)"
                                                                       class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> 
                                                                    <a onclick="borrar('<?php echo $detalles['oe_cod'] . "_" . $detalles['tipooe_cod']; ?>')" 
                                                                       data-toggle="modal" data-target="#borrar" class="btn btn-danger btn-sm" role="button" data-title="Quitar" rel="tooltip" data-placement="top">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr> 
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                Orden de Estudio aún no tiene detalle
                                            </div>      
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <form action="ordenestudiosdetalle_control.php" method="post">
                                        <input type="hidden" name="accion" value="1">
                                        <input type="hidden" name="voe_cod"  value="<?php echo $ordenestudios[0]['oe_cod'] ?>"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-header text-center" style="background-color: #28a745; color: #ffffff;">
                                                    COMPLETA LOS DATOS DEL DETALLE
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="vtipooe_cod">Tipo de Estudios:</label>
                                                <?php
                                                $tipoestudio = consultas::get_datos("SELECT * FROM v_tipo_ordenestudio ORDER BY tipooe_cod");
                                                ?>
                                                <select class="form-control" name="vtipooe_cod" required id="vtipooe_cod">
                                                    <option value="0">Seleccionar Tipo de Estudio</option>
                                                    <?php foreach ($tipoestudio as $tipoe) : ?>
                                                        <option value="<?php echo $tipoe['tipooe_cod']; ?>"><?php echo $tipoe['tipooe_descri']; ?> </option> - 
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Observacion</label>
                                                <input type="text" value="SIN OBSERVACION" class="form-control" name="vobservacion" id="vobservacion" >
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="ordenestudios_index.php" class="btn btn-default">
                                                <i class="fa fa-remove"></i> CERRAR
                                            </a> 
                                            <button type="submit" class="btn btn-primary pull-right">
                                                <span class="glyphicon glyphicon-floppy-saved"></span> Registrar
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
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
            <!-- MODAL EDITAR-->
                <div class="modal" id="editar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content" id="detalles"></div>
                      </div>
                </div>
            <!-- FIN MODAL EDITAR-->
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
        <script>  
            
            function remover(tr) {
                $(tr).remove();
            }
            
            function borrar(datos) {
                var dat = datos.split('_');
                $('#si').attr('href', 'ordenestudiosdetalle_control.php?voe_cod=' + dat[0] + '&vtipooe_cod=' + dat[1] + '&accion=2');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
        Deseas Borrar el detalle de la Orden de Estudio N° <strong>' + dat[0] + '</strong> ?');
            }
            function editar(oe_cod,tipooe_cod){
            $.ajax({
                type    : "GET",
                url     : "ordenestudiodetalle_modificar.php?voe_cod="+oe_cod+"&vtipooe_cod="+tipooe_cod,
                cache   : false,
                beforeSend:function(){
                    $("#detalles").html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
                },
                success:function(data){
                    $("#detalles").html(data)
                }
            })
        };
        
        </script>
    </body>
</html>

